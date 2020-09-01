<?php

require "../php/database/DatabaseAdapter.php";

$db = new DatabaseAdapter();

if(!isset($_GET['token'])) {
    $email_message = "E-Mail Verifikation fehlgeschlagen";
} else {
    $exists = $db->containsEntry("email_verification", new Key("token", $_GET['token']));
    if($exists) {
        $old = $db->getStringFromTable("email_verification", "old_email");
        $new = $db->getStringFromTable("email_verification", "new_email");
        $db->updateValue("users", "email", $new, new Key("email", $old));
        $db->deleteFromTable("email_verification", new Key("token", $_GET['token']));
        $email_message = "E-Mail Verifikation erfolgreich";

        session_start();
        $_SESSION['email'] = $new;
    } else
        $email_message = "E-Mail Verifikation fehlgeschlagen";
}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh"
          content="3; url=../dashboard">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="/js/jQuery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <title>AP20b - E-Mail Verifikation</title>
</head>
<body>
    <div class="text-center" style="margin-top: 10%">
        <h1><?php
            echo $email_message;
            ?></h1>
        <p>Du wirst demnächst weitergeleitet...</p>
    </div>
</body>
</html>