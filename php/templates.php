<?php

$class_name = "AP20b";
$version = "v1.9.0";

function getNavbar($session) {
    global $class_name;
    $navbar = '<nav id="navbar">
    <ul class="list-unstyled">
        <li>
            <a href="/" class="inverted"><img src="https://tbz.ch/wp-content/themes/tbz/favicons/favicon.ico" alt="icon" height="40px"></a>
        </li>
        <li>
            <a href="/" class="link-unstyled"><h3 class="h3" id="nav-title">' . $class_name . '</h3></a>
        </li>';

    if (!isset($session['email'])) {
        $navbar .= '<li class="float-right"><a><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-login" id="btn-login">
    Login
        </button></a>';
    } else
        $navbar .= '
<li><a href="/dashboard/aufgaben" class="inverted">Aufgaben</a></li>
<li class="float-right inverted"><a href="/dashboard"><button type="button" class="btn btn-primary" id="btn-login">
    Dashboard
    </button></a></li>
    <li class="float-right inverted"><a href="/php/logout.php"><button type="button" class="btn btn-danger">
    Ausloggen
    </button></a>';

    $navbar .= '</li>
    </ul>
</nav>';
    return $navbar;
}

function getFooter()
{
    global $version;
    $footer = '
<div style="height: 50px"></div>
<footer class="page-footer font-small" style="">
  <div class="footer-copyright text-center py-3 footer">© 2021 Lenny Angst
    • <a href="https://github.com/Lezurex" target="_blank">GitHub</a>
    • <a href="https://github.com/Lezurex/Klassenspiegel/issues/new/choose" target="_blank">Bug melden/Feature vorschlagen</a>
    • ' . $version . '
  </div>
</footer>';
    return $footer;
}
