<?php

include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if($result = queryEntryFromTable("users", "email", "email", $email) == $email) {
    echo "902";
    exit();
}

$result = queryEntryFromTable("users", "password", "email",  $email);
if(!passwordVerify($password, $result)) {
    echo "901";
    exit();
}

session_start();

$_SESSION['email'] = $email;

echo $result;
