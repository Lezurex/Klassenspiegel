$().ready(function () {
    /**
     * Removes error message when changed
     */
    $("#login-email").keydown(function () {
        $("#login-email").removeClass("is-invalid");
        $("#login-error").html("");
    });
    $("#login-password").keydown(function () {
        $("#login-password").removeClass("is-invalid");
        $("#login-error").html("");
    });

    $("#login-email").keyup(function () {
        let email = $("#login-email").val();
        if(validateEmail(email)) {
            $("#login-email").removeClass("is-invalid");
            $("#login-email").addClass("is-valid");
        } else {
            $("#login-email").removeClass("is-valid");
            $("#login-email").addClass("is-invalid");
        }
    })
});

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}