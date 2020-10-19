<?php

require "App.php";
require_once "../php/database/DatabaseAdapter.php";

if (!isset($_POST['token']) || !isset($_POST['email'])) {
    App::printError("Bad request");
    exit();
}

$validation = App::validateKey($_POST['token'], $_POST['email']);

if ($validation == true) {
    $json = array("success" => "Token valid", "token" => $_POST['token'], "email" => $_POST['email']);
    echo json_encode($json);
    exit();
} else if ($validation == false) {
    $json = array("error" => "Token invalid", "token" => $_POST['token'], "email" => $_POST['email']);
    echo json_encode($json);
//    App::printError("Token invalid");
} else if ($validation == null) {
    $json = array("error" => "Token invalid", "token" => $_POST['token'], "email" => $_POST['email']);
    echo json_encode($json);
//    App::printError("Token invalid");
} else {
    print_r("Validation: " . $validation);
}
