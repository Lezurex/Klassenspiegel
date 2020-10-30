<?php

require "../database/DatabaseAdapter.php";

if (!isset($_POST['email']) || !isset($_POST['code'])) {
    echo "400";
    http_response_code(400);
    exit();
}

$db = new DatabaseAdapter();

if ($db->containsEntry("password_reset", new Key("email", $_POST['email']), new Key("code", $_POST['code']))) {
    echo 200;
    exit();
} else {
    echo 901;
    exit();
}