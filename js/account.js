$(document).ready(function () {
    $("#account-email").on("keyup", function (event) {
        if (validateEmail($(this).val())) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            if (event.key == "Enter") {
                changeEmail();
            }
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
        }
        emailSubmitChanger();
    });

    $("#account-email-repeat").on("keyup", function (event) {
        if (validateEmail($(this).val())) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            if (event.key == "Enter") {
                changeEmail();
            }
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
        }
        emailSubmitChanger();
    });

    $(".password-change").each(function () {
        $(this).on("keyup", function (event) {
            $("#account-password-error").html("");
            if ($("#account-new-pw").val().length < 8 && $("#account-new-pw").val() != "") {
                $("#account-new-pw").removeClass("is-valid");
                $("#account-new-pwt").addClass("is-invalid");
                $("#btn-account-password-save").attr("disabled", "disabled");
                $("#account-password-error").html("Dein Passwort muss mindestens 8 Zeichen lang sein.");
            }  else if($("#account-new-pw").val() == $("#account-new-pw-repeat").val()) {
                $("#account-new-pw-repeat").removeClass("is-invalid");
                $("#account-new-pw-repeat").addClass("is-valid");
                $("#btn-account-password-save").removeAttr("disabled");
                $("#account-password-error").html("");
            } else {
                $("#account-new-pw-repeat").removeClass("is-valid");
                $("#account-new-pw-repeat").addClass("is-invalid");
                $("#btn-account-password-save").attr("disabled", "disabled");
                $("#account-password-error").html("Die Passwörter stimmen nicht überein!");
            }

            if(event.key == "Enter") {
                changePassword();
            }
        });
    });
});

function emailSubmitChanger() {
    if (validateEmail($("#account-email").val()) && validateEmail($("#account-email-repeat").val())) {
        if ($("#account-email").val() == $("#account-email-repeat").val()) {
            $("#btn-account-email-save").removeAttr("disabled");
            $("#account-email-error").html("");
        } else {
            $("#btn-account-email-save").attr("disabled", "disabled");
            $("#account-email-error").html("Die E-Mail Adressen stimmen nicht überein!");
        }
    } else {
        $("#btn-account-email-save").attr("disabled", "disabled");
        $("#account-email-error").html("");
    }
}

function changeEmail() {
    $("#account-email-error").html("");
    $("#account-email-success").html("");
    $("#account-email-loading").css("visibility", "visible");
    let queryData = {
        'email': $("#account-email").val(),
    };
    $.ajax({
        method: "POST",
        url: window.location.origin + "/php/changeEmail.php",
        data: queryData,
        timeout: 5000,
        success: function (data) {
            $("#account-email-loading").css("visibility", "hidden");
            if (data == "902") {
                $("#account-email-error").html("Du benutzt schon diese E-Mail.");
            } else if (data == "200") {
                $("#account-email-success").html("Eine Bestätigungsmail von <strong>noreply@lezurex.com</strong> wurde an die Adresse <strong>" + queryData.email + "</strong> gesendet. Schau eventuell auch im Spam-Ordner nach.");
            } else {
                $("#account-email-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#account-email-loading").css("visibility", "hidden");
            $("#account-email-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}

function changePassword() {
    $("#account-password-error").val("");
    $("#account-password-success").val("");
    let queryData = {
        'old-pw': $("#account-old-pw").val(),
        'new-pw': $("#account-new-pw-repeat").val()
    };
    $.ajax({
        method: "POST",
        url: "https://" + window.location.hostname + "/php/changePassword.php",
        data: queryData,
        timeout: 5000,
        success: function (data) {
            if (data == "902") {
                $("#account-password-error").html("Das eingegebene Passwort ist falsch!");
            } else if (data == "200") {
                $("#account-password-success").html("Dein Passwort wurde erfolgreich geändert!");
            } else {
                $("#account-password-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#account-password-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}