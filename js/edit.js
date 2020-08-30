$().ready(function () {
    $("#edit-phone").keyup(function () {
        let value = $(this).val();
        let regex = new RegExp("^([0][1-9][0-9](\\s|)[0-9][0-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9])$|^(([0][0]|\\+)[1-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9])$");
        if(regex.test(value)) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
        } else {
            if(value.length > 9) {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            } else {
                $(this).removeClass("is-valid");
                $(this).removeClass("is-invalid");
            }
        }
    });

    function edit() {
        let data = {
            'email':$("#register-email").val(),
            'password':$("#register-password").val()
        };
        $.ajax({
            method:"POST",
            url:"http://klassenspiegel.test/php/edit.php",
            data: data,
            timeout:5000,
            success: function (data) {
                if(data == "902") {
                    $("#register-http-error").html("Du bist schon registriert!");
                } else if(data == "200") {
                    //window.location.href = "/dashboard";
                } else {
                    $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
                }
            },
            error: function (xhr, status, error) {
                $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        });
    }
})