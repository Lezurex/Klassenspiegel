<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "klassenspiegel";

$connection = mysqli_connect($host, $username, $password, $database);

function queryEntryFromTable($table, $column, $search_row, $search_value) {
    global $connection;
    $sql = "SELECT $column FROM $table WHERE $search_row='$search_value'";
    $result = mysqli_query($connection, $sql);

    if(!$result) {
        return null;
    }

    while($row = mysqli_fetch_assoc($result)) {
        return $row[$column];
    }
}

function queryEntriesFromTable($table, $search_row, $search_value) {
    global $connection;
    $sql = "SELECT * FROM $table WHERE $search_row='$search_value'";
    $result = mysqli_query($connection, $sql);

    if(!$result) {
        return null;
    }

    while($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
}

function containsEntry($table, $search_row, $search_value) {
    global $connection;
    $sql = "SELECT * FROM $table WHERE $search_row='$search_value'";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) > 0) {
        return true;
    } else
        return false;
}

function insertIntoTable($table) {

}
