<?php

include "../database/DatabaseAdapter.php";

if (!isset($_POST['email']) || !isset($_POST['code']) || !isset($_POST['password'])) {
    echo 400;
    http_response_code(400);
    exit();
}

$db = new DatabaseAdapter();

if ($db->containsEntry("password_reset", new Key("email", $_POST['email']), new Key("code", $_POST['code']))) {
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $db->updateValue("users", "password", $hashed_password, new Key("email", $_POST['email']));
    session_start();
    $_SESSION['email'] = $_POST['email'];
    echo 200;
    exit();
}