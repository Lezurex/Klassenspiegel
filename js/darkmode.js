var isFirefox = typeof InstallTrigger !== 'undefined';

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
        setCookie("darkmode", "true", 365);
        toggleDarkMode();
    } else {
        setCookie("darkmode", "false", 365);
        toggleDarkMode();
    }

    if (isFirefox) {
        if (getCookie("darkmode") === "false")
            document.querySelector("body").style.backgroundColor = "inherit";
        else
            document.querySelector("body").style.backgroundColor = "black";
    }
}

function toggleDarkMode() {
    document.documentElement.classList.toggle('dark-mode');

    document.querySelectorAll('.inverted, .note-color-btn').forEach((result) => {
        result.classList.toggle('invert');
    });

    if (isFirefox) {
        if (getCookie("darkmode") === "false")
            document.querySelector("body").style.backgroundColor = "inherit";
        else
            document.querySelector("body").style.backgroundColor = "black";
    }
}