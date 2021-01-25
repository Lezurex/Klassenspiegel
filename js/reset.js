let code;

$("#login-btn-reset").on("click", function (e) {
    e.preventDefault();
    $("#reset-email").val(getCookie("email"));
    $("#modal-login").modal("hide");
    $("#modal-reset").modal("show");
});

$("#reset-reset-btn").on("click", function () {
    requestCode();
});

$("#reset-email").on("keyup", function (e) {
    if (e.keyCode === 13)
        requestCode();
});

function requestCode() {
    if (validateEmail($("#reset-email").val())) {
        $("#reset-reset-btn").html("<span class=\"spinner-border spinner-border-sm\" role=\"status\" aria-hidden=\"true\"></span>\n" +
            "  Lädt...").attr("disabled", "disabled");

        $("#reset-email").removeClass("is-invalid");
        $("#reset-error").text("");
        $("#reset-http-error").text("");

        let data = {
            'email': $("#reset-email").val()
        };

        $.ajax({
            method: "POST",
            url: window.location.origin + "/php/reset/send.php",
            data: data,
            timeout: 5000,
            success: function (data) {
                if (data == "901") {
                    $("#reset-email").addClass("is-invalid");
                    $("#reset-error").html("Diese E-Mail ist nicht registriert oder wurde noch nicht freigeschaltet!");
                } else if (data == "200") {
                    $("#reset-content1").css("display", "none");
                    $("#reset-content2").css("display", "inherit");
                    $("#reset2-strong-mail").text($("#reset-email").val());
                    $("#reset-reset-btn").html("Code anfordern").removeAttr("disabled");
                } else {
                    $("#reset-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
                    $("#reset-reset-btn").html("Code anfordern").removeAttr("disabled");
                }
            },
            error: function (xhr, status, error) {
                $("#reset-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
                $("#reset-reset-btn").html("Code anfordern").removeAttr("disabled");
            }
        });
    } else {
        $("#reset-email").addClass("is-invalid");
        $("#reset-error").text("Dies ist keine gültige E-Mail!");
    }
}
let verifyBtn = $("#reset-verify-btn");
let resetCode = $("#reset-code")
resetCode.on("keyup", function () {
    if (resetCode.val().length === 6) {
        verifyBtn.removeAttr("disabled");
        resetCode.removeClass("is-invalid");
        $("#reset-code-error").html("");
    } else {
        verifyBtn.attr("disabled", "disabled");
    }

});

verifyBtn.on("click", function () {
    verifyCode();
});

function verifyCode() {
    if (resetCode.val().length === 6) {
        let data = {
            'email': $("#reset-email").val(),
            'code': resetCode.val()
        };

        $.ajax({
            method: "POST",
            url: window.location.origin + "/php/reset/verify.php",
            data: data,
            timeout: 5000,
            success: function (data) {
                if (data == "901") {
                    $("#reset-code").addClass("is-invalid");
                    $("#reset-code-error").html("Dieser Code ist ungültig!");
                } else if (data == "200") {
                    $("#reset-content2").css("display", "none");
                    $("#reset-content3").css("display", "inherit");
                } else {
                    $("#reset-code-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
                }
            },
            error: function (xhr, status, error) {
                $("#reset-code-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        });
    }
}

let resetBtn = $("#reset-password-btn");
let newPassword = $("#reset-password")
resetCode.on("keyup", function () {
    if (resetCode.val().length >= 6) {
        resetBtn.removeAttr("disabled");
        newPassword.removeClass("is-invalid");
        $("#reset-password-error").html("");
    } else {
        resetBtn.attr("disabled", "disabled");
    }

});

resetBtn.on("click", function () {
    resetPassword();
});

function resetPassword() {
    if (newPassword.val().length >= 8) {
        let data = {
            'email': $("#reset-email").val(),
            'code': resetCode.val(),
            'password': newPassword.val()
        };

        $.ajax({
            method: "POST",
            url: window.location.origin + "/php/reset/reset.php",
            data: data,
            timeout: 5000,
            success: function (data) {
                if (data === "200") {
                    window.location.href = "/dashboard/aufgaben";
                } else {
                    $("#reset-password-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
                }
            },
            error: function (xhr, status, error) {
                $("#reset-password-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        });
    }
}