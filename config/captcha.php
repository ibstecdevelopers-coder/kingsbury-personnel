<?php

/**
 * Google reCAPTCHA v2 configuration.
 *
 * Configure keys with KP_RECAPTCHA_SITE_KEY and KP_RECAPTCHA_SECRET_KEY in
 * the PHP/Apache environment, or return site_key and secret_key from the
 * ignored config/captcha.local.php file for local development.
 */
$localConfigPath = __DIR__ . '/captcha.local.php';
$localConfig = [];
if (is_file($localConfigPath)) {
    $localConfigResult = require $localConfigPath;
    if (is_array($localConfigResult)) {
        $localConfig = $localConfigResult;
    } elseif (isset($KP_RECAPTCHA_SITE_KEY) || isset($KP_RECAPTCHA_SECRET_KEY) || isset($KP_RECAPTCHA_HOSTNAMES)) {
        $localConfig = [
            'site_key' => $KP_RECAPTCHA_SITE_KEY ?? '',
            'secret_key' => $KP_RECAPTCHA_SECRET_KEY ?? '',
            'allowed_hostnames' => $KP_RECAPTCHA_HOSTNAMES ?? [],
        ];
    } else {
        throw new RuntimeException('config/captcha.local.php must return an array or define the KP_RECAPTCHA_* variables.');
    }
}

$siteKey = getenv('KP_RECAPTCHA_SITE_KEY');
$secretKey = getenv('KP_RECAPTCHA_SECRET_KEY');
$configuredHostnames = getenv('KP_RECAPTCHA_HOSTNAMES');
$localHostnames = $localConfig['allowed_hostnames'] ?? [];
$defaultHostnames = ['kingsburypersonnel.com', 'www.kingsburypersonnel.com', 'localhost', '127.0.0.1'];
$extraHostnames = $configuredHostnames !== false && $configuredHostnames !== ''
    ? explode(',', $configuredHostnames)
    : ($localHostnames !== []
        ? (is_array($localHostnames) ? $localHostnames : explode(',', (string) $localHostnames))
        : []);
// Always keep the production hostnames (www and non-www) so a local override can never lock them out.
$hostnames = array_merge($defaultHostnames, $extraHostnames);

return [
    'site_key' => trim((string) (($siteKey !== false && $siteKey !== '')
        ? $siteKey
        : ($localConfig['site_key'] ?? ''))),
    'secret_key' => trim((string) (($secretKey !== false && $secretKey !== '')
        ? $secretKey
        : ($localConfig['secret_key'] ?? ''))),
    'allowed_hostnames' => array_values(array_unique(array_filter(array_map(
        static fn(string $hostname): string => strtolower(trim($hostname)),
        $hostnames
    )))),
];
