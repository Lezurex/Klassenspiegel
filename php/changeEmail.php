<?php
require "database/DatabaseAdapter.php";
include "mail-config.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

if($_SESSION['email'] == $_POST['email']) {
    echo "902";
    exit();
}

sendEmail($_POST['email'], "Test", "Hallo");

echo "200";
