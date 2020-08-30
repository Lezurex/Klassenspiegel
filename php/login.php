<?php

include "database/DatabaseAdapter.php";

$email = $_POST['email'];
$password = $_POST['password'];

$db = new DatabaseAdapter();

if(!$db->containsEntry("users", new Key("email", $email))) {
    echo "901";
    exit();
}

$result = $db->getStringFromTable("users", "password", new Key("email", $email));
if(!password_verify($password, $result)) {
    echo "901";
    exit();
}

if($db->getIntegerFromTable("users", "permitted", new Key("email", $email)) == 0) {
    echo "905";
    exit();
}

session_start();

$_SESSION['email'] = $email;

echo "200";
