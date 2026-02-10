<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer files
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/SMTP.php';

// Create PHPMailer instance
$mail = new PHPMailer(true);

try {
    /* ===============================
       SMTP CONFIGURATION
    =============================== */

    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'sriram20ui@gmail.com';        // your Gmail
    $mail->Password   = 'xjqmbctheqfglmlv';     // App Password (NO SPACES)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';

    /* ===============================
       FORM DATA (SAFE)
    =============================== */

    $name    = htmlspecialchars($_POST['name'] ?? '');
    $email   = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars($_POST['subject'] ?? 'New Contact Message');
    $phone   = htmlspecialchars($_POST['phone'] ?? '');
    $message = nl2br(htmlspecialchars($_POST['message'] ?? ''));

    /* ===============================
       EMAIL HEADERS
    =============================== */

    // From must be YOUR email (Gmail rule)
    $mail->setFrom('YOUR_EMAIL@gmail.com', 'Portfolio Contact');

    // Where you receive the message
    $mail->addAddress('YOUR_EMAIL@gmail.com');

    // User email for reply
    if (!empty($email)) {
        $mail->addReplyTo($email, $name);
    }

    /* ===============================
       EMAIL CONTENT
    =============================== */

    $mail->isHTML(true);
    $mail->Subject = $subject;

    $mail->Body = "
        <strong>Name:</strong> {$name}<br>
        <strong>Email:</strong> {$email}<br>
        <strong>Phone:</strong> {$phone}<br><br>
        <strong>Message:</strong><br>{$message}
    ";

    /* ===============================
       SEND EMAIL
    =============================== */

    $mail->send();
    echo 'Message sent successfully!';

} catch (Exception $e) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
