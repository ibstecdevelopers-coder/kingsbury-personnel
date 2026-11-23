<?php
function turnstile_ok(): bool {
    $token = $_POST['cf-turnstile-response'] ?? '';
    if ($token === '') return false;
    $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => http_build_query([
            'secret'   => '0x4AAAAAAF_x1xnhacOdNHd1Kl95dkmYbcw',  // keep in config, not in page code
            'response' => $token,
            'remoteip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]),
    ]);
    $res = json_decode(curl_exec($ch), true);
    return !empty($res['success']);
}
