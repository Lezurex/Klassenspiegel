<?php

require "../database/DatabaseAdapter.php";
include "../mail-config.php";

if (!isset($_POST['email'])) {
    echo 400;
    http_response_code(400);
    exit();
}

$db = new DatabaseAdapter();

if (!$db->containsEntry("users", new Key("email", $_POST['email']), new Key("permitted", "1"))) {
    echo "901";
    exit();
}

$code = mt_rand(100000, 999999);

if ($db->containsEntry("password_reset", new Key("email", $_POST['email']))) {
    $db->updateValue("password_reset", "code", $code, new Key("email", $_POST['email']));
} else {
    $db->insertIntoTable("password_reset", new Insert("email", $_POST['email']), new Insert("code", $code));
}

sendEmail($_POST['email'], "Dein Verifikationscode", "
<h1 style='font-family: Roboto'>Dein Code zum Zurücksetzen deines Passwortes.</h1>
<p style='font-family: Roboto'>Dein Code zum Zurücksetzen deines Passwortes lautet: <strong>$code</strong></p>
<p style='font-family: Roboto'>Falls du dein Passwort nicht selbst zurücksetzen wolltest, ändere dein Passwort!</p>
");

echo "200";
exit();