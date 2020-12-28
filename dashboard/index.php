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
foreach ($class_list as $value) if ($value['permitted'] == 1) {
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
    <title>AP20b - Dashboard</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="/css/style.css">

    <script src="/js/errorResolver.js"></script>
    <script src="/js/edit.js"></script>
    <script src="/js/account.js"></script>
    <script src="/js/login.js"></script>
    <script src="/js/darkmode.js"></script>
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
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="edit-bms" name="bms" <?php if ($user['isBms'] == 1)
                        echo "checked"; ?>>
                    <label class="form-check-label edit-input" for="edit-bms">
                        BMS?
                    </label>
                </div>
                <small class="text-success" id="edit-status"></small><br><br>
                <button type="button" id="btn-edit-save" class="btn btn-success float-right inverted">Speichern</button>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header"><strong>Accounteinstellungen</strong></div>
        <div class="card-body">
            <p>Deine aktuelle E-Mail Adresse lautet: <strong><?php echo $_SESSION['email'] ?></strong>. Du kannst sie
                hier ändern.</p>
            <p>
                <button class="btn btn-primary inverted" type="button" data-toggle="collapse"
                        data-target="#account-email-collapse"
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
                    <small id="account-email-success" class="text-success"></small>
                    <div class="spinner-border text-success" role="status" style="visibility: hidden;"
                         id="account-email-loading">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <br>

                    <button type="button" id="btn-account-email-save" class="btn btn-success float-right inverted" disabled
                            onclick="changeEmail();">Speichern
                    </button>
                </div>
            </div>
            <br>
            <p>
                <button class="btn btn-primary inverted" type="button" data-toggle="collapse"
                        data-target="#account-password-collapse"
                        aria-expanded="false" aria-controls="account-password">
                    Passwort ändern
                </button>
            </p>
            <div class="collapse" id="account-password-collapse">
                <div class="card card-body">
                    <label for="account-old-pw">Altes Passwort</label><input class="form-control password-change"
                                                                             type="password"
                                                                             name="old-pw"
                                                                             autocomplete="current-password"
                                                                             id="account-old-pw"><br>
                    <label for="account-new-pw">Neues Passwort</label><input class="form-control password-change"
                                                                             type="password"
                                                                             name="new-pw"
                                                                             id="account-new-pw"
                                                                             autocomplete="new-password"><br>

                    <label for="account-new-pw-repeat">Neues Passwort wiederholen</label><input
                            class="form-control password-change"
                            type="password"
                            name="new-pw-repeat"
                            id="account-new-pw-repeat"
                            autocomplete="new-password"><br>
                    <small id="account-password-error" class="text-danger"></small>
                    <small id="account-password-success" class="text-success"></small><br>
                    <button type="button" id="btn-account-password-save" class="btn btn-success float-right inverted" disabled>
                        Speichern
                    </button>
                </div>
            </div>
            <div class="custom-control custom-switch" id="switch-darkmode-wrapper">
                <input type="checkbox" class="custom-control-input" id="switch-darkmode" onclick="toggleDarkModeOnClick()">
                <label class="custom-control-label" for="switch-darkmode">Dark Mode</label>
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

<?php echo getFooter(); ?>


</body>

