<?php
// Turn off error display in production
// ini_set('display_errors', 0);
// error_reporting(0);

function sanitize($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Collect POST data
$senderName     = sanitize($_POST['senderName'] ?? '');
$senderEmail    = sanitize($_POST['senderEmail'] ?? '');
$replyTo        = sanitize($_POST['replyTo'] ?? '');
$subject        = sanitize($_POST['subject'] ?? '');
$to             = sanitize($_POST['to'] ?? '');
$bcc            = sanitize($_POST['bcc'] ?? '');
$messageType    = sanitize($_POST['messageType'] ?? 'text');
$messageContent = $_POST['messageContent'] ?? ''; // Don't sanitize HTML content

if (!$senderEmail || !$to || !$subject || !$messageContent) {
    echo "Error: Missing required fields.";
    exit;
}

// Format headers
$headers = "From: $senderName <$senderEmail>\r\n";
if (!empty($replyTo)) {
    $headers .= "Reply-To: $replyTo\r\n";
}
if (!empty($bcc)) {
    $headers .= "Bcc: $bcc\r\n";
}
$headers .= "MIME-Version: 1.0\r\n";

if ($messageType === 'html') {
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
} else {
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
}

// Send mail
$success = mail($to, $subject, $messageContent, $headers);

// Response to frontend
if ($success) {
    echo "Success: Email sent.";
} else {
    echo "Error: Failed to send email.";
}
?>
