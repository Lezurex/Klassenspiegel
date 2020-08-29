<?php

include "../php/templates.php";
include "../php/database.php";
require "../php/database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

$db = new DatabaseAdapter();

$host = "localhost";
$username = "root";
$password = "";
$database = "klassenspiegel";

$connection = mysqli_connect($host, $username, $password, $database);

$sql = "SELECT * FROM users ORDER BY lastname";
$result = mysqli_query($connection, $sql);
$items = array();
$array = array();

while ($row = mysqli_fetch_assoc($result)) {
    array_push($items, $row['lastname']);
    array_push($items, $row['firstname']);
    array_push($items, $row['location']);
    array_push($items, $row['phone']);
    array_push($items, $row['company']);
    array_push($items, $row['hobbys']);
    array_push($items, $row['email']);
    array_push($array, $items);
    $items = array();
}

$table = "";
foreach ($array as $key => $value) {
    $maps_home = str_replace(" ", "%20", $value[2]);
    $maps_company = str_replace(" ", "%20", $value[4]);
    $maps_home = str_replace(",", "%2C", $value[2]);
    $maps_company = str_replace(",", "%2C", $value[4]);
    $table .=
        "<tr>
    <td>" . $value[0] . "</td>
    <td>" . $value[1] . "</td>
    <td><a href='mailto:$value[6]'>" . $value[6] . "</a></td>
    <td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_home . "' target='_blank' title='In Google Maps öffnen'>" . $value[2] . "</a></td>
    <td><a href='tel:" . $value[3] . "' title='Anrufen'>" . $value[3] . "</a></td>
    <td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_company . "' target='_blank' title='In Google Maps öffnen'>" . $value[4] . "</a></td>
    <td>" . $value[5] . "</td>
</tr>";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klassenspiegel - Dashboard</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="/js/jQuery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/errorResolver.js"></script>
    <script src="/js/edit.js"></script>
</head>
<body>
<?php echo getNavbar($_SESSION) ?>

<h1 class="text-center" style="margin-top: 50px;">Dashboard</h1>
<p class="text-center"><?php
    $hour = (int)date("H");
    if($hour > 6 && $hour < 12) {
        $greeting = "Guten Morgen";
    } else if($hour > 11 && $hour < 14) {
        $greeting = "Guten Mittag";
    } else if($hour > 13 && $hour < 17) {
        $greeting = "Guten Nachmittag";
    } else if($hour > 16 && $hour < 23) {
        $greeting = "Guten Abend";
    } else {
        $greeting = "Gute Nacht";
    }

    $query = $db->getStringFromTable("users", "firstname", new Key("email", $_SESSION['email'])); //queryEntryFromTable("users", "firstname", "email", $_SESSION['email']);
    if($query == "Kein Eintrag") {
        echo "$greeting!";
    } else
        echo "$greeting, $query!";
    ?></p>

<div class="card-deck" style="margin: 50px 5%">
    <div class="card" id="card-edit">
        <div class="card-header"><strong>Dein Eintrag in der Klassenliste</strong></div>
        <div class="card-body">
            <form>
                <label for="edit-lastname">Nachname</label><input class="form-control" type="text" name="lastname"
                                                                  autocomplete="family-name"
                                                                  id="edit-lastname" placeholder="Nachname"><br>
                <label for="edit-firstname">Vorname</label><input class="form-control" type="text" name="firstname"
                                                                  autocomplete="given-name"
                                                                  id="edit-firstname" placeholder="Vorname"><br>
                <label for="edit-location">Wohnort</label><input class="form-control" type="text" name="location"
                                                                 autocomplete="street-address"
                                                                 id="edit-location" placeholder="Wohnort"><br>
                <label for="edit-phone">Handynummer</label><input class="form-control" type="text" name="phone"
                                                                  autocomplete="tel"
                                                                  id="edit-phone"
                                                                  placeholder="Handynummer (+41 000 000 00 00)"
                                                                  pattern="^([0][1-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$|^(([0][0]|\+)[1-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$"><br>
                <small style="color: red;" id="edit-phone-error"></small>
                <label for="edit-company">Arbeitgeber</label><input class="form-control" type="text" name="company"
                                                                    id="edit-company" placeholder="Arbeitgeber"><br>
                <label for="edit-hobbys">Hobbys</label><input class="form-control" type="text" name="hobbys"
                                                              id="edit-hobbys" placeholder="Hobbys"><br>
                <button type="button" id="btn-edit-save" class="btn btn-success float-right">Speichern</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><strong>Accounteinstellungen</strong></div>
        <div class="card-body">

        </div>
    </div>
</div>
<div class="card-deck" style="margin: 50px 5%">
    <div class="card">
        <div class="card-header"><strong>Klassenliste</strong></div>
        <div class="card-body">
            <div class="overflow-auto">
                <table class="table">
                    <thead>
                    <th scope="col">Nachname</th>
                    <th scope="col">Vorname</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Wohnort</th>
                    <th scope="col">Mobil-Nr.</th>
                    <th scope="col">Arbeitgeber</th>
                    <th scope="col">Hobbys</th>
                    </thead>

                    <tbody>
                    <?php echo $table; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</body>

