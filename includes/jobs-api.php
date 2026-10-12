<?php

/**
 * Kingsbury Personnel - Jobs API helper
 * ------------------------------------------------------------------
 * Wraps the two Laravel endpoints:
 *   GET {BASE}/sales/open/kingsburypersonnel       -> all open jobs
 *   GET {BASE}/sales/details/{id}  -> one job
 *
 * Include this file from search-job.php and job-details.php.
 */

/* ------------------------------------------------------------------
 * 1. CONFIG  -- change these three lines only
 * ---------------------------------------------------------------- */
if (!defined('KP_API_BASE')) {
    // No trailing slash. If your routes sit inside routes/api.php the
    // prefix is usually /api, e.g. https://crm.kingsburypersonnel.com/api
    define('KP_API_BASE', 'http://103.207.85.42:8080/api');
}
if (!defined('KP_API_TOKEN')) {
    define('KP_API_TOKEN', 'v8Kq2mZ7xP4nR9tL6wY3cF1sD5hJ0uA8eG2bN7qX9mV4pT6z');      // leave '' if the endpoints are public
}
if (!defined('KP_CACHE_TTL')) {
    define('KP_CACHE_TTL', 300);     // seconds; 0 disables caching
}

define('KP_CACHE_DIR', __DIR__ . '/../cache');
define('KP_API_TIMEOUT', 20);

/* ------------------------------------------------------------------
 * 2. LOW LEVEL REQUEST
 * ---------------------------------------------------------------- */

/**
 * GET a path on the API and return the decoded body.
 *
 * @return array{ok:bool, data:mixed, error:?string}
 */
function kp_api_get($path, $ttl = null)
{
    $ttl = ($ttl === null) ? KP_CACHE_TTL : (int) $ttl;
    $url = rtrim(KP_API_BASE, '/') . '/' . ltrim($path, '/');

    // --- cache read ---------------------------------------------------
    $cacheFile = null;
    if ($ttl > 0) {
        if (!is_dir(KP_CACHE_DIR)) {
            @mkdir(KP_CACHE_DIR, 0775, true);
        }
        $cacheFile = KP_CACHE_DIR . '/kp_' . md5($url) . '.json';
        if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < $ttl) {
            $cached = json_decode((string) file_get_contents($cacheFile), true);
            if (is_array($cached)) {
                return ['ok' => true, 'data' => $cached, 'error' => null];
            }
        }
    }

    // --- request ------------------------------------------------------
    $headers = ['Accept: application/json'];
    if (KP_API_TOKEN !== '') {
        $headers[] = 'Authorization: Bearer ' . KP_API_TOKEN;
    }

    $body   = false;
    $status = 0;
    $err    = null;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_TIMEOUT        => KP_API_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT      => 'KingsburyPersonnel/1.0',
        ]);
        $body   = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($body === false) {
            $err = curl_error($ch);
        }
        curl_close($ch);
    } else {
        // fallback if cURL is not compiled in
        $ctx = stream_context_create(['http' => [
            'method'        => 'GET',
            'header'        => implode("\r\n", $headers),
            'timeout'       => KP_API_TIMEOUT,
            'ignore_errors' => true,
        ]]);
        $body = @file_get_contents($url, false, $ctx);
        if (
            isset($http_response_header[0]) &&
            preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)
        ) {
            $status = (int) $m[1];
        }
        if ($body === false) {
            $err = 'file_get_contents() request failed';
        }
    }

    if ($body === false) {
        return ['ok' => false, 'data' => null, 'error' => $err ?: 'Request failed'];
    }
    if ($status >= 400) {
        return ['ok' => false, 'data' => null, 'error' => 'API returned HTTP ' . $status];
    }

    $decoded = json_decode($body, true);
    if (!is_array($decoded)) {
        return ['ok' => false, 'data' => null, 'error' => 'Invalid JSON from API'];
    }

    if ($cacheFile) {
        @file_put_contents($cacheFile, json_encode($decoded), LOCK_EX);
    }

    return ['ok' => true, 'data' => $decoded, 'error' => null];
}

/* ------------------------------------------------------------------
 * 3. SHAPE HELPERS
 * ---------------------------------------------------------------- */

/** Pull the first non-empty value out of a row for any of $keys. */
function kp_pick(array $row, array $keys, $default = '')
{
    foreach ($keys as $key) {
        if (!array_key_exists($key, $row)) {
            continue;
        }
        $val = $row[$key];
        if (is_array($val)) {                  // e.g. "branch": {"name": "..."}
            foreach (['name', 'title', 'label', 'value'] as $inner) {
                if (!empty($val[$inner])) {
                    return trim((string) $val[$inner]);
                }
            }
            continue;
        }
        if ($val !== null && trim((string) $val) !== '') {
            return trim((string) $val);
        }
    }
    return $default;
}

/**
 * The list endpoint may return a bare array, {data:[...]}, {sales:[...]},
 * or a paginator. This finds the rows wherever they are.
 */
function kp_extract_rows($payload)
{
    if (!is_array($payload)) {
        return [];
    }
    if (isset($payload[0]) && is_array($payload[0])) {
        return $payload;
    }
    foreach (['data', 'sales', 'jobs', 'results', 'items', 'records'] as $key) {
        if (isset($payload[$key]) && is_array($payload[$key])) {
            return kp_extract_rows($payload[$key]);   // handles {data:{data:[...]}}
        }
    }
    return [];
}

/** The details endpoint may wrap the single object the same way. */
function kp_extract_row($payload)
{
    if (!is_array($payload)) {
        return [];
    }
    foreach (['data', 'sale', 'job', 'result', 'record'] as $key) {
        if (isset($payload[$key]) && is_array($payload[$key])) {
            return kp_extract_row($payload[$key]);
        }
    }
    return $payload;
}

/**
 * Map an API row onto the fields the page renders.
 * >>> If your API uses different keys, edit the arrays below. <<<
 */
function kp_normalize_job(array $row)
{
    $salary = kp_pick($row, ['salary', 'pay', 'rate', 'pay_rate', 'hourly_rate', 'salary_range']);
    if ($salary === '') {
        $from = kp_pick($row, ['salary_from', 'salary_min', 'rate_from', 'min_salary']);
        $to   = kp_pick($row, ['salary_to', 'salary_max', 'rate_to', 'max_salary']);
        if ($from !== '' && $to !== '') {
            $salary = kp_money($from) . ' - ' . kp_money($to);
        } elseif ($from !== '') {
            $salary = 'From ' . kp_money($from);
        } elseif ($to !== '') {
            $salary = 'Up to ' . kp_money($to);
        }
    }

    $location = kp_pick($row, ['location', 'job_location', 'town', 'city', 'area', 'region', 'site']);
    $county   = kp_pick($row, ['county', 'state', 'district']);
    if ($location !== '' && $county !== '' && stripos($location, $county) === false) {
        $location .= ', ' . $county;
    }

    return [
        'id'          => kp_pick($row, ['id', 'sale_id', 'job_id', 'uuid', 'reference_id']),
        'reference'   => kp_pick($row, ['reference', 'ref', 'job_reference', 'code', 'sale_reference']),
        'title'       => kp_pick($row, ['title', 'job_title', 'name', 'position', 'role', 'vacancy_title'], 'Vacancy'),
        'location'    => $location,
        'postcode'    => kp_pick($row, ['postcode', 'post_code', 'zip']),
        'sector'      => kp_pick($row, ['sector', 'category', 'discipline', 'industry', 'department', 'specialism', 'division']),
        'type'        => kp_pick($row, ['type', 'job_type', 'employment_type', 'contract_type', 'contract', 'work_type', 'position_type', 'postype']),
        'hours'       => kp_pick($row, ['hours', 'working_hours', 'shift', 'shift_pattern', 'hours_per_week']),
        'salary'      => $salary,
        'summary'     => kp_pick($row, ['summary', 'short_description', 'experience', 'excerpt', 'intro', 'overview']),
        'description' => kp_pick($row, ['description', 'job_description', 'details', 'advert', 'full_description', 'body', 'content']),
        'requirements' => kp_pick($row, ['requirements', 'candidate_requirements', 'essential_criteria', 'qualification', 'skills']),
        'benefits'    => kp_pick($row, ['benefits', 'package', 'perks']),
        'start_date'  => kp_pick($row, ['start_date', 'starts_at', 'available_from']),
        'posted'      => kp_pick($row, ['created_at', 'posted_at', 'published_at', 'date_posted', 'live_date', 'created']),
        'consultant'  => kp_pick($row, ['consultant', 'owner', 'recruiter', 'contact_name', 'account_manager']),
        'raw'         => $row,
    ];
}

/** Fetch and normalise every open job. */
function kp_open_jobs()
{
    $res = kp_api_get('/sales/open/kingsburypersonnel');
    if (!$res['ok']) {
        return ['ok' => false, 'jobs' => [], 'error' => $res['error']];
    }
    $jobs = array_map('kp_normalize_job', kp_extract_rows($res['data']));
    // newest first where a date is available
    usort($jobs, function ($a, $b) {
        return strtotime($b['posted'] ?: '1970-01-01') <=> strtotime($a['posted'] ?: '1970-01-01');
    });
    return ['ok' => true, 'jobs' => $jobs, 'error' => null];
}

/** Fetch and normalise one job by id. */
function kp_job_details($id)
{
    $res = kp_api_get('/sales/details/' . rawurlencode($id), 120);
    if (!$res['ok']) {
        return ['ok' => false, 'job' => null, 'error' => $res['error']];
    }
    $row = kp_extract_row($res['data']);
    if (!$row) {
        return ['ok' => false, 'job' => null, 'error' => 'Job not found'];
    }
    return ['ok' => true, 'job' => kp_normalize_job($row), 'error' => null];
}

/* ------------------------------------------------------------------
 * 4. VIEW HELPERS
 * ---------------------------------------------------------------- */

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function kp_money($value)
{
    if (is_numeric($value)) {
        return '£' . number_format((float) $value, (fmod((float) $value, 1) == 0 ? 0 : 2));
    }
    return (string) $value;
}

/** "3 days ago" style label, empty string if the date is unusable. */
function kp_posted_label($date)
{
    if (!$date) {
        return '';
    }
    $ts = strtotime($date);
    if (!$ts) {
        return '';
    }
    $days = (int) floor((time() - $ts) / 86400);
    if ($days <= 0) {
        return 'Posted today';
    }
    if ($days === 1) {
        return 'Posted yesterday';
    }
    if ($days < 30) {
        return 'Posted ' . $days . ' days ago';
    }
    return 'Posted ' . date('j M Y', $ts);
}

/** Plain-text teaser from a possibly-HTML description. */
function kp_teaser($job, $length = 165)
{
    $text = $job['summary'] !== '' ? $job['summary'] : $job['description'];
    $text = trim(preg_replace('/\s+/', ' ', strip_tags((string) $text)));
    if ($text === '') {
        return '';
    }
    if (function_exists('mb_strlen') ? mb_strlen($text) <= $length : strlen($text) <= $length) {
        return $text;
    }
    $cut = function_exists('mb_substr') ? mb_substr($text, 0, $length) : substr($text, 0, $length);
    $sp  = strrpos($cut, ' ');
    return rtrim($sp ? substr($cut, 0, $sp) : $cut, ' ,.;:') . '…';
}

/**
 * Render a description field safely: allow basic formatting tags if the API
 * sends HTML, otherwise convert line breaks to paragraphs.
 */
function kp_rich_text($text)
{
    $text = (string) $text;
    if ($text === '') {
        return '';
    }
    if ($text !== strip_tags($text)) {
        return strip_tags($text, '<p><br><strong><b><em><i><u><ul><ol><li><h3><h4><h5><a>');
    }
    $parts = preg_split('/\n\s*\n/', trim($text));
    $out   = '';
    foreach ($parts as $part) {
        $out .= '<p>' . nl2br(e(trim($part))) . '</p>';
    }
    return $out;
}

/** Keep the current filters when building links. */
function kp_url_with(array $overrides = [])
{
    $params = array_merge($_GET, $overrides);
    foreach ($params as $k => $v) {
        if ($v === '' || $v === null) {
            unset($params[$k]);
        }
    }
    return 'search-job.php' . ($params ? '?' . http_build_query($params) : '');
}