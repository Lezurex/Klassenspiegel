<?php

require "App.php";

if (!isset($_POST['password']) || !isset($_POST['email'])) {
    App::printError("Bad request");
    exit();
}

$token = App::login($_POST['email'], $_POST['password']);

switch ($token) {
    case "WRONG_LOGIN":
        App::printError("Wrong Login");
        break;
    case "NOT_PERMITTED":
        App::printError("Not Permitted");
        break;
    default:
        $json = array("success" => $token);
        echo json_encode($json);
        break;
}