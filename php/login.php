<?php

include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if(!containsEntry("users", "email", $email)) {
    echo "901";
    exit();
}

$result = queryEntryFromTable("users", "password", "email",  $email);
if(!password_verify($password, $result)) {
    echo "901";
    exit();
}

session_start();

$_SESSION['email'] = $email;

echo "200";
