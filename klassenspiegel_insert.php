<head>
  <meta http-equiv='refresh' content='2; URL=klassenspiegel.php'>
  <link rel="shortcut icon" href="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico">
</head>
<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "test";

$connection = mysqli_connect($host, $username, $password, $database);

echo '<!-- CSS only -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>';

$sql = "SELECT `lastname` FROM klassenspiegel";
    $result = mysqli_query($connection, $sql);
    while($row = mysqli_fetch_assoc($result)) {
      $lastname = $row['lastname'];
    }

if($_POST['lastname'] == $lastname) {
    echo "Du bist schon eingetragen!";
    exit();
}

$sql = "INSERT into `klassenspiegel` (`lastname`,`firstname`,`location`,`phone`,`company`,`hobby1`,`hobby2`) 
VALUES ('".$_POST['lastname']."','".$_POST['firstname']."','".$_POST['location']."','".$_POST['phone']."','".$_POST['company']."',
'".$_POST['hobby1']."','".$_POST['hobby2']."')";
mysqli_query($connection, $sql);

echo '<div class="alert alert-success" role="alert" style="margin:10px auto;width:50%;vertical-align:middle;">
Dein Eintrag wurde erfolgreich erfasst! Du wirst gleich weitergeleitet...
</div>';