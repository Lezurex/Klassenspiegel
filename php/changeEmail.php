<?php
require "database/DatabaseAdapter.php";
include "mail-config.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

if($_SESSION['email'] == $_POST['email']) {
    echo "902";
    exit();
}

$token = md5(rand(0, 1000));

$db = new DatabaseAdapter();

if($db->containsEntry("email_verification", new Key("old_email", $_SESSION['email']))) {
    $db->updateValues("email_verification", new Key("old_email", $_SESSION['email']),
        new Insert("new_email", $_POST['email']), new Insert("token", $token));
} else
    $db->insertIntoTable("email_verification", new Insert("old_email", $_SESSION['email']),
        new Insert("new_email", $_POST['email']),
        new Insert("token",$token));

echo "200";

sendEmail($_POST['email'], "E-Mail Verifizierung", "Hallo!<br>
Du bekommst diese E-Mail, da du deine E-Mail auf ap20b.lezurex.com verifizieren musst.
Klicke <a href='https://klassenspiegel.test/dashboard/verify.php?token={$token}'>hier</a>, um dich zu verifizieren!");
