//Navbar
function navbar() {
    var x = document.getElementById("Topnav");

    if (x.className === "topnav") {
        x.className += " responsive";
    } else {
        x.className = "topnav";
    }
}

//Cookies
let cookiesBanner = document.querySelector(".cookies");

if (getCookie("allowCookies") !== "true") {
    cookiesBanner.style.display = "flex";
    cookiesBanner.querySelector(".button").addEventListener("click", () => {
        setCookie("allowCookies", "true", 365);
        cookiesBanner.style.display = "none";
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(";");
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == " ") {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return null;
}

//background animate.js
function animateBlocks() {
    anime({
        targets: ".blocks",
        translateX: function () {
            return anime.random(-700, 700);
        },
        translateY: function () {
            return anime.random(-500, 500);
        },
        scale: function () {
            return anime.random(1, 5);
        },
        duration: 3000,
        delay: anime.stagger(5),
    });
}

if (window.matchMedia("(min-width: 734px)").matches) {
    const container = document.querySelector(".section-Accueil");
    for (var i = 0; i <= 5; i++) {
        const blocks = document.createElement("div");
        blocks.classList.add("blocks");
        container.appendChild(blocks);
    }
    animateBlocks();
}
