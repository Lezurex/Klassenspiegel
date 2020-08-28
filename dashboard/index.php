<?php

include "../php/templates.php";

session_start();

if(!isset($_SESSION['email'])) {
    header("Location: ../");
    exit();
}

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
    <script src="/js/login.js"></script>
</head>
<body>
<?php echo getNavbar($_SESSION) ?>

<table class="table" style="width:80%;margin:100px auto;">
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
</body>

