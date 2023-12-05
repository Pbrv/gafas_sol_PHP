function validacionLogin() {
    var user = document.getElementById("user").value;
    var password = document.getElementById("password").value;

    if (user == "") {
        alert("Debes introducir un nombre de usuario");
    }

    if (password == "") {
        alert("Debes introducir una contraseña");
    }
}