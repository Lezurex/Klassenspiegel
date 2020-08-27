<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "klassenspiegel";

$connection = mysqli_connect($host, $username, $password, $database);

function queryEntryFromTable($table, $row, $search_row, $search_value) {
    global $connection;
    $sql = "SELECT * FROM $table WHERE $search_row = $search_value";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) == 0) {
        return null;
    }

    while($rows = mysqli_fetch_assoc($result)) {
        return $rows[$row];
    }
}

function queryEntriesFromTable($table, $search_row, $search_value) {
    global $connection;
    $sql = "SELECT * FROM $table WHERE $search_row = $search_value";
    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) == 0) {
        return null;
    }
    while($row = mysqli_fetch_assoc($result)) {
        return $row;
    }
}

function insertIntoTable($table) {

}
