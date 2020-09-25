<?php
# use namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

function sendEmail($to, $subject, $message) {
    $config = json_decode(file_get_contents("./../../mail.json "), true);

    //PHPMailer Object
    $mail = new PHPMailer(true);

    $mail->SMTPDebug  = SMTP::DEBUG_OFF;

    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = $config['host'];                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $config['username'];                     // SMTP username
    $mail->Password   = $config['password'];                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = $config['port'];
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //From email address and name
    $mail->From = $config['from'];
    $mail->FromName = $config['from_name'];

    //To address and name
    $mail->addAddress($to);

    //Address to which recipient will reply
    $mail->addReplyTo($config['from'], "Reply");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->CharSet = 'utf-8';

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}
?>