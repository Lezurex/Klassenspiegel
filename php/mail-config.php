<?php
# use namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

function sendEmail($to, $subject, $message) {
    //PHPMailer Object
    $mail = new PHPMailer(true);

    $mail->SMTPDebug  = SMTP::DEBUG_CONNECTION;

    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'mail.mcsupercraft.net';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'no-reply@mcsupercraft.net';                     // SMTP username
    $mail->Password   = 'FZh!XN^76Dej';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //From email address and name
    $mail->From = "no-reply@mcsupercraft.net";
    $mail->FromName = "SuperCraft";

    //To address and name
    $mail->addAddress($to);

    //Address to which recipient will reply
    $mail->addReplyTo("no-reply@mcsupercraft.com", "Reply");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->CharSet = 'utf-8';

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}
?>