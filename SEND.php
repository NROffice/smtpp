<?php

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendBulkEmail($formData) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration (Update with your SMTP credentials)
        $mail->isSMTP();
        $mail->Host       = 'mail.hsbk.us';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'help@hsbk.us';
        $mail->Password   = 'BLEssed@123';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender details
        $mail->setFrom($formData['senderEmail'], $formData['senderName']);
        $mail->addReplyTo($formData['replyTo']);

        // Subject and Body
        $mail->Subject = $formData['subject'];
        $isHTML = ($formData['messageType'] === 'html');
        $mail->isHTML($isHTML);
        if ($isHTML) {
            $mail->Body = $formData['messageContent'];
            $mail->AltBody = strip_tags($formData['messageContent']);
        } else {
            $mail->Body = $formData['messageContent'];
        }

        // To and BCC
        $to = trim($formData['to']);
        if (!empty($to)) {
            $mail->addAddress($to);
        }

        $bccList = explode(',', $formData['bcc']);
        foreach ($bccList as $bcc) {
            $bcc = trim($bcc);
            if (!empty($bcc)) {
                $mail->addBCC($bcc);
            }
        }

        // Send Email
        $mail->send();
        echo "Success: Email sent.";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    sendBulkEmail($_POST);
}
?>
