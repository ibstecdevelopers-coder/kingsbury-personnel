<?php

/**
 * Kingsbury Personnel - Visitor country helper
 * ------------------------------------------------------------------
 * Works out the visitor's country so tracking (Meta Pixel) can be
 * switched off for regions we do not want to count.
 *
 * Lookup order:
 *   1. ?kp_geo=XX query string   (manual override for testing)
 *   2. CDN / server geo header   (Cloudflare, LiteSpeed/Apache GeoIP)
 *   3. ipinfo.io lookup, cached on disk per IP for a day
 *
 * Any failure returns '' so tracking keeps working as normal.
 */

if (!defined('KP_PIXEL_BLOCKED_COUNTRIES')) {
    define('KP_PIXEL_BLOCKED_COUNTRIES', ['PK']);
}

define('KP_GEO_CACHE_DIR', __DIR__ . '/../cache/geo');
define('KP_GEO_CACHE_TTL', 86400);
define('KP_GEO_TIMEOUT', 2);

/** Best guess at the real client IP. */
function kp_client_ip()
{
    $candidates = [
        $_SERVER['HTTP_CF_CONNECTING_IP'] ?? '',
        trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]),
        $_SERVER['REMOTE_ADDR'] ?? '',
    ];

    foreach ($candidates as $ip) {
        if ($ip !== '' && filter_var($ip, FILTER_VALIDATE_IP)) {
            return $ip;
        }
    }
    return '';
}

/** Two-letter ISO country code of the visitor, or '' if unknown. */
function kp_visitor_country()
{
    static $country = null;
    if ($country !== null) {
        return $country;
    }

    // --- 1. manual override -------------------------------------------
    if (isset($_GET['kp_geo']) && preg_match('/^[A-Za-z]{2}$/', $_GET['kp_geo'])) {
        return $country = strtoupper($_GET['kp_geo']);
    }

    // --- 2. headers set by a CDN or the web server --------------------
    foreach (['HTTP_CF_IPCOUNTRY', 'GEOIP_COUNTRY_CODE', 'HTTP_X_COUNTRY_CODE'] as $key) {
        $code = strtoupper(trim($_SERVER[$key] ?? ''));
        if (preg_match('/^[A-Z]{2}$/', $code) && $code !== 'XX') {
            return $country = $code;
        }
    }

    // --- 3. IP lookup -------------------------------------------------
    // Local / private IPs (e.g. XAMPP on localhost) can't be located here;
    // cookie-consent.html then asks from the browser instead.
    $ip = kp_client_ip();
    $isPublic = $ip !== '' && filter_var(
        $ip,
        FILTER_VALIDATE_IP,
        FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
    );
    if (!$isPublic) {
        return $country = '';
    }

    if (!is_dir(KP_GEO_CACHE_DIR)) {
        @mkdir(KP_GEO_CACHE_DIR, 0775, true);
    }
    $cacheFile = KP_GEO_CACHE_DIR . '/' . md5($ip) . '.txt';
    if (is_file($cacheFile) && (time() - filemtime($cacheFile)) < KP_GEO_CACHE_TTL) {
        return $country = (string) file_get_contents($cacheFile);
    }

    $url = 'https://ipinfo.io/' . rawurlencode($ip) . '/country';
    $body = false;

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => KP_GEO_TIMEOUT,
            CURLOPT_CONNECTTIMEOUT => KP_GEO_TIMEOUT,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_USERAGENT      => 'KingsburyPersonnel/1.0',
        ]);
        $body = curl_exec($ch);
        if ((int) curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            $body = false;
        }
        curl_close($ch);
    } else {
        $ctx  = stream_context_create(['http' => ['timeout' => KP_GEO_TIMEOUT]]);
        $body = @file_get_contents($url, false, $ctx);
    }

    $code = strtoupper(trim((string) $body));
    if (!preg_match('/^[A-Z]{2}$/', $code)) {
        // lookup failed: don't cache, try again on the next page view
        return $country = '';
    }

    @file_put_contents($cacheFile, $code, LOCK_EX);
    return $country = $code;
}

/** True when the Meta Pixel must not load or fire for this visitor. */
function kp_block_meta_pixel()
{
    return in_array(kp_visitor_country(), KP_PIXEL_BLOCKED_COUNTRIES, true);
}
