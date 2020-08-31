<?php

include "../php/templates.php";
require "../php/database/DatabaseAdapter.php";

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

$db = new DatabaseAdapter();

$class_list = $db->getAllStringsFromTable("users", "lastname");
$user = $db->getStringsFromTable("users", new Key("email", $_SESSION['email']));

$table = "";
foreach ($class_list as $key => $value) if ($value['permitted'] == 1) {
    foreach ($value as $key => $element) {
        if ($element == "") {
            $value[$key] = "Kein Eintrag";
        }
    }
    $maps_home = str_replace(" ", "%20", $value['location']);
    $maps_company = str_replace(" ", "%20", $value['company']);
    $maps_home = str_replace(",", "%2C", $value['location']);
    $maps_company = str_replace(",", "%2C", $value['company']);
    $table .=
        "<tr>
<td>" . $value['lastname'] . "</td>
<td>" . $value['firstname'] . "</td>
<td><a href='mailto:" . $value['email'] . "'>" . $value['email'] . "</a></td>
<td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_home . "' target='_blank' title='In Google Maps öffnen'>" . $value['location'] . "</a></td>
<td><a href='tel:" . $value['phone'] . "' title='Anrufen'>" . $value['phone'] . "</a></td>
<td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_company . "' target='_blank' title='In Google Maps öffnen'>" . $value['company'] . "</a></td>
<td>" . $value['hobbys'] . "</td>
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
    <script src="/js/account.js"></script>
</head>
<body>
<?php echo getNavbar($_SESSION) ?>

<h1 class="text-center" style="margin-top: 50px;">Dashboard</h1>
<p class="text-center"><?php
    $hour = (int)date("H");
    if ($hour > 6 && $hour < 12) {
        $greeting = "Guten Morgen";
    } else if ($hour > 11 && $hour < 14) {
        $greeting = "Guten Mittag";
    } else if ($hour > 13 && $hour < 17) {
        $greeting = "Guten Nachmittag";
    } else if ($hour > 16 && $hour < 23) {
        $greeting = "Guten Abend";
    } else {
        $greeting = "Gute Nacht";
    }

    $query = $db->getStringFromTable("users", "firstname", new Key("email", $_SESSION['email']));
    if ($query == "") {
        echo "$greeting!";
    } else
        echo "$greeting, $query!";
    ?></p>

<div class="card-deck" style="margin: 50px 5%">
    <div class="card" id="card-edit">
        <div class="card-header"><strong>Dein Eintrag in der Klassenliste</strong></div>
        <div class="card-body">
            <form>
                <label for="edit-lastname">Nachname</label><input class="form-control edit-input" type="text"
                                                                  name="lastname"
                                                                  autocomplete="family-name"
                                                                  id="edit-lastname" placeholder="Nachname"
                                                                  value="<?php echo $user['lastname']; ?>"><br>
                <label for="edit-firstname">Vorname</label><input class="form-control edit-input" type="text"
                                                                  name="firstname"
                                                                  autocomplete="given-name"
                                                                  id="edit-firstname" placeholder="Vorname"
                                                                  value="<?php echo $user['firstname']; ?>"><br>
                <label for="edit-location">Wohnadresse</label><input class="form-control edit-input" type="text"
                                                                     name="location"
                                                                     autocomplete="street-address"
                                                                     id="edit-location" placeholder="Wohnort"
                                                                     value="<?php echo $user['location']; ?>"><br>
                <label for="edit-phone">Handynummer</label><input class="form-control edit-input" type="text"
                                                                  name="phone"
                                                                  autocomplete="tel"
                                                                  id="edit-phone"
                                                                  placeholder="Handynummer (+41 000 000 00 00)"
                                                                  pattern="^([0][1-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$|^(([0][0]|\+)[1-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9][0-9](\s|)[0-9][0-9](\s|)[0-9][0-9])$"
                                                                  value="<?php echo $user['phone']; ?>">
                <small style="color: red;" id="edit-phone-error"> </small><br>
                <label for="edit-company">Arbeitgeber</label><input class="form-control edit-input" type="text"
                                                                    name="company"
                                                                    id="edit-company" placeholder="Arbeitgeber"
                                                                    value="<?php echo $user['company']; ?>"><br>
                <label for="edit-hobbys">Hobbys</label><input class="form-control edit-input" type="text" name="hobbys"
                                                              id="edit-hobbys" placeholder="Hobbys"
                                                              value="<?php echo $user['hobbys']; ?>"><br>
                <small class="text-success" id="edit-status"></small><br><br>
                <button type="button" id="btn-edit-save" class="btn btn-success float-right">Speichern</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><strong>Accounteinstellungen</strong></div>
        <div class="card-body">
            <p>Deine aktuelle E-Mail Adresse lautet: <strong><?php echo $_SESSION['email'] ?></strong>. Du kannst sie
                hier ändern.</p>
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#account-email-collapse"
                        aria-expanded="false" aria-controls="account-email">
                    E-Mail ändern
                </button>
            </p>
            <div class="collapse" id="account-email-collapse">
                <div class="card card-body">
                    <label for="account-email">Neue E-Mail</label><input class="form-control" type="email" name="email"
                                                                         id="account-email"
                                                                         placeholder="max.mustermann@mustermail.ch"><br>
                    <label for="account-email-repeat">Neue E-Mail wiederholen</label><input class="form-control"
                                                                                            type="email"
                                                                                            name="email-repeat"
                                                                                            id="account-email-repeat"
                                                                                            placeholder="max.mustermann@mustermail.ch"><br>
                    <small id="account-email-error" class="text-danger"></small>
                    <small id="account-email-success" class="text-success"></small><br>

                    <button type="button" id="btn-account-email-save" class="btn btn-success float-right" disabled onclick="changeEmail();">Speichern</button>
                </div>
            </div>
            <br>
            <p>
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#account-password-collapse"
                        aria-expanded="false" aria-controls="account-password">
                    Passwort ändern
                </button>
            </p>
            <div class="collapse" id="account-password-collapse">
                <div class="card card-body">

                    <button type="button" id="btn-account-password-save" class="btn btn-success float-right">Speichern
                    </button>
                </div>
            </div>
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
                    <th scope="col">Wohnadresse</th>
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

