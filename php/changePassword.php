<?php
require "database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

$db = new DatabaseAdapter();

if(!password_verify($_POST['old-pw'], $db->getStringFromTable("users", "password",
    new Key("email", $_SESSION['email'])))) {
    echo "902";
    exit();
}

$hashed_password = password_hash($_POST['new-pw'], PASSWORD_DEFAULT);
$db->updateValue("users", "password", $hashed_password, new Key("email", $_SESSION['email']));

echo "200";

exit();