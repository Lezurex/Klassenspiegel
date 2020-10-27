<?php
include "php/templates.php";

session_start();

global $class_name;

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AP20b - Home</title>
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
    <script src="/bootstrap/js/bootstrap.min.js"></script>

    <script src="/js/errorResolver.js"></script>
    <script src="/js/login.js"></script>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
<?php echo getNavbar($_SESSION); ?>

<h1 class="text-center" style="margin-top: 50px">Klasse <?php echo $class_name; ?></h1>
<p role="doc-introduction" class="text-center">Das Webportal der Klasse</p>

<!-- Login Modal -->
<div class="modal fade" id="modal-login" tabindex="-1" role="dialog" aria-labelledby="modal-login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" role="heading">
                <h5 role="heading" class="modal-title">Einloggen</h5>
                <button role="button" type="button" class="close" data-dismiss="modal" aria-label="Schliessen"
                        style="outline: none;">
                    <span aria-hidden="true" style="outline: none">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="login-email">E-Mail</label>
                    <input type="email" class="form-control" id="login-email"
                           placeholder="max.mustermann@mustermail.ch" autocomplete="username"
                           aria-labelledby="login-email">
                </div>
                <div class="form-group">
                    <label for="login-password">Passwort</label>
                    <input type="password" class="form-control" id="login-password" placeholder="Passwort"
                           autocomplete="current-password">
                    <small id="login-error" class="form-text" style="color: red;"></small>
                    <small id="login-http-error" class="form-text" style="color: red;"></small>
                </div>
                <a href="#" id="login-btn-reset">Passwort vergessen?</a>
            </div>
            <div class="modal-footer">
                <a id="login-btn-register" class="float-left">Noch kein Konto?</a>
                <button id="login-login-btn" type="button" class="btn btn-success float-right" disabled>Login</button>
            </div>
        </div>
    </div>
</div>

<!-- Register Modal -->
<div class="modal fade" id="modal-register" tabindex="-1" role="dialog" aria-labelledby="modal-register"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrieren</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Schliessen" style="outline: none">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="register-email">E-Mail</label>
                    <input type="email" class="form-control" id="register-email"
                           placeholder="max.mustermann@mustermail.ch"
                           autocomplete="email">
                </div>
                <div class="form-group">
                    <label for="register-password">Passwort</label>
                    <input type="password" class="form-control" id="register-password"
                           aria-describedby="register-password-hint"
                           placeholder="Passwort" autocomplete="new-password">
                    <small id="register-password-hint" class="text-muted">Dein Passwort muss mindestens 8 Zeichen lang
                        sein.</small>
                    <small id="register-error" class="form-text" style="color: red;"></small>
                    <small id="register-http-error" class="form-text" style="color: red;"></small>
                    <small id="register-success" class="form-text text-success"></small>
                </div>
                <div class="form-group">

                </div>
            </div>
            <div class="modal-footer">
                <a id="register-btn-login" class="float-left">Schon registriert?</a>
                <button id="register-register-btn" type="button" class="btn btn-success float-right" disabled>
                    Registrieren
                </button>
            </div>
        </div>
    </div>
</div>

<!--Reset-->
<div class="modal fade" id="modal-reset" tabindex="-1" role="dialog" aria-labelledby="modal-reset" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="reset-content1">
            <div class="modal-header" role="heading">
                <h5 role="heading" class="modal-title">Passwort zurücksetzen</h5>
                <button role="button" type="button" class="close" data-dismiss="modal" aria-label="Schliessen"
                        style="outline: none;">
                    <span aria-hidden="true" style="outline: none">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="reset-email">E-Mail</label>
                    <input type="email" class="form-control" id="reset-email"
                           placeholder="max.mustermann@mustermail.ch" autocomplete="username"
                           aria-labelledby="login-email">
                </div>
                <small id="reset-error" class="form-text" style="color: red;"></small>
                <small id="reset-http-error" class="form-text" style="color: red;"></small>
                <small class="form-text">Du erhältst eine E-Mail mit einem Code.</small>
            </div>
            <div class="modal-footer">
                <button id="reset-reset-btn" type="button" class="btn btn-danger float-right">Passwort zurücketzen</button>
            </div>
        </div>
        <div class="modal-content" id="reset-content2" style="display: none">
            <!-- TODO add reset code input -->
            <div class="modal-header" role="heading">
                <h5 role="heading" class="modal-title">Passwort zurücksetzen</h5>
                <button role="button" type="button" class="close" data-dismiss="modal" aria-label="Schliessen"
                        style="outline: none;">
                    <span aria-hidden="true" style="outline: none">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Ein Verifikationscode wurde nun an <strong id="reset2-strong-mail"></strong> gesendet! Gib diesen nun hier ein.
                Sieh eventuell auch im Spam-Ordner nach!</p><br>
                <input class="form-control form-control-lg reset-code" placeholder="123456" maxlength="6" minlength="6">
            </div>
            <div class="modal-footer">
                <button id="reset-reset-btn" type="button" class="btn btn-danger float-right">Passwort zurücketzen</button>
            </div>
        </div>
    </div>
</div>

<div class="card-deck" style="margin: 50px 5%">
    <div class="card"
    ">
    <div class="card-header">Nützliche Links</div>
    <div class="card-body">
        <h3>TBZ</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="https://ecolm.com" target="_blank">Ecolm TBZ</a></li>
            <li class="list-group-item"><a href="https://bscw.tbz.ch/bscw/bscw.cgi" target="_blank">BSCW TBZ</a></li>
            <li class="list-group-item"><a href="https://edu.juergarnold.ch/" target="_blank">edu.JuergArnold.ch</a>
            </li>
        </ul>
        <h3 style="margin-top: 20px">BMZ</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="https://intranet.tam.ch/bmz/" target="_blank">Intranet BMZ</a></li>
        </ul>
        <h3 style="margin-top: 20px">Quizlet (BMS)</h3>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><a href="https://quizlet.com/Lezurex/folders/langenscheidt-franzosisch"
                                           target="_blank">Französisch</a></li>
            <li class="list-group-item"><a href="https://quizlet.com/Lezurex/folders/chemie" target="_blank">Chemie</a>
            </li>
        </ul>
    </div>
</div>
</div>
<?php echo getFooter(); ?>

<script src="js/login.js"></script>
<script src="js/register.js"></script>
<script src="js/reset.js"></script>
</body>

</html>