<?php
include "../../php/templates.php";
include "../../php/config.php";
require "../../php/database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AP20b - Aufgaben</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

    <script src="/js/errorResolver.js"></script>
    <script src="/js/login.js"></script>
    <script src="/js/darkmode.js"></script>
    <script src="/js/tasks.js"></script>
    <link rel="stylesheet" href="/css/style.css">

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
                    <th scope="col">Titel</th>
                    <th scope="col">Fach</th>
                    <th scope="col">Fälligkeitsdatum</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="tasks-table-body">
                <tr>
                    <td colspan="4">
                        <div class="spinner-border" role="status" style="margin: 0 auto">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>
    <?php

    if ($_SESSION['email'] == "lenny.angst@easyid.ch") {
        $subjectOptions = "";
        foreach ($config['subjects'] as $subject) {
            $subjectOptions .= '<option value="' . $subject . '">' . $subject . '</option>';
        }
        echo '<div class="card">
        <div class="card-header">
            <strong>Aufgabe hinzufügen</strong>
        </div>
        <div class="card-body">
            <input class="form-control" id="task-add-title" placeholder="Titel"><br>
            <textarea id="task-add-description"></textarea><br>
            <input type="datetime-local" class="form-control" id="task-add-date" placeholder="Datum & Uhrzeit"><br>
            <select class="form-control" id="task-add-subject">
                ' . $subjectOptions . '
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
