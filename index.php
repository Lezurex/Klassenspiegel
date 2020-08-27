<?php
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
    array_push($items, $row['hobby1']);
    array_push($items, $row['hobby2']);
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
    <td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_home . "' target='_blank' title='In Google Maps öffnen'>" . $value[2] . "</a></td>
    <td><a href='tel:" . $value[3] . "' title='Anrufen'>" . $value[3] . "</a></td>
    <td><a href='https://www.google.com/maps/search/?api=1&query=" . $maps_company . "' target='_blank' title='In Google Maps öffnen'>" . $value[4] . "</a></td>
    <td>" . $value[5] . " & " . $value[6] . "</td>
</tr>";
}

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klassenspiegel</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->
    <script src="js/jQuery.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
            integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
            crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script src="js/errorResolver.js"></script>
    <script src="js/login.js"></script>
</head>

<body>
<nav id="navbar">
    <img src="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico" id="nav-icon">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login" id="btn-login">
        Login
    </button>
</nav>
<table class="table" style="width:80%;margin:100px auto;">
    <thead>
    <th scope="col">Nachname</th>
    <th scope="col">Vorname</th>
    <th scope="col">Wohnort</th>
    <th scope="col">Mobil-Nr.</th>
    <th scope="col">Arbeitgeber</th>
    <th scope="col">Hobbys</th>
    </thead>

    <tbody>
    <?php echo $table; ?>
    </tbody>
</table>

<!-- Login Modal -->
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Einloggen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schliessen">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="login-email">E-Mail</label>
                    <input type="email" class="form-control" id="login-email" placeholder="max.mustermann@mustermail.ch">
                </div>
                <div class="form-group">
                    <label for="login-password">Passwort</label>
                    <input type="password" class="form-control" id="login-password" placeholder="Passwort">
                    <small id="login-error" class="form-text" style="color: red;"></small>
                    <small id="login-http-error" class="form-text" style="color: red;"></small>
                </div>
            </div>
            <div class="modal-footer">
                <a id="login-btn-register" class="float-left">Noch kein Konto?</a>
                <button id="login-login-btn" type="button" class="btn btn-success float-right" disabled>Login</button>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schliessen">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="register-email">E-Mail</label>
                    <input type="email" class="form-control" id="register-email" placeholder="max.mustermann@mustermail.ch">
                </div>
                <div class="form-group">
                    <label for="register-password">Passwort</label>
                    <input type="password" class="form-control" id="register-password" placeholder="Passwort">
                    <small id="register-error" class="form-text" style="color: red;"></small>
                    <small id="register-http-error" class="form-text" style="color: red;"></small>
                </div>
                <div class="form-group">

                </div>
            </div>
            <div class="modal-footer">
                <a id="register-btn-login" class="float-left">Schon registriert?</a>
                <button id="register-register-btn" type="button" class="btn btn-success float-right" disabled>Registrieren</button>
            </div>
        </div>
    </div>
</div>
<script src="js/login.js"></script>
<script src="js/register.js"></script>
</body>

</html>