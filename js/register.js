$().ready(function () {
    /**
     * Removes error message when changed
     */
    $("#register-email").on("keyup", function (event) {
        $("#register-email").removeClass("is-invalid");
        $("#register-error").html("");
        submitChangerRegister();
        let email = $("#register-email").val();
        if (validateEmail(email)) {
            $("#register-email").removeClass("is-invalid");
            $("#register-email").addClass("is-valid");
        } else {
            $("#register-email").removeClass("is-valid");
            $("#register-email").addClass("is-invalid");
        }
        if (event.code === 'Enter') {
            register();
        }
    });

    $("#register-password").on("keyup", function (event) {
        $("#register-password").removeClass("is-invalid");
        $("#register-error").html("");
        submitChangerRegister()
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
    });

    /**
     * Register button
     */
    $("#register-register-btn").click(function (e) {
        e.preventDefault();
        register();
    })
});

function submitChangerRegister() {
    if (!$("#register-email").val() || !$("#register-password").val()) {
        $("#register-register-btn").attr("disabled", "disabled");
    } else {
        if (validateEmail($("#register-email").val())) {
            if ($("#register-password").val().length > 7) {
                $("#register-password").removeClass("is-invalid");
                $("#register-password").addClass("is-valid");
                $("#register-register-btn").removeAttr("disabled");
            } else {
                $("#register-password").addClass("is-invalid");
                $("#register-register-btn").attr("disabled", "disabled");
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
        url:"https://" + window.location.hostname + "/php/register.php",
        data: data,
        timeout:5000,
        success: function (data) {
            if(data == "902") {
                $("#register-http-error").html("Du bist schon registriert!");
            } else if(data == "903") {
                $("#register-error").html("Dies ist keine gültige E-Mail!");
                $("#register-email").addClass("is-invalid");
            } else if(data == "200") {
                $("#register-success").html("Du wurdest erfolgreich registriert! Du kannst dich erst einloggen, wenn dein Konto freigeschaltet wurde.");
            } else {
                $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}