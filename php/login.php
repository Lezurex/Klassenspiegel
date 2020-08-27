<?php

include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if($result = queryEntryFromTable("users", "email", "email", $email) == null) {
    header("Location: ".$_SERVER["HTTP_REFERER"]."?error=901");
    http_send_status(401);
    exit();
}

$result = queryEntryFromTable("users", "password", "email",  $email);
if(!passwordVerify($password, $result)) {
    header("Location: ".$_SERVER["HTTP_REFERER"]."?error=901");
}

echo $result;
