<?php
include "../../php/templates.php";
require "../../php/database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

$db = new DatabaseAdapter();
$isBMS = $db->getIntegerFromTable("users", "isBms", new Key("email", $_SESSION['email']));

$tasks = $db->getAllStringsFromTable("tasks", "date");
$tableContent = "";

if ($tasks == null) {
    $tableContent = "<td>Keine Aufgaben!</td><td></td><td></td><td></td><td></td>";
} else {
    foreach ($tasks as $task) {
        if ($task['category'] == "BMS") {
            if ($isBMS == 1) {
                if ($task['date'] > time()) {
                    $tableContent .= "<tr data-id='{$task['id']}' class='task-element'>";
                    $tableContent .= "<td>{$task['id']}</td>
<td>{$task['title']}</td>
<td>{$task['subject']}</td>";
                    $date = date("j. n. Y", $task['date']) . ' um ' . date('G:i', $task['date']);
                    $tableContent .= "<td>$date</td>";
                    $tableContent .= '<td><button type="button" class="btn btn-primary task-btn-open inverted" value="' . $task['id'] . '">Details</button></td>';
                }
            }

        } else {
            if ($task['date'] > time()) {
                $tableContent .= "<tr data-id='{$task['id']}' class='task-element'>";
                $tableContent .= "<td>{$task['id']}</td>
<td>{$task['title']}</td>
<td>{$task['subject']}</td>";
                $date = date("j. n. Y", $task['date']) . ' um ' . date('G:i', $task['date']);
                $tableContent .= "<td>$date</td>";
                $tableContent .= '<td><button type="button" class="btn btn-primary task-btn-open inverted" value="' . $task['id'] . '">Details</button></td>';
            }
        }
    }

}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AP20b - Aufgaben</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script src="/js/errorResolver.js"></script>
    <script src="/js/tasks.js"></script>
    <script src="/js/login.js"></script>
    <script src="/js/darkmode.js"></script>
</head>
<body>

<?php echo getNavbar($_SESSION); ?>

<div class="modal fade" id="modal-task" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" id="modal-task-content">

        </div>
    </div>
</div>

<h1 class="text-center" style="margin-top: 50px;">Aufgaben & Prüfungen</h1>
<p class="text-center">Alle Angaben ohne Gewähr</p>

<div class="card-deck" style="margin: 50px 5%">
    <div class="card">
        <div class="card-header">
            <strong>Aufgaben</strong>
        </div>
        <div class="card-body overflow-auto">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Titel</th>
                    <th scope="col">Fach</th>
                    <th scope="col">Fälligkeitsdatum</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php echo $tableContent ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php

    if ($_SESSION['email'] == "lenny.angst@easyid.ch") {
        echo '<div class="card">
        <div class="card-header">
            <strong>Aufgabe hinzufügen</strong>
        </div>
        <div class="card-body">
            <input class="form-control" id="task-add-title" placeholder="Titel"><br>
            <textarea id="task-add-description"></textarea><br>
            <input type="datetime-local" class="form-control" id="task-add-date" placeholder="Datum & Uhrzeit"><br>
            <select class="form-control" id="task-add-subject">
                <option value="Mathematik">Mathematik</option>
                <option value="Französisch">Französisch</option>
                <option value="Geschichte & Politik">Geschichte & Politik</option>
                <option value="Naturwissenschaften & Chemie">Naturwissenschaften & Chemie</option>
                <option value="Wirtschaft & Recht">Wirtschaft & Recht</option>
                <option value="Modul 100">Modul 100</option>
                <option value="Modul 117">Modul 117</option>
                <option value="Modul 403">Modul 403</option>
                <option value="Modul 431">Modul 431</option>
            </select><br>
            <select class="form-control" id="task-add-category">
                <option value="BMS">BMS</option>                
                <option value="TBZ">TBZ</option>
            </select><br>
            <small class="text-success" id="task-add-success"></small>
            <small class="text-danger" id="task-add-error"></small>
            <button class=" btn btn-success" type="button" style="margin-top: 50px; float: right" id="task-add-btn">Hinzufügen</button>
        </div>
    </div>
    <script>$("#task-add-description").summernote();</script>';
    }

    ?>
</div>
<?php echo getFooter(); ?>

</body>
</html>
