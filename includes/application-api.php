<?php

/**
 * Kingsbury Personnel - Candidate application API forwarder
 * ------------------------------------------------------------------
 * POSTs each contact-form candidate application to the CRM as JSON,
 * with the CV embedded as base64. Uses the same base URL and Bearer
 * token as the jobs API (includes/jobs-api.php).
 *
 *   POST {KP_API_BASE}{KP_APPLICATION_API_PATH}
 *   Content-Type: application/json
 *   Authorization: Bearer {KP_API_TOKEN}
 */

require_once __DIR__ . '/jobs-api.php';

if (!defined('KP_APPLICATION_API_PATH')) {
    // >>> Change this to the CRM route that accepts website applications. <<<
    // define('KP_APPLICATION_API_PATH', '/store/applicant/lead');
    define('KP_APPLICATION_API_PATH', '/applicants/create');
}
if (!defined('KP_APPLICATION_API_TIMEOUT')) {
    define('KP_APPLICATION_API_TIMEOUT', 20);
}

/**
 * Send the application payload to the CRM.
 *
 * @return array{ok:bool, status:int, error:?string, body:string}
 */
function kp_api_post_application(array $payload): array
{
    $url = rtrim(KP_API_BASE, '/') . '/' . ltrim(KP_APPLICATION_API_PATH, '/');
    $json = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if ($json === false) {
        return ['ok' => false, 'status' => 0, 'error' => 'Could not encode payload: ' . json_last_error_msg(), 'body' => ''];
    }

    $headers = [
        'Accept: application/json',
        'Content-Type: application/json',
    ];
    if (KP_API_TOKEN !== '') {
        $headers[] = 'Authorization: Bearer ' . KP_API_TOKEN;
    }

    $body = false;
    $status = 0;
    $err = null;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $json,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => KP_APPLICATION_API_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => 8,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT      => 'KingsburyPersonnel/1.0',
        ]);
        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($body === false) {
            $err = curl_error($ch);
        }
        curl_close($ch);
    } else {
        $ctx = stream_context_create(['http' => [
            'method'        => 'POST',
            'header'        => implode("\r\n", $headers),
            'content'       => $json,
            'timeout'       => KP_APPLICATION_API_TIMEOUT,
            'ignore_errors' => true,
        ]]);
        $body = @file_get_contents($url, false, $ctx);
        if (isset($http_response_header[0]) && preg_match('/\s(\d{3})\s/', $http_response_header[0], $m)) {
            $status = (int) $m[1];
        }
        if ($body === false) {
            $err = 'file_get_contents() request failed';
        }
    }

    if ($body === false) {
        return ['ok' => false, 'status' => $status, 'error' => $err ?: 'Request failed', 'body' => ''];
    }
    if ($status < 200 || $status >= 300) {
        return ['ok' => false, 'status' => $status, 'error' => 'API returned HTTP ' . $status, 'body' => (string) $body];
    }

    return ['ok' => true, 'status' => $status, 'error' => null, 'body' => (string) $body];
}

/**
 * Build the JSON payload for a candidate application.
 *
 * @param array       $fields           Sanitised form fields from send-application.php
 * @param array|null  $cv               The $_FILES['cv'] entry (already validated)
 * @param string      $cvMimeType       MIME type for the CV
 * @param string|null $disqualifyReason null when eligible
 */
function kp_build_application_payload(array $fields, ?array $cv, string $cvMimeType, ?string $disqualifyReason): array
{
    $cvBase64 = null;
    if ($cv && is_uploaded_file((string) ($cv['tmp_name'] ?? ''))) {
        $contents = file_get_contents((string) $cv['tmp_name']);
        if ($contents !== false) {
            $cvBase64 = base64_encode($contents);
        }
    }

    $saleId = '';
    if ($fields['saleUrl'] !== '' && preg_match('~/sales/([^/]+)/history~', $fields['saleUrl'], $m)) {
        $saleId = rawurldecode($m[1]);
    }

    // Keys match the CRM's validation rules (same names as the website form fields).
    return [
        'source'                  => 'kingsburypersonnel.com',
        'form'                    => 'candidate_application',
        'submitted_at'            => (new DateTimeImmutable('now', new DateTimeZone('Europe/London')))->format(DATE_ATOM),
        'fullName'                => $fields['fullName'],
        'email'                   => $fields['email'],
        'phone'                   => $fields['phone'],
        'specialism'              => $fields['specialism'],
        'experience'              => $fields['experience'],
        'sponsorship'             => $fields['sponsorship'],
        'ukResident'              => $fields['ukResident'],
        'visaStatus'              => $fields['visaStatus'],
        'postcode'                => $fields['postcode'],
        'nmcRegistered'           => $fields['nmcRegistered'] !== '' ? $fields['nmcRegistered'] : null,
        'nmcPin'                  => $fields['nmcPin'] !== '' ? $fields['nmcPin'] : null,
        'eligible'                => $disqualifyReason === null,
        'disqualification_reason' => $disqualifyReason,
        'saleId'                  => $saleId !== '' ? $saleId : null,
        'saleUrl'                 => $fields['saleUrl'] !== '' ? $fields['saleUrl'] : null,
        'cv_base64'               => $cvBase64,
        'cv_filename'             => $cv ? (string) $cv['name'] : null,
        'cv_mime_type'            => $cvMimeType,
    ];
}
