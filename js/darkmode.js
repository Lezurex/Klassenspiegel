$(document).ready(function () {
    if (getCookie("darkmode") !== "") {
        if (getCookie("darkmode") === "true") {
            toggleDarkMode();
            $("#switch-darkmode").attr("checked", "checked");
        }
    } else {
        setCookie("darkmode", "false", 365);
    }
})

function toggleDarkModeOnClick() {
    if (document.getElementById("switch-darkmode").checked) {
        toggleDarkMode();
        setCookie("darkmode", "true", 365);
    } else {
        toggleDarkMode();
        setCookie("darkmode", "false", 365);
    }
}

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark-mode');
    document.querySelectorAll('.inverted').forEach((result) => {
        result.classList.toggle('invert');
    });
}