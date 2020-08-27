$().ready(function () {
    if (findGetParameter("error") != null) {
        var error = findGetParameter("error");
        switch (error) {
            case "901": //Invalid credentials
                $("#modal-login").modal("show");
                $("#login-email").addClass("is-invalid");
                $("#login-password").addClass("is-invalid");
                $("#login-error").html("Falsche E-Mail oder falsches Passwort!");
                break;
        }
    }
});

function findGetParameter(parameterName) {
    let result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
            tmp = item.split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}