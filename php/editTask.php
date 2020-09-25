<?php

require "database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

if ($_SESSION['email'] != "lenny.angst@easyid.ch") {
    echo "401";
    exit();
}

if ($_POST['title'] == "") {
    echo "TITEL FEHLT DU KEK";
    exit();
}

$db = new DatabaseAdapter();

$date = strtotime($_POST['date']);

$db->updateValues("tasks", new Key("id", $_POST['id']), new Insert("title", $_POST['title']),
    new Insert("description", $_POST['description']),
    new Insert("date", $date),
    new Insert("subject", $_POST['subject']),
    new Insert("category", $_POST['category']));

echo "200";