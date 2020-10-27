$("#login-btn-reset").on("click", function (e) {
    e.preventDefault();
    $("#modal-login").modal("hide");
    $("#modal-reset").modal("show");
});

$("#reset-reset-btn").on("click", function () {
    reset();
});

$("#reset-email").on("keyup", function (e) {
    if (e.keyCode === 13)
        reset();
});

function reset() {
    if (validateEmail($("#reset-email").val())) {
        $("#reset-email").removeClass("is-invalid");
        $("#reset-error").text("");
        $("#reset-content1").css("display", "none");
        $("#reset-content2").css("display", "inherit");
        $("#reset2-strong-mail").text($("#reset-email").val());
    } else {
        $("#reset-email").addClass("is-invalid");
        $("#reset-error").text("Dies ist keine gültige E-Mail!");
    }
}