$().ready(function () {
    /**
     * Removes error message when changed
     */
    $("#register-email").keyup(function () {
        $("#register-email").removeClass("is-invalid");
        $("#register-error").html("");
        submitChangerRegister()
    });
    $("#register-password").keyup(function () {
        $("#register-password").removeClass("is-invalid");
        $("#register-error").html("");
        submitChangerRegister()
    });
    /**
     * E-Mail validation
     */
    $("#register-email").keyup(function () {
        let email = $("#register-email").val();
        if (validateEmail(email)) {
            $("#register-email").removeClass("is-invalid");
            $("#register-email").addClass("is-valid");
        } else {
            $("#register-email").removeClass("is-valid");
            $("#register-email").addClass("is-invalid");
        }
    });

    $("#register-email").unbind("keypress").bind("keypress", function (event) {
        if (event.code === 'Enter') {
            register();
        }
    });
    $("#register-password").unbind("keypress").bind("keypress", function (event) {
        if (event.code === 'Enter') {
            register();
        }
    });

    /**
     * Register link
     */
    $("#register-btn-login").click(function (e) {
        e.preventDefault();
        $("#modal-register").modal("hide");
        $("#modal-login").modal("show");
    })
});

function submitChangerRegister() {
    if (!$("#register-email").val() || !$("#register-password").val()) {
        $("#register-register-btn").attr("disabled", "disabled");
    } else {
        if (validateEmail($("#register-email").val())) {
            if ($("#register-password").val().length > 7) {
                $("#register-register-btn").removeAttr("disabled");
            }
        }
    }
}

function register() {
    if (!$("#register-email").val() || !$("#register-password").val()) {
        $("#register-email").addClass("is-invalid");
        $("#register-password").addClass("is-invalid");
        $("#register-error").text("Es sind nicht alle Felder ausgefüllt.");
        return;
    } else {
        if (validateEmail($("#register-email").val())) {
            if ($("#register-password").val().length < 8) {
                return;
            }
        } else return;
    }

    let data = {
        'email':$("#register-email").val(),
        'password':$("#register-password").val()
    };
    $.ajax({
        method:"POST",
        url:"http://klassenspiegel.test/php/register.php",
        data: data,
        timeout:5000,
        success: function (data) {
            if(data == "902") {
                $("#register-http-error").html("Du bist schon registriert!");
            } else if(data == "200") {
                window.location.href = "/dashboard";
            }
        },
        error: function (xhr, status, error) {
            $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}