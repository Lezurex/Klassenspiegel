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

$db = new DatabaseAdapter();

$db->updateValues("users", new Key("email", $_SESSION['email']),
    new Insert("lastname", $_POST['lastname']),
    new Insert("firstname", $_POST['firstname']),
    new Insert("location", $_POST['location']),
    new Insert("phone", $_POST['phone']),
    new Insert("company", $_POST['company']),
    new Insert("hobbys", $_POST['hobbys']));

echo "200";