<?php

/**
 * Application email settings.
 *
 * Recipient is Daniel. For reliable delivery on XAMPP/Windows, set
 * smtp.enabled to true and fill in the mailbox credentials below.
 * On most Linux/cPanel hosts, PHP mail() works with smtp.enabled = false.
 */
return [
    'to_email' => 'UPDATE_YOUR_EMAIL_HERE',
    'to_name' => 'UPDATE_YOUR_NAME_HERE',
    'from_email' => 'UPDATE_YOUR_EMAIL_HERE',
    'from_name' => 'UPDATE_YOUR_PROJECT_NAME_HERE',
    'reply_to_email' => 'UPDATE_YOUR_EMAIL_HERE',
    'reply_to_name' => 'UPDATE_YOUR_PROJECT_NAME_HERE',

    'smtp' => [
        'enabled' => true,
        'host' => 'smtp.ionos.co.uk',
        'port' => 465,
        'encryption' => 'ssl',
        'username' => 'UPDATE_YOUR_USERNAME_HERE',
        'password' => 'UPDATE_YOUR_PASSWORD_HERE',
    ],
];
