<?php

include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if(is_null($result = queryEntryFromTable("users", "email", "email", $email))) {
    echo $result;
    echo "901";
    exit();
}

echo "sas $result";

$result = queryEntryFromTable("users", "password", "email",  $email);
echo $result;
if(!passwordVerify($password, $result)) {
    echo "902";
    exit();
}

session_start();

$_SESSION['email'] = $email;

echo "200";
