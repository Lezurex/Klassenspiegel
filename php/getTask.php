<?php

require "database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    echo "401";
    exit();
}

$db = new DatabaseAdapter();

$task = $db->getStringsFromTable("tasks", new Key("id", $_POST['id']));
$date = date("j. n. Y", $task['date']) . ' um ' . date('G:i', $task['date']);

if ($_SESSION['email'] == "lenny.angst@easyid.ch") {
    $date = date('Y-m-d', $task['date']) . "T" . date('H:i', $task['date']);
    $exit = "<div class='modal-header'>
                <input class='form-control form-control-lg modal-header' id='task-edit-title' type='text' placeholder='Titel' value='" . $task['title'] . "'>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <textarea id='task-edit-description'>" . $task['description'] . "</textarea><br>
                <input type='datetime-local' class='form-control' id='task-edit-date' placeholder='Datum & Uhrzeit' value='$date'><br>
                <select class='form-control' id='task-edit-subject'>
                <option value='Mathematik'>Mathematik</option>
                <option value='Französisch'>Französisch</option>
                <option value='Geschichte & Politik'>Geschichte & Politik</option>
                <option value='Naturwissenschaften & Chemie'>Naturwissenschaften & Chemie</option>
                <option value='Wirtschaft & Recht'>Wirtschaft & Recht</option>
                <option value='Modul 100'>Modul 100</option>
                <option value='Modul 117'>Modul 117</option>
            </select><br>";
    switch ($task['category']) {
        case "BMS":
            $exit .= "<select class='form-control' id='task-edit-category'>
    <option selected value='BMS'>BMS</option>
    <option value='TBZ'>TBZ</option>
</select>";
            break;
        case "TBZ":
            $exit .= "<select class='form-control' id='task-edit-category'>
    <option value='BMS'>BMS</option>
    <option selected value='TBZ'>TBZ</option>
</select>";
    }
    $exit .= "<input value='{$task['id']}' id='task-edit-id' style='display: none'>
<input value='{$task['subject']}' id='task-edit-subject' style='display: none'>
<small class='text-success' id='task-edit-success'></small>
<small class='text-danger' id='task-edit-error'></small>
</div><div class='modal-footer'>
                <button id='task-edit-save' type='button' class='btn btn-success' onclick='editTask();'>Speichern</button>
            </div>";
    echo $exit;

} else {
    echo
        "<div class='modal-header'>
                <h5 class='modal-title' id='modal-task-title'>{$task['title']}</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
            <div class='modal-body'>
                <p>Beschreibung:<br>" . nl2br($task['description']) . "</p>
                <p>Fällig am: {$date}</p>
                <p>Fach: {$task['subject']}</p>
            </div>
            <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Schliessen</button>
            </div>";
}