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
    })
})