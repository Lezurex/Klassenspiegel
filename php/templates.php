<?php

$class_name = "AP20b";

function getNavbar($session) {
    global $class_name;
    $navbar = '<nav id="navbar">
    <ul class="list-unstyled">
        <li>
            <a href="/"><img src="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico" alt="icon" height="40px"></a>
        </li>
        <li>
            <a href="/" class="link-unstyled"><h3 class="h3" id="nav-title">'.$class_name.'</h3></a>
        </li>';

    if (!isset($session['email'])) {
        $navbar .= '<li class="float-right"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login" id="btn-login">
    Login
        </button>';
    } else
        $navbar .= '
<li><a href="/dashboard/aufgaben">Aufgaben</a></li>
<li class="float-right"><a href="/dashboard"><button type="button" class="btn btn-primary" id="btn-login">
    Dashboard
    </button></a></li>
    <li class="float-right"><a href="/php/logout.php"><button type="button" class="btn btn-danger">
    Ausloggen
    </button></a>';

    $navbar .= '</li>
    </ul>
</nav>';
    return $navbar;
}
