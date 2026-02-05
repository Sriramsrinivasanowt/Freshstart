<?php

//Import the PHPMailer class into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Sending Email from Local Web Server using PHPMailer			
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/Exception.php';

//Create a new PHPMailer instance
$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$isSmtp = true;

if ($isSmtp) {

    require 'phpmailer/src/SMTP.php';

    //Tell PHPMailer to use SMTP
    $mail->isSMTP();

    //Enable SMTP debugging
    $mail->SMTPDebug = 0;

    //Ask for HTML-friendly debug output
    $mail->Debugoutput = 'html';

    //Set the hostname of the mail server
    $mail->Host = 'mail.test.com';

    //Set the SMTP port number - likely to be 25, 465 or 587
    $mail->Port = 587;

    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;

    //Username to use for SMTP authentication
    $mail->Username = 'info@test.com';

    //Password to use for SMTP authentication
    $mail->Password = '123456';

}

// Form Fields Value Variables
$name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$subject = filter_var($_POST['subject'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$phone = filter_var($_POST['phone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$message = filter_var($_POST['message'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$message = nl2br($message);

//From email address and name (Change here)
$mail->From = $email;
$mail->FromName = $name;

//Set who the message is to be sent to
$mail->addAddress('demo@test.com');

//Set an alternative reply-to address
$mail->addReplyTo($email, $name);

//Send HTML or Plain Text email
$mail->isHTML(true);

// Message Body
$body_message = "Name: " . $name . "<br>";
$body_subject .= "Subject: " . $subject . "<br>";
$body_message .= "Email: " . $email . "<br>";
$body_message .= "\n\n" . $message;

//Set the subject & Body Text
$mail->Subject = "New Message from $name";
$mail->Body = $body_message;

//send the message, check for errors
if (!$mail->send()) {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message sent!';
}

