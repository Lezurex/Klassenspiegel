<?php

include "database/DatabaseAdapter.php";

$db = new DatabaseAdapter();

$email = $_POST['email'];
$password = $_POST['password'];

if($db->containsEntry("users", new Key("email", $email))) {
    echo "902";
    exit();
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "903";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$db->insertIntoTable("users", new Insert("email", $email), new Insert("password", $hashed_password), new Insert("permitted", "0"));

echo "200";
