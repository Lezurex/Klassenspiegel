<?php

include "database.php";

$email = $_POST['email'];
$password = $_POST['password'];

if(!is_null($result = queryEntryFromTable("users", "email", "email", $email))) {
    echo "902";
    exit();
}

session_start();

global $connection;
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO `users`(`email`, `password`) VALUES ('$email','$hashed_password')";
mysqli_query($connection, $sql);

$_SESSION['email'] = $email;

echo "200";
