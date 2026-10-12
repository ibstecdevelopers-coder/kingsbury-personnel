<?php

declare(strict_types=1);

use PHPMailer\PHPMailer\PHPMailer;

// Start session BEFORE sending headers or output
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

header('Content-Type: application/json; charset=UTF-8');
header('X-Content-Type-Options: nosniff');
sendCorsHeaders();

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(204);
  exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  respond(405, false, 'This endpoint only accepts form submissions.');
}

require __DIR__ . '/vendor/autoload.php';

$config = require __DIR__ . '/config/mail.php';
date_default_timezone_set('Europe/London');

if (!empty($_POST['kp_hp']) || !empty($_POST['website'])) {
  logMailEvent('Blocked honeypot submission; no email sent.');
  respond(200, true, 'Thank you. Your application has been sent to our recruitment team.');
}

$formType = trim((string) ($_POST['formType'] ?? $_POST['form_type'] ?? ''));
$fields = [
  'fullName' => trim((string) ($_POST['fullName'] ?? $_POST['full_name'] ?? '')),
  'specialism' => trim((string) ($_POST['specialism'] ?? $_POST['request_type'] ?? $_POST['role'] ?? '')),
  'experience' => trim((string) ($_POST['experience'] ?? $_POST['relationship'] ?? $_POST['work_type'] ?? '')),
  'email' => trim((string) ($_POST['email'] ?? '')),
  'phone' => trim((string) ($_POST['phone'] ?? '')),
  'sponsorship' => trim((string) ($_POST['sponsorship'] ?? $_POST['on_behalf'] ?? '')),
  'saleUrl' => trim((string) ($_POST['saleUrl'] ?? '')),
  'details' => trim((string) ($_POST['details'] ?? $_POST['message'] ?? '')),
  'relationship' => trim((string) ($_POST['relationship'] ?? '')),
  'jobTitle' => trim((string) ($_POST['job_title'] ?? '')),
  'organisation' => trim((string) ($_POST['organisation'] ?? '')),
  'location' => trim((string) ($_POST['location'] ?? '')),
  'setting' => trim((string) ($_POST['setting'] ?? '')),
];

$isEmployer = $formType === 'employer';
$isLead = $formType === 'lead';
$isDataRights = $formType === 'data_rights';
$leadName = trim((string) ($_POST['name'] ?? ''));
if ($isLead && $leadName !== '') {
  $fields['fullName'] = $leadName;
}

$errors = [];
$required = $isEmployer
  ? ['fullName', 'organisation', 'email', 'phone', 'specialism', 'experience', 'location', 'setting', 'details']
  : ($isLead
    ? ['fullName', 'specialism', 'email']
    : ($isDataRights ? ['fullName', 'email', 'specialism'] : ['fullName', 'specialism', 'experience', 'email']));

foreach ($required as $requiredField) {
  if ($fields[$requiredField] === '') {
    $errors[] = $requiredField;
  }
}

if ($isEmployer) {
  $employerOptions = [
    'specialism' => [
      'rgn' => 'Registered General Nurse (RGN)',
      'rmn' => 'Registered Mental Health Nurse (RMN)',
      'rnld' => 'Registered Learning Disability Nurse (RNLD)',
      'nurse-other' => 'Nurse, other specialism',
      'clinical-lead' => 'Clinical lead or senior nurse',
      'deputy-manager' => 'Deputy manager',
      'registered-manager' => 'Registered manager',
      'care-worker' => 'Care or support worker',
      'senior-care-worker' => 'Senior care worker or team leader',
      'nursery' => 'Nursery or early years practitioner',
      'chef' => 'Chef or kitchen role',
      'hospitality' => 'Hospitality role',
      'legal' => 'Solicitor or legal support',
    ],
    'experience' => [
      'permanent' => 'Permanent introduction',
      'temporary' => 'Temporary or contract worker',
      'either' => 'Not sure yet',
    ],
    'setting' => [
      'nursing-home' => 'Nursing home',
      'residential-care' => 'Residential care home',
      'supported-living' => 'Supported living',
      'mental-health' => 'Mental health or learning disability service',
      'community' => 'Community or domiciliary service',
      'nhs' => 'NHS organisation',
      'early-years' => 'Nursery or early years setting',
      'other' => 'Other',
    ],
  ];

  foreach ($employerOptions as $fieldName => $options) {
    if (!isset($options[$fields[$fieldName]])) {
      $errors[] = $fieldName;
      continue;
    }
    $fields[$fieldName] = $options[$fields[$fieldName]];
  }
}

if ($fields['email'] !== '' && !filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
  $errors[] = 'email';
}

foreach ($fields as $key => $value) {
  $maxLength = $isEmployer && $key === 'details' ? 3000 : 300;
  if (mb_strlen($value) > $maxLength) {
    $errors[] = $key;
  }
}

$cv = $_FILES['cv'] ?? null;
$allowedExtensions = ['pdf', 'doc', 'docx'];
$maxBytes = 10 * 1024 * 1024;
$cvExtension = '';
$cvName = '';
$cvSize = '';

if (!$isLead && !$isDataRights && !$isEmployer) {
  if (!$cv || ($cv['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
    $errors[] = 'cv';
  } elseif (($cv['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
    respond(400, false, 'Your CV could not be uploaded. Please try again with a PDF, DOC or DOCX file under 10MB.');
  } else {
    $cvExtension = strtolower(pathinfo((string) $cv['name'], PATHINFO_EXTENSION));
    if (!in_array($cvExtension, $allowedExtensions, true)) {
      respond(400, false, 'Please upload your CV as a PDF, DOC or DOCX file.');
    }
    if (($cv['size'] ?? 0) > $maxBytes) {
      respond(400, false, 'Your CV must be smaller than 10MB.');
    }
    if (!is_uploaded_file((string) $cv['tmp_name'])) {
      respond(400, false, 'The uploaded CV could not be verified. Please try again.');
    }
  }
}

if ($errors) {
  respond(422, false, $isLead
    ? 'Please complete your name, email and employment type before submitting.'
    : ($isDataRights
      ? 'Please complete the required fields before submitting your request.'
      : ($isEmployer
        ? 'Please complete all required employer request fields before submitting.'
        : 'Please complete the required fields and attach your CV before submitting.')));
}

$submittedAt = (new DateTimeImmutable())->format('l j F Y \a\t H:i');
$displayName = trim($fields['fullName']);
if (!$isLead && !$isDataRights && !$isEmployer) {
  $cvName = (string) $cv['name'];
  $cvSize = formatFileSize((int) $cv['size']);
}

try {
  $adminMail = createMailer($config);
  addAdminRecipients($adminMail, $config);

  if (filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
    $adminMail->addReplyTo($fields['email'], $displayName);
  }

  $adminMail->isHTML(true);
  if ($isEmployer) {
    $adminMail->Subject = sprintf(
      'New Employer Staffing Request — %s',
      $displayName
    );
    $adminMail->Body = buildEmployerHtmlEmail($fields, $displayName, $submittedAt);
    $adminMail->AltBody = buildEmployerTextEmail($fields, $displayName, $submittedAt);
  } elseif ($isDataRights) {
    $adminMail->Subject = sprintf(
      'New Data Rights Request — %s',
      $displayName
    );
    $adminMail->Body = buildDataRightsHtmlEmail($fields, $displayName, $submittedAt);
    $adminMail->AltBody = buildDataRightsTextEmail($fields, $displayName, $submittedAt);
  } elseif ($isLead) {
    $adminMail->Subject = sprintf(
      'New Candidate Lead — %s (%s)',
      $displayName,
      $fields['specialism']
    );
    $adminMail->Body = buildLeadHtmlEmail($fields, $displayName, $submittedAt);
    $adminMail->AltBody = buildLeadTextEmail($fields, $displayName, $submittedAt);
  } else {
    $adminMail->Subject = sprintf(
      'New Candidate Application — %s (%s)',
      $displayName,
      $fields['specialism']
    );
    $adminMail->Body = buildHtmlEmail($fields, $displayName, $cvName, $cvSize, $submittedAt);
    $adminMail->AltBody = buildTextEmail($fields, $displayName, $cvName, $cvSize, $submittedAt);
    $adminMail->addAttachment(
      (string) $cv['tmp_name'],
      $cvName,
      PHPMailer::ENCODING_BASE64,
      attachmentMimeType($cvExtension)
    );
  }
  $adminMail->send();

  // Store only the details needed by the thank-you page after admin delivery succeeds.
  $_SESSION['form_submitted'] = true;
  $_SESSION['submitted_application'] = [
    'name' => $displayName,
    'email' => $fields['email'],
    'specialism' => $fields['specialism'],
    'type' => $isEmployer ? 'employer' : ($isLead ? 'lead' : 'application'),
  ];

  $sentTo = array_map(static fn(array $row): string => (string) $row[0], $adminMail->getToAddresses());
  $submissionType = $isEmployer ? 'employer request' : ($isLead ? 'lead' : 'application');
  logMailEvent('Sent ' . $submissionType . ' to ' . implode(', ', $sentTo));

  $confirmationSent = false;
  if (!$isDataRights) {
    try {
      $visitorMail = createMailer($config);
      $visitorMail->addAddress($fields['email'], $displayName);
      $visitorMail->isHTML(true);
      if ($isEmployer) {
        $visitorMail->Subject = 'We have received your staffing request';
        $visitorMail->Body = buildEmployerConfirmationHtmlEmail($fields, $displayName, $submittedAt);
        $visitorMail->AltBody = buildEmployerConfirmationTextEmail($fields, $displayName, $submittedAt);
      } elseif ($isLead) {
        $visitorMail->Subject = 'We have received your details';
        $visitorMail->Body = buildLeadCandidateHtmlEmail($fields, $displayName, $submittedAt);
        $visitorMail->AltBody = buildLeadCandidateTextEmail($fields, $displayName, $submittedAt);
      } else {
        $visitorMail->Subject = 'Thank you for your application';
        $visitorMail->Body = buildCandidateHtmlEmail($fields, $displayName, $submittedAt);
        $visitorMail->AltBody = buildCandidateTextEmail($fields, $displayName, $submittedAt);
      }
      if (!$isEmployer) {
        $wellbeingGuide = __DIR__ . '/assets/pdfs/Kingsbury Personnel Wellbeing Guide.pdf';
        if (!is_file($wellbeingGuide)) {
          throw new \RuntimeException('The candidate wellbeing guide attachment is missing.');
        }
        $visitorMail->addAttachment($wellbeingGuide, 'Kingsbury Personnel Wellbeing Guide.pdf');
      }
      $visitorMail->send();
      $confirmationSent = true;
      $confirmationType = $isEmployer ? 'employer request' : ($isLead ? 'candidate lead' : 'candidate application');
      logMailEvent('Sent ' . $confirmationType . ' confirmation to ' . $fields['email']);
    } catch (\Throwable $e) {
      $detail = $e->getMessage();
      if (isset($visitorMail) && $visitorMail->ErrorInfo) {
        $detail .= ' | ' . $visitorMail->ErrorInfo;
      }
      $confirmationType = $isEmployer ? 'employer request' : ($isLead ? 'candidate lead' : 'candidate application');
      logMailError(ucfirst($confirmationType) . ' reached admin, but visitor confirmation failed: ' . $detail);
    }
  } else {
    logMailEvent('Data rights request sent only to admin inbox; visitor confirmation not applicable.');
  }

  $successMessage = $isEmployer
    ? 'Your staffing request was sent to our team.'
    : ($isLead
      ? 'Your details were sent to our team.'
      : ($isDataRights
        ? 'Your data rights request was sent to our team.'
        : 'Your application was sent to our recruitment team.'));

  if ($confirmationSent) {
    $successMessage .= ' A confirmation email has been sent to you.';
  } elseif (!$isDataRights) {
    $successMessage .= ' We could not send your confirmation email; please contact us if you need confirmation.';
  }

  respond(200, true, $successMessage);
} catch (\Throwable $e) {
  $detail = $e->getMessage();
  if (isset($adminMail) && $adminMail->ErrorInfo) {
    $detail .= ' | ' . $adminMail->ErrorInfo;
  }
  logMailError($detail);
  respond(500, false, 'We could not send your application just now. Please try again or email us directly.');
}

function sendCorsHeaders(): void
{
  $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
  header('Access-Control-Allow-Origin: ' . ($origin !== '' ? $origin : '*'));
  header('Vary: Origin');
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Allow-Methods: POST, OPTIONS');
  header('Access-Control-Allow-Headers: Content-Type');
  header('Access-Control-Allow-Private-Network: true');
}

function createMailer(array $config): PHPMailer
{
  $mail = new PHPMailer(true);
  configureTransport($mail, $config);
  return $mail;
}

function configureTransport(PHPMailer $mail, array $config): void
{
  $smtp = $config['smtp'] ?? [];
  $hasSmtp = !empty($smtp['enabled']) || (!empty($smtp['username']) && !empty($smtp['password']));

  if (!$hasSmtp) {
    throw new \RuntimeException('SMTP is not configured. Email cannot be sent from this Windows/XAMPP setup.');
  }

  $mail->isSMTP();
  $mail->Host = (string) ($smtp['host'] ?? 'smtp.gmail.com');
  $mail->Port = (int) ($smtp['port'] ?? 587);
  $mail->SMTPAuth = true;
  $mail->AuthType = 'LOGIN';
  $mail->Username = trim((string) ($smtp['username'] ?? ''));
  $mail->Password = trim((string) ($smtp['password'] ?? ''));
  $mail->Timeout = 30;
  $mail->CharSet = PHPMailer::CHARSET_UTF8;
  $mail->SMTPDebug = 0;

  $encryption = strtolower((string) ($smtp['encryption'] ?? 'tls'));
  $mail->SMTPSecure = $encryption === 'ssl'
    ? PHPMailer::ENCRYPTION_SMTPS
    : PHPMailer::ENCRYPTION_STARTTLS;

  $fromEmail = trim((string) $config['from_email']);
  $mail->setFrom($fromEmail, (string) $config['from_name']);
  $mail->Sender = $fromEmail;
}

function addAdminRecipients(PHPMailer $mail, array $config): void
{
  $recipients = $config['to_email'] ?? [];
  if (!is_array($recipients)) {
    $recipients = [$recipients];
  }

  $added = 0;
  foreach ($recipients as $address) {
    $address = trim((string) $address);
    if ($address === '' || !filter_var($address, FILTER_VALIDATE_EMAIL)) {
      continue;
    }
    $mail->addAddress($address, (string) ($config['to_name'] ?? ''));
    $added++;
  }

  if ($added === 0) {
    throw new \RuntimeException('No valid to_email address is configured in config/mail.php.');
  }
}

function respond(int $status, bool $ok, string $message): never
{
  http_response_code($status);
  echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
  exit;
}

function h(string $value): string
{
  return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function formatFileSize(int $bytes): string
{
  if ($bytes < 1024) {
    return $bytes . ' B';
  }
  if ($bytes < 1048576) {
    return number_format($bytes / 1024, 1) . ' KB';
  }
  return number_format($bytes / 1048576, 2) . ' MB';
}

function attachmentMimeType(string $extension): string
{
  return match ($extension) {
    'pdf' => 'application/pdf',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'jpg', 'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'webp' => 'image/webp',
    default => 'application/octet-stream',
  };
}

function logMailEvent(string $message): void
{
  $logDir = __DIR__ . '/logs';
  if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
  }
  $line = sprintf("[%s] %s\n", date('c'), $message);
  file_put_contents($logDir . '/mail-error.log', $line, FILE_APPEND | LOCK_EX);
}

function logMailError(string $message): void
{
  logMailEvent('ERROR: ' . $message);
}

function emailRow(string $label, string $value): string
{
  $display = $value !== '' ? h($value) : 'Not provided';
  $colour = $value !== '' ? '#152033' : '#98a2b3';
  return '
      <tr>
        <td style="padding:12px 16px;width:42%;font-size:13px;font-weight:700;color:#526174;border-bottom:1px solid #edf0f3;vertical-align:top;">' . h($label) . '</td>
        <td style="padding:12px 16px;font-size:14px;color:' . $colour . ';border-bottom:1px solid #edf0f3;vertical-align:top;">' . $display . '</td>
      </tr>';
}

function buildDataRightsHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{
  $requestType = $fields['specialism'] !== '' ? $fields['specialism'] : 'Data rights request';
  $relationship = $fields['relationship'] !== '' ? $fields['relationship'] : ($fields['experience'] !== '' ? $fields['experience'] : 'Not specified');
  $details = $fields['details'] !== '' ? $fields['details'] : 'No details provided';

  $rows = ''
    . emailRow('Request type', $requestType)
    . emailRow('Full name', $fields['fullName'])
    . emailRow('Email address', $fields['email'])
    . emailRow('Phone', $fields['phone'])
    . emailRow('Relationship with Kingsbury Personnel', $relationship)
    . emailRow('Request details', $details)
    . emailRow('Acting on behalf of someone else', $fields['sponsorship'] !== '' ? $fields['sponsorship'] : 'No');

  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Data Rights Request</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
        <tr>
          <td style="background:#0b1f3a;padding:28px 32px;">
            <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
            <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">New data rights request</h1>
            <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">A website visitor has submitted a request via the data rights form.</p>
          </td>
        </tr>
        <tr>
          <td style="padding:20px 32px 8px;">
            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
              ' . $rows . '
            </table>
          </td>
        </tr>
        <tr>
          <td style="padding:20px 32px 28px;color:#526174;font-size:14px;line-height:1.6;">
            Submitted: ' . h($submittedAt) . '
          </td>
        </tr>
      </table>
    </td></tr>
  </table>
</body>
</html>';
}

function buildDataRightsTextEmail(array $fields, string $displayName, string $submittedAt): string
{
  $requestType = $fields['specialism'] !== '' ? $fields['specialism'] : 'Data rights request';
  $relationship = $fields['relationship'] !== '' ? $fields['relationship'] : ($fields['experience'] !== '' ? $fields['experience'] : 'Not specified');
  $details = $fields['details'] !== '' ? $fields['details'] : 'No details provided';

  return "New Data Rights Request\n"
    . "Name: " . $displayName . "\n"
    . "Request type: " . $requestType . "\n"
    . "Email: " . ($fields['email'] !== '' ? $fields['email'] : 'Not provided') . "\n"
    . "Phone: " . ($fields['phone'] !== '' ? $fields['phone'] : 'Not provided') . "\n"
    . "Relationship: " . $relationship . "\n"
    . "Acting on behalf: " . ($fields['sponsorship'] !== '' ? $fields['sponsorship'] : 'No') . "\n"
    . "Details: " . $details . "\n"
    . "Submitted: " . $submittedAt . "\n";
}

function buildHtmlEmail(array $fields, string $displayName, string $cvName, string $cvSize, string $submittedAt): string
{
  $saleUrl = trim($fields['saleUrl']);
  $saleUrlParts = $saleUrl !== '' ? parse_url($saleUrl) : false;
  $hasSaleUrl = filter_var($saleUrl, FILTER_VALIDATE_URL)
    && is_array($saleUrlParts)
    && in_array(strtolower((string) ($saleUrlParts['scheme'] ?? '')), ['http', 'https'], true)
    && !empty($saleUrlParts['host']);

  $saleAction = $hasSaleUrl
    ? '<tr><td style="background:#f4f6f8;padding:18px 32px;">
        <table role="presentation" cellspacing="0" cellpadding="0" border="0"><tr>
          <td bgcolor="#0b1f3a" style="background:#0b1f3a;border-radius:4px;text-align:center;">
            <a href="' . h($saleUrl) . '" target="_blank" rel="noopener noreferrer" style="display:inline-block;padding:12px 18px;background:#0b1f3a;border:1px solid #0b1f3a;border-radius:4px;color:#ffffff;font-family:Arial,Helvetica,sans-serif;font-size:14px;font-weight:700;line-height:20px;text-align:center;text-decoration:none;-webkit-text-size-adjust:none;">View sale in CRM</a>
          </td>
        </tr></table>
        <p style="margin:12px 0 0;font-size:12px;line-height:1.5;color:#526174;">If the button does not open, use this link: <a href="' . h($saleUrl) . '" style="color:#0b1f3a;text-decoration:underline;word-break:break-all;">' . h($saleUrl) . '</a></p>
      </td></tr>'
    : '<tr><td style="background:#f4f6f8;padding:18px 32px;color:#526174;font-size:13px;line-height:1.5;">No CRM sale link was supplied with this application.</td></tr>';

  $personal = emailRow('Full legal name', $fields['fullName']);

  $professional = emailRow('Primary specialism', $fields['specialism'])
    . emailRow('Years of experience', $fields['experience'])
    . emailRow('Is sponsorship required?', $fields['sponsorship']);

  $contact = emailRow('Email address', $fields['email'])
    . emailRow('Phone', $fields['phone']);

  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Candidate Application</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
          <tr>
            <td style="background:#0b1f3a;padding:28px 32px;">
              <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
              <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">New candidate application</h1>
              <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">A candidate has submitted their profile through the website. Their CV is attached to this email.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:24px 32px 8px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8f5ef;border-left:3px solid #c6831d;">
                <tr>
                  <td style="padding:16px 18px;">
                    <p style="margin:0;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#92713b;font-weight:700;">Candidate</p>
                    <p style="margin:6px 0 0;font-size:20px;color:#0b1f3a;font-weight:700;">' . h($displayName) . '</p>
                    <p style="margin:4px 0 0;font-size:14px;color:#526174;">' . h($fields['specialism']) . '</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 32px 8px;">
              <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Personal details</p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
                ' . $personal . '
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 32px 8px;">
              <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Professional details</p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
                ' . $professional . '
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 32px 8px;">
              <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Contact</p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
                ' . $contact . '
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:20px 32px 28px;">
              <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">CV attachment</p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;border:1px dashed #cfd8e2;">
                <tr>
                  <td style="padding:16px 18px;">
                    <p style="margin:0;font-size:14px;font-weight:700;color:#0b1f3a;">' . h($cvName) . '</p>
                    <p style="margin:4px 0 0;font-size:13px;color:#667085;">' . h($cvSize) . ' · Attached to this email</p>
                  </td>
                </tr>
              </table>
              <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time). Reply to this email to contact the candidate directly.</p>
            </td>
          </tr>
          ' . $saleAction . '
          <tr>
            <td style="background:#08172b;padding:18px 32px;">
              <p style="margin:0;font-size:11px;color:#6f8296;">This message was sent from the Kingsbury Personnel candidate form.</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
}

function buildTextEmail(array $fields, string $displayName, string $cvName, string $cvSize, string $submittedAt): string
{
  $blank = static fn(string $value): string => $value !== '' ? $value : 'Not provided';

  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'New candidate application',
    '',
    'Candidate: ' . $displayName,
    'Specialism: ' . $fields['specialism'],
    '',
    'PERSONAL DETAILS',
    'Full legal name: ' . $fields['fullName'],
    '',
    'PROFESSIONAL DETAILS',
    'Primary specialism: ' . $fields['specialism'],
    'Years of experience: ' . $fields['experience'],
    '',
    'CONTACT',
    'Email address: ' . $fields['email'],
    'Phone: ' . $blank($fields['phone']),
    '',
    'CV ATTACHMENT',
    $cvName . ' (' . $cvSize . ')',
    '',
    'CRM sale: ' . ($fields['saleUrl'] !== '' ? $fields['saleUrl'] : 'No CRM sale link was supplied.'),
    '',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Reply to this email to contact the candidate directly.',
  ]);
}

function buildCandidateHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{

  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Application received</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
          <tr>
            <td style="background:#0b1f3a;padding:28px 32px;">
              <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
              <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">Thank you for your application</h1>
              <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">We have received your details and CV, and our recruitment team will be in touch.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:28px 32px 8px;">
              <p style="margin:0 0 14px;font-size:16px;color:#152033;line-height:1.6;">Dear ' . h($displayName) . ',</p>
              <p style="margin:0 0 14px;font-size:15px;color:#344054;line-height:1.7;">Thank you for submitting your application to Kingsbury Personnel. We have received your profile and CV, and a member of our team will review it shortly.</p>
              <p style="margin:0;font-size:15px;color:#344054;line-height:1.7;">If there is a suitable opportunity that matches your experience, we will contact you using the details you provided. We have attached our Wellbeing Guide for you to keep.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:22px 32px 8px;">
              <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Your application summary</p>
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
                ' . emailRow('Name', $displayName)
    . emailRow('Primary specialism', $fields['specialism'])
    . emailRow('Years of experience', $fields['experience']) . '
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:22px 32px 28px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8f5ef;border-left:3px solid #c6831d;">
                <tr>
                  <td style="padding:16px 18px;">
                    <p style="margin:0 0 8px;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#92713b;font-weight:700;">Need to speak with us?</p>
                    <p style="margin:0;font-size:14px;color:#152033;line-height:1.7;">Email <a href="mailto:info@kingsburypersonnel.com" style="color:#0b1f3a;font-weight:700;">info@kingsburypersonnel.com</a><br>Phone <a href="tel:+441494211220" style="color:#0b1f3a;font-weight:700;">+44 (0) 1494 211220</a></p>
                  </td>
                </tr>
              </table>
              <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time). Please do not reply with another CV to this automated message unless you are contacting our team directly.</p>
            </td>
          </tr>
          <tr>
            <td style="background:#08172b;padding:18px 32px;">
              <p style="margin:0;font-size:11px;color:#6f8296;">Kingsbury Personnel &middot; 124 City Road, London, England, EC1V 2NX</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
}

function buildCandidateTextEmail(array $fields, string $displayName, string $submittedAt): string
{

  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'Thank you for your application',
    '',
    'Dear ' . $displayName . ',',
    '',
    'Thank you for submitting your application to Kingsbury Personnel.',
    'We have received your profile and CV, and a member of our team will review it shortly.',
    'If there is a suitable opportunity that matches your experience, we will contact you using the details you provided.',
    'Our Wellbeing Guide is attached for you to keep.',
    '',
    'YOUR APPLICATION SUMMARY',
    'Name: ' . $displayName,
    'Primary specialism: ' . $fields['specialism'],
    'Years of experience: ' . $fields['experience'],
    '',
    'NEED TO SPEAK WITH US?',
    'Email: info@kingsburypersonnel.com',
    'Phone: +44 (0) 1494 211220',
    '',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Kingsbury Personnel, 124 City Road, London, England, EC1V 2NX',
  ]);
}

function buildLeadHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{
  $details = emailRow('Name', $displayName)
    . emailRow('Email address', $fields['email'])
    . emailRow('Phone', $fields['phone'])
    . emailRow('Profession / role', $fields['specialism']);

  return '<!DOCTYPE html>
      <html lang="en-GB">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>New Candidate Lead</title>
      </head>
      <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
        <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
          <tr>
            <td align="center">
              <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
                <tr>
                  <td style="background:#0b1f3a;padding:28px 32px;">
                    <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
                    <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">New candidate lead</h1>
                    <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">A candidate registered their details through the website popup. There is no CV attached to this enquiry.</p>
                  </td>
                </tr>
                <tr>
                  <td style="padding:24px 32px 8px;">
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8f5ef;border-left:3px solid #c6831d;">
                      <tr>
                        <td style="padding:16px 18px;">
                          <p style="margin:0;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#92713b;font-weight:700;">Candidate</p>
                          <p style="margin:6px 0 0;font-size:20px;color:#0b1f3a;font-weight:700;">' . h($displayName) . '</p>
                          <p style="margin:4px 0 0;font-size:14px;color:#526174;">' . h($fields['specialism']) . '</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding:20px 32px 28px;">
                    <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Lead details</p>
                    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">
                      ' . $details . '
                    </table>
                    <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time). Reply to this email to contact the candidate directly.</p>
                  </td>
                </tr>
                <tr>
                  <td style="background:#08172b;padding:18px 32px;">
                    <p style="margin:0;font-size:11px;color:#6f8296;">This message was sent from the Kingsbury Personnel lead capture form.</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </body>
      </html>';
}

function buildLeadTextEmail(array $fields, string $displayName, string $submittedAt): string
{
  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'New candidate lead',
    '',
    'Name: ' . $displayName,
    'Profession / role: ' . $fields['specialism'],
    'Email address: ' . $fields['email'],
    'Phone: ' . $fields['phone'],
    '',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Reply to this email to contact the candidate directly.',
  ]);
}

function buildEmployerHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{
  $details = emailRow('Contact name', $displayName)
    . emailRow('Job title', $fields['jobTitle'])
    . emailRow('Organisation', $fields['organisation'])
    . emailRow('Work email', $fields['email'])
    . emailRow('Phone', $fields['phone'])
    . emailRow('Role required', $fields['specialism'])
    . emailRow('Type of supply', $fields['experience'])
    . emailRow('Location', $fields['location'])
    . emailRow('Setting', $fields['setting'])
    . emailRow('Role details', $fields['details']);

  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New employer staffing request</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
        <tr><td style="background:#0b1f3a;padding:28px 32px;">
          <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
          <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">New employer staffing request</h1>
          <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">A business has requested recruitment support through the website.</p>
        </td></tr>
        <tr><td style="padding:24px 32px 28px;">
          <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Request details</p>
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">' . $details . '</table>
          <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time). Reply to this email to contact ' . h($displayName) . '.</p>
        </td></tr>
        <tr><td style="background:#08172b;padding:18px 32px;">
          <p style="margin:0;font-size:11px;color:#6f8296;">This message was sent from the Kingsbury Personnel employer request form.</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>';
}

function buildEmployerTextEmail(array $fields, string $displayName, string $submittedAt): string
{
  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'New employer staffing request',
    '',
    'Contact name: ' . $displayName,
    'Job title: ' . ($fields['jobTitle'] !== '' ? $fields['jobTitle'] : 'Not provided'),
    'Organisation: ' . $fields['organisation'],
    'Work email: ' . $fields['email'],
    'Phone: ' . $fields['phone'],
    'Role required: ' . $fields['specialism'],
    'Type of supply: ' . $fields['experience'],
    'Location: ' . $fields['location'],
    'Setting: ' . $fields['setting'],
    '',
    'Role details:',
    $fields['details'],
    '',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Reply to this email to contact ' . $displayName . '.',
  ]);
}

function buildEmployerConfirmationHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{
  $summary = emailRow('Organisation', $fields['organisation'])
    . emailRow('Role required', $fields['specialism'])
    . emailRow('Type of supply', $fields['experience'])
    . emailRow('Location', $fields['location'])
    . emailRow('Setting', $fields['setting']);

  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staffing request received</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr><td align="center">
      <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
        <tr><td style="background:#0b1f3a;padding:28px 32px;">
          <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
          <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">We have received your request</h1>
          <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">A consultant will be in touch to discuss your staffing requirements.</p>
        </td></tr>
        <tr><td style="padding:28px 32px 8px;">
          <p style="margin:0 0 14px;font-size:16px;color:#152033;line-height:1.6;">Dear ' . h($displayName) . ',</p>
          <p style="margin:0;font-size:15px;color:#344054;line-height:1.7;">Thank you for contacting Kingsbury Personnel. We have received your request and our team will review the details and call you to discuss the role and next steps.</p>
        </td></tr>
        <tr><td style="padding:22px 32px 8px;">
          <p style="margin:0 0 10px;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:#c6831d;font-weight:800;">Your request summary</p>
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border:1px solid #e6ebf0;border-radius:6px;">' . $summary . '</table>
        </td></tr>
        <tr><td style="padding:22px 32px 28px;">
          <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8f5ef;border-left:3px solid #c6831d;"><tr><td style="padding:16px 18px;">
            <p style="margin:0 0 8px;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#92713b;font-weight:700;">Need to speak with us?</p>
            <p style="margin:0;font-size:14px;color:#152033;line-height:1.7;">Email <a href="mailto:info@kingsburypersonnel.com" style="color:#0b1f3a;font-weight:700;">info@kingsburypersonnel.com</a><br>Phone <a href="tel:+441494211220" style="color:#0b1f3a;font-weight:700;">+44 (0) 1494 211220</a></p>
          </td></tr></table>
          <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time).</p>
        </td></tr>
        <tr><td style="background:#08172b;padding:18px 32px;">
          <p style="margin:0;font-size:11px;color:#6f8296;">Kingsbury Personnel &middot; 124 City Road, London, England, EC1V 2NX</p>
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>';
}

function buildEmployerConfirmationTextEmail(array $fields, string $displayName, string $submittedAt): string
{
  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'We have received your staffing request',
    '',
    'Dear ' . $displayName . ',',
    '',
    'Thank you for contacting Kingsbury Personnel. We have received your request and our team will review the details and call you to discuss the role and next steps.',
    '',
    'YOUR REQUEST SUMMARY',
    'Organisation: ' . $fields['organisation'],
    'Role required: ' . $fields['specialism'],
    'Type of supply: ' . $fields['experience'],
    'Location: ' . $fields['location'],
    'Setting: ' . $fields['setting'],
    '',
    'Email: info@kingsburypersonnel.com',
    'Phone: +44 (0) 1494 211220',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Kingsbury Personnel, 124 City Road, London, England, EC1V 2NX',
  ]);
}

function buildLeadCandidateHtmlEmail(array $fields, string $displayName, string $submittedAt): string
{
  return '<!DOCTYPE html>
<html lang="en-GB">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>We have received your details</title>
</head>
<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f8;padding:28px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" width="640" cellspacing="0" cellpadding="0" style="max-width:640px;width:100%;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e4e8ee;">
          <tr>
            <td style="background:#0b1f3a;padding:28px 32px;">
              <p style="margin:0 0 8px;font-size:11px;letter-spacing:.16em;text-transform:uppercase;color:#c6831d;font-weight:700;">Kingsbury Personnel</p>
              <h1 style="margin:0;font-size:24px;line-height:1.3;color:#ffffff;font-weight:700;">We have your details</h1>
              <p style="margin:10px 0 0;color:#c9d2dc;font-size:14px;line-height:1.5;">Thank you for registering. Our team will match you with suitable UK vacancies.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:28px 32px 8px;">
              <p style="margin:0 0 14px;font-size:16px;color:#152033;line-height:1.6;">Dear ' . h($displayName) . ',</p>
              <p style="margin:0 0 14px;font-size:15px;color:#344054;line-height:1.7;">Thank you for sharing your details with Kingsbury Personnel. We have received your enquiry and a consultant will be in touch if there is a suitable care or nursing role. We have attached our Wellbeing Guide for you to keep.</p>
              <p style="margin:0;font-size:15px;color:#344054;line-height:1.7;">You registered as <strong>' . h($fields['specialism']) . '</strong>.</p>
            </td>
          </tr>
          <tr>
            <td style="padding:22px 32px 28px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f8f5ef;border-left:3px solid #c6831d;">
                <tr>
                  <td style="padding:16px 18px;">
                    <p style="margin:0 0 8px;font-size:12px;letter-spacing:.08em;text-transform:uppercase;color:#92713b;font-weight:700;">Need to speak with us?</p>
                    <p style="margin:0;font-size:14px;color:#152033;line-height:1.7;">Email <a href="mailto:info@kingsburypersonnel.com" style="color:#0b1f3a;font-weight:700;">info@kingsburypersonnel.com</a><br>Phone <a href="tel:+441494211220" style="color:#0b1f3a;font-weight:700;">+44 (0) 1494 211220</a></p>
                  </td>
                </tr>
              </table>
              <p style="margin:18px 0 0;font-size:12px;color:#98a2b3;">Submitted ' . h($submittedAt) . ' (UK time).</p>
            </td>
          </tr>
          <tr>
            <td style="background:#08172b;padding:18px 32px;">
              <p style="margin:0;font-size:11px;color:#6f8296;">Kingsbury Personnel &middot; 124 City Road, London, England, EC1V 2NX</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>';
}

function buildLeadCandidateTextEmail(array $fields, string $displayName, string $submittedAt): string
{
  return implode("\n", [
    'KINGSBURY PERSONNEL',
    'We have your details',
    '',
    'Dear ' . $displayName . ',',
    '',
    'Thank you for sharing your details with Kingsbury Personnel.',
    'We have received your enquiry and a consultant will be in touch if there is a suitable care or nursing role.',
    'Our Wellbeing Guide is attached for you to keep.',
    'You registered as: ' . $fields['specialism'],
    '',
    'NEED TO SPEAK WITH US?',
    'Email: info@kingsburypersonnel.com',
    'Phone: +44 (0) 1494 211220',
    '',
    'Submitted ' . $submittedAt . ' (UK time).',
    'Kingsbury Personnel, 124 City Road, London, England, EC1V 2NX',
  ]);
}