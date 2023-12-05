<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/login.css">
    <title>LOGIN</title>
</head>
<body>
    <div class="formulario">
        <h1>Inicio de sesión</h1>
        <form action="comprueba_login.php" method="post" onsubmit="return validacionLogin()">
            <div class="user">
                <label for="">Usuario:</label>
                <input type="text" name="user" id="user">
            </div>

            <div class="password">
                <label for="">Contraseña:</label>
                <input type="password" name="password" id="password">
            </div>
            <!-- Botón Envío -->
            <input class="login" type="submit" name="enviar" value="Iniciar Sesión">
        </form>
    </div>
    <script src="validacionLogin.js"></script>
</body>
</html>