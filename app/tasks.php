<?php

require "App.php";

if (!isset($_POST['token']) || !isset($_POST['email'])) {
    App::printError("Bad request");
    exit();
}

if (App::validateKey($_POST['token'], $_POST['email'])) {
    echo '{"data":' . App::getTasks($_POST['email']) . '}';
    exit();
} else {
    App::printError("Invalid token");
    exit();
}