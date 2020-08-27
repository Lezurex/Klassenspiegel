$().ready(function () {
    /**
     * Removes error message when changed
     */
    $("#login-email").keyup(function () {
        $("#login-email").removeClass("is-invalid");
        $("#login-error").html("");
        submitChangerLogin()
    });
    $("#login-password").keyup(function () {
        $("#login-password").removeClass("is-invalid");
        $("#login-error").html("");
        submitChangerLogin()
    });

    /**
     * E-Mail validation
     */
    $("#login-email").keyup(function () {
        let email = $("#login-email").val();
        if (validateEmail(email)) {
            $("#login-email").removeClass("is-invalid");
            $("#login-email").addClass("is-valid");
        } else {
            $("#login-email").removeClass("is-valid");
            $("#login-email").addClass("is-invalid");
        }
    });

    $("#login-email").unbind("keypress").bind("keypress", function (event) {
        if (event.code === 'Enter') {
            login();
        }
    });
    $("#login-password").unbind("keypress").bind("keypress", function (event) {
        if (event.code === 'Enter') {
            login();
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
    $("#login-login-btn").click(function (e) {
        e.preventDefault();
        login();
    })
});

function submitChangerLogin() {
    if (!$("#login-email").val() || !$("#login-password").val()) {
        $("#login-login-btn").attr("disabled", "disabled");
    } else {
        if (validateEmail($("#login-email").val())) {
            if ($("#login-password").val().length > 7) {
                $("#login-login-btn").removeAttr("disabled");
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
        'email':$("#login-email").val(),
        'password':$("#login-password").val()
    };
    $.ajax({
        method:"POST",
        url:"http://klassenspiegel.test/php/login.php",
        data: data,
        timeout:5000,
        success: function (data) {
            if(data == "901") {
                $("#login-email").addClass("is-invalid");
                $("#login-password").addClass("is-invalid");
                $("#login-http-error").html("Falsche E-Mail oder falsches Passwort!");
            } else if(data == "200") {
                window.location.href = "/dashboard";
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