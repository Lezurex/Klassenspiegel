<?php
# use namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "../vendor/autoload.php";

function sendEmail($to, $subject, $message) {
    //PHPMailer Object
    $mail = new PHPMailer(true);

    $mail->SMTPDebug  = SMTP::DEBUG_OFF;

    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'klasseap20b@gmail.com';                     // SMTP username
    $mail->Password   = '$87YrCnlRS!v';                               // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    //From email address and name
    $mail->From = "klasseap20b@gmail.com";
    $mail->FromName = "Klasse AP20b";

    //To address and name
    $mail->addAddress($to);

    //Address to which recipient will reply
    $mail->addReplyTo("klasseap20b@gmail.com", "Reply");

    //Send HTML or Plain Text email
    $mail->isHTML(true);

    $mail->CharSet = 'utf-8';

    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
}
?>