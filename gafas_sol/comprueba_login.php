<?php
    try {
        include_once 'conexionBBDD.php';
        //conectamos a base de datos
        $BBDD = new ConexionBD();
        $conexion = $BBDD->getConexion();
        $consulta = 'SELECT * FROM usuarios WHERE USER=:user AND PASSWORD=:password';
        $datos = $conexion->prepare($consulta);

        //rescatamos en variables los datos que el usuario introduce en el form
        $user = htmlentities(addslashes($_POST["user"]));
        $password = htmlentities(addslashes($_POST["password"]));
        //addlashes escapa cualquier símbolo que el usuario haya introducido en el login
        //htmlentities convierte cualquier símbolo en html

        $datos->bindValue(":user", $user);
        $datos->bindValue(":password", $password);

        $datos->execute();

        $numero_registro = $datos->rowCount();
        if ($numero_registro != 0) { //si el user existe
            //crea una sesion para ese usuario
            session_start();
            //almacenamos dentro de la variable global $_SESSION el login del usuario
            $_SESSION["user"] = $_POST["user"];

            header("location:aplicacion.php");
        } else {
            //si user y password incorrectos nos redirige al sistema de login
            header("location:login.php");
        }
    } catch (PDOException $e) {
        die("Error! " . $e->getMessage());
    }
?>