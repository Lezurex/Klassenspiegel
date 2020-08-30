$().ready(function () {
    $("#account-email").on("keyup", function (event) {
        if(validateEmail($(this).val())) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
        } else {
            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
        }
        emailSubmitChanger();

        if(event.code = 'Enter') {
            //changeEmail();
        }
    });

   $("#account-email-repeat").on("keyup", function (event) {
       if(validateEmail($(this).val())) {
           $(this).removeClass("is-invalid");
           $(this).addClass("is-valid");
       } else {
           $(this).removeClass("is-valid");
           $(this).addClass("is-invalid");
       }
       emailSubmitChanger();

       if(event.code = 'Enter') {
           //changeEmail();
       }
   });
});

function emailSubmitChanger() {
    if(validateEmail($("#account-email").val()) && validateEmail($("#account-email-repeat").val())) {
        if($("#account-email").val() == $("#account-email-repeat").val()) {
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
    let queryData = {
        'email':$("#account-email").val(),
    };
    $.ajax({
        method:"POST",
        url:"https://" + window.location.hostname + "/php/changeEmail.php",
        data: queryData,
        timeout:5000,
        success: function (data) {
            if(data == "902") {
                $("#account-email-error").html("Du benutzt schon diese E-Mail.");
            } else if(data == "200") {
                $("#account-email-success").html("Eine Bestätigungsmail von <strong>klasseap20b@gmail.com</strong> wurde an die Adresse <strong>" + queryData.email + "</strong> gesendet. Schau eventuell auch im Spam-Ordner nach.");
            } else {
                $("#account-email-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#account-email-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}

function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}