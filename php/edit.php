<?php

require "database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

if(!preg_match("/^([0][1-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$|^(([0][0]|\+)[1-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$/", $_POST['phone'])) {
    echo "904";
    exit();
}

if($_POST['bms'] != '1' && $_POST['bms'] != '0') {
    echo "Hör auf zu hacken du kleiner kek";
}

$db = new DatabaseAdapter();

$db->updateValues("users", new Key("email", $_SESSION['email']),
    new Insert("lastname", strip_tags($_POST['lastname'], '<a><p><strong><i>')),
    new Insert("firstname", strip_tags($_POST['firstname'], '<a><p><strong><i>')),
    new Insert("location", strip_tags($_POST['location'], '<a><p><strong><i>')),
    new Insert("phone", strip_tags($_POST['phone'], '<a><p><strong><i>')),
    new Insert("company", strip_tags($_POST['company'], '<a><p><strong><i>')),
    new Insert("hobbys", strip_tags($_POST['hobbys'], '<a><p><strong><i>')),
    new Insert("isBms", $_POST['bms']));

echo "200";