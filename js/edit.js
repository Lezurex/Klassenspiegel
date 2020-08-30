$().ready(function () {
    $("#edit-phone").on("keyup", function () {
        let value = $(this).val();
        let regex = new RegExp("^([0][1-9][0-9](\\s|)[0-9][0-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9])$|^(([0][0]|\\+)[1-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9][0-9](\\s|)[0-9][0-9](\\s|)[0-9][0-9])$");
        if(regex.test(value)) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
            $("#edit-phone-error").html("");
        } else {
            if(value.length > 9) {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
                $("#edit-phone-error").html("Diese Telefonnummer ist ungültig.");
            } else {
                $(this).removeClass("is-valid");
                $(this).removeClass("is-invalid");
                $("#edit-phone-error").html("");
            }
        }
    });

    $(".edit-input").each(function () {
        $(this).on("keydown", function (event) {
            if(event.code == "Enter") {
                edit();
            }
        });
    });

    $("#btn-edit-save").on("click", function () {
        edit();
    });
});

function edit() {
    let data = {
        'firstname':$("#edit-firstname").val(),
        'lastname':$("#edit-lastname").val(),
        'location':$("#edit-location").val(),
        'phone':$("#edit-phone").val(),
        'company':$("#edit-company").val(),
        'hobbys':$("#edit-hobbys").val()
    };
    $.ajax({
        method:"POST",
        url:"https://" + window.location.hostname + "/php/edit.php",
        data: data,
        timeout:5000,
        success: function (data) {
            if(data == "904") {
                $("#edit-phone-error").html("Diese Telefonnummer ist ungültig!");
            } else if(data == "200") {
                $("#edit-status").removeClass("text-warning");
                $("#edit-status").addClass("text-success");
                $("#edit-status").html("Deine Angaben wurden erfolgreich übernommen!");
            } else {
                $("#edit-status").removeClass("text-success");
                $("#edit-status").addClass("text-warning");
                $("#edit-status").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
            }
        },
        error: function (xhr, status, error) {
            $("#register-http-error").html("Es ist ein Fehler aufgetreten. Versuche es später noch einmal.");
        }
    });
}