<?php

include "config.php";
require "database/DatabaseAdapter.php";

session_start();

$db = new DatabaseAdapter();
$isBMS = $db->getIntegerFromTable("users", "isBms", new Key("email", $_SESSION['email']));

$tasks = $db->getAllStringsFromTable("tasks", "date");
$tableContent = "";

if ($tasks == null) {
    $tableContent = "<td>Keine Aufgaben!</td><td></td><td></td><td></td>";
} else {
    foreach ($tasks as $task) {
        if ($task['category'] == "BMS") {
            if ($isBMS == 1) {
                if ($task['date'] > time()) {
                    $tableContent .= "<tr data-id='{$task['id']}' class='task-element'>";
                    $tableContent .= "<td>{$task['title']}</td>
<td>{$task['subject']}</td>";
                    $date = date("j. n. Y", $task['date']) . ' um ' . date('G:i', $task['date']);
                    $tableContent .= "<td>$date</td>";
                    $tableContent .= '<td><button type="button" class="btn btn-primary task-btn-open inverted" value="' . $task['id'] . '">Details</button></td>';
                } elseif ($task['date'] < (time() - 86400)) {
                    $db->deleteFromTable("tasks", new Key("id", $task['id']));
                }
            }

        } else {
            if ($task['date'] > time()) {
                $tableContent .= "<tr data-id='{$task['id']}' class='task-element'>";
                $tableContent .= "<td>{$task['title']}</td>
<td>{$task['subject']}</td>";
                $date = date("j. n. Y", $task['date']) . ' um ' . date('G:i', $task['date']);
                $tableContent .= "<td>$date</td>";
                $tableContent .= '<td><button type="button" class="btn btn-primary task-btn-open inverted" value="' . $task['id'] . '">Details</button></td>';
            } elseif ($task['date'] < (time() - 86400)) {
                $db->deleteFromTable("tasks", new Key("id", $task['id']));
            }
        }
    }

}

echo $tableContent;