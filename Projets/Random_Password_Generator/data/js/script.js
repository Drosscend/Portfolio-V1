var alerbox = document.querySelector(".alerbox");

function getPassword() {
    var chars =
        "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN!@#$%^&*()_+?><:{}[]-.";
    var passwordLength = 16;
    var password = "";

    for (var i = 0; i < passwordLength; i++) {
        var randomNumber = Math.floor(Math.random() * chars.length);
        password += chars.substring(randomNumber, randomNumber + 1);
    }
    document.getElementById("password").value = password;
}

function copyPassword() {
    var copyPassText = document.getElementById("password");
    copyPassText.select();
    copyPassText.setSelectionRange(0, 9999);
    document.execCommand("copy");
}
