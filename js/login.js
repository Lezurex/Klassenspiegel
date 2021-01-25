$("#login-email").val(getCookie("email"));

/**
 * Removes error message when changed
 */
$("#login-email").on("keyup", function (event) {
    $("#login-email").removeClass("is-invalid");
    $("#login-error").html("");
    submitChangerLogin();
    if (event.code === 'Enter') {
        login();
    }
});
$("#login-password").on("keyup", function (event) {
    $("#login-password").removeClass("is-invalid");
    $("#login-error").html("");
    submitChangerLogin();
    if (event.code === 'Enter') {
        login();
    }
});

/**
 * E-Mail validation
 */
$("#login-email").on("keyup", function () {
    let email = $("#login-email").val();
    if (validateEmail(email)) {
        $("#login-email").removeClass("is-invalid");
        $("#login-email").addClass("is-valid");
    } else {
        $("#login-email").removeClass("is-valid");
        $("#login-email").addClass("is-invalid");
    }
});

/**
 * Register link
 */
$("#login-btn-register").click(function (e) {
    e.preventDefault();
    $("#modal-login").modal("hide");
    $("#modal-register").modal("show");
});

/**
 * Login button
 */
$("#login-login-btn").on("click", function (e) {
    e.preventDefault();
    login();
});

function submitChangerLogin() {
    if (!$("#login-email").val() || !$("#login-password").val()) {
        $("#login-login-btn").attr("disabled", "disabled");
    } else {
        if (validateEmail($("#login-email").val())) {
            if ($("#login-password").val().length > 7) {
                $("#login-login-btn").removeAttr("disabled");
            } else {
                $("#login-login-btn").attr("disabled", "disabled");
            }
        }
    }
}

function login() {
    if (!$("#login-email").val() || !$("#login-password").val()) {
        $("#login-email").addClass("is-invalid");
        $("#login-password").addClass("is-invalid");
        $("#login-error").text("Es sind nicht alle Felder ausgefüllt.");
        return;
    } else {
        if (validateEmail($("#login-email").val())) {
            if ($("#login-password").val().length < 8) {
                return;
            }
        } else return;
    }

    let data = {
        'email': $("#login-email").val(),
        'password': $("#login-password").val()
    };
    $.ajax({
        method: "POST",
        url: window.location.origin + "/php/login.php",
        data: data,
        timeout: 5000,
        success: function (data) {
            if (data == "901") {
                $("#login-email").addClass("is-invalid");
                $("#login-password").addClass("is-invalid");
                $("#login-http-error").html("Falsche E-Mail oder falsches Passwort!");
            } else if (data == "905") {
                $("#login-http-error").html("Dein Konto wurde noch nicht freigeschaltet. Wende dich bei einer längeren Wartezeit an den Websiteadministrator.");
            } else if (data == "200") {
                if ($("#login-remember").get(0).checked) {
                    setCookie("email", $("#login-email").val(), 30);
                }
                window.location.href = "/dashboard/aufgaben";
            } else {
                $("#login-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#login-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function setCookie(cname, cvalue, exdays) {
    console.log("set cookie: " + cvalue);
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}