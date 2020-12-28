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
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">
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