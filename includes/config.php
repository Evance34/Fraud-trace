<?php
/*
====================================================
Fraud Trace Configuration File
====================================================
*/

date_default_timezone_set('America/Chicago');

/*
====================================================
Website Information
====================================================
*/

define('SITE_NAME', 'Fraud Trace');

define('SITE_URL', 'https://www.fraudtrace.com'); // Change to your real domain

define('COMPANY_EMAIL', 'support@fraudtrace.com');

define('COMPANY_PHONE', '+1 (216) 245-5626');

define('COMPANY_ADDRESS', '703 Oak Street, La Crosse, Kansas');

/*
====================================================
Email Configuration
====================================================
Replace these with your real SMTP credentials.
Do NOT commit real passwords to public repositories.
====================================================
*/

define('SMTP_HOST', 'smtp.gmail.com');

define('SMTP_PORT', 587);

define('SMTP_USERNAME', 'thegrowthn@gmail.com');

define('SMTP_PASSWORD', 'siojiqvgaufjmewo');

define('SMTP_ENCRYPTION', 'tls');

/*
====================================================
Uploads
====================================================
*/

define('UPLOAD_PATH', __DIR__ . '/../uploads/');

define('MAX_FILE_SIZE', 10 * 1024 * 1024); // 10 MB

$allowedExtensions = [

    'jpg',

    'jpeg',

    'png',

    'pdf',

    'doc',

    'docx',

    'txt',

    'zip'

];

/*
====================================================
Reference Number Generator
====================================================
Example:
FT-20260716-483921
====================================================
*/

function generateReferenceNumber()
{
    return 'FT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
}

/*
====================================================
Security Helpers
====================================================
*/

function cleanInput($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

/*
====================================================
Validate Uploaded File
====================================================
*/

function isAllowedFile($filename)
{
    global $allowedExtensions;

    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

    return in_array($extension, $allowedExtensions);
}
?>
