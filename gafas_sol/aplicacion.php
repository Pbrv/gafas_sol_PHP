<?php
    //INICIO DE SESION
    session_start();
    if (!isset($_SESSION["user"])) {
        header("location:login.php");
    } else {
        $user = $_SESSION["user"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/listado.css">
    <title>APLICACION</title>
</head>
<body>
    <div class="cuerpo">
    <nav class="nav">
        
        <?php 
        $dat = dameRol($user);
        $rol = $dat['rol'];
        echo "BIENVENID@ " . $user . ". Usuario con rol " . $rol ?>
        <!-- CERRAR SESION -->
        <div ><a href="cerrarSesion.php" class="cerrar">Cerrar Sesión</a></div>
    </nav>

    <!-- Controlamos que el formulario solo aparezca si se ha conectado un usuario administrador -->
    <?php
    if ($rol == 'admin') {
        ?>
        <div class="formulario">
        <h2>Formulario de inserción de datos</h2>
        <!-- importante enctype cuando tratamos imagenes en el servidor -->
        <form action="" method="post" id="formulario" enctype="multipart/form-data" onsubmit="return validacionFormulario()">
            <div><label>Modelo: </label><input type="text" name="modelo" id="modelo"></div>
            <div><label>Precio: </label><input type="text" name="precio" id="precio"></div>
            <div><label>Stock: </label><input type="text" name="stock" id="stock"></div>
            <div><label>Imagen: </label><input type="file" name="imagen" id="imagen"></div>
            <!-- $_FILES["imagen"] imagen -->
            <!-- $_FILES["archivo"] archivo -->
            <input type="submit" name="enviar" value="Introduce los datos" id="submit">
        </form>
    </div> <?php } ?>

        <!-- Previsualización de la imagen al cargarla -->
    <div id="fotografia"> <img id="foto" width="250px"></div>
    <div class="tabla">
    <?php 
    // al enviar los datos en el formulario
    if (isset($_POST['enviar'])){
            insertar($_POST);
    }

    $gafas = datos();
    if (count($gafas) == 0) {
        echo "NO HAY DATOS EN LA TABLA PARA MOSTRAR";
    } 
    if (count($gafas) > 0) {
        // TABLA DE DATOS
    ?>
        <table>
        <th colspan="9" class="titulo"><h2>Gafas de Sol</h2></th>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Precio</th>
                <th colspan="3">Imagen</th>
                <th>Imagen Blob</th>
            </tr>
            <?php
                //sacar datos en la tabla
                foreach ($gafas as $gafa) {
                    echo "<tr> <td>" . $gafa['id'] . "</td><td>" . $gafa['modelo'] . "</td><td>" . $gafa['precio'] . "</td><td>" .  "</td>";
                    
                    //MOSTRAR IMAGEN
                    echo "<td> <img src=' " . $gafa['imagen'] . " ' width=120px > </td>";
                    echo "<td> <a href=' ". $gafa['imagen'] . " ' target='_blank' >Ver imagen</a> </td>";
                    echo "<td> <img src='data:image/jpeg;base64, " . base64_encode($gafa['imagen_blob']) . " ' width=120px > </td>";
                    //Enlace para llevarnos a la página de detalle
                    echo "<td> <a href='gafa/" . $gafa['id'] . "'>Ver producto</a> </td> </tr>";
                }
            ?>
        </table>
    <?php } ?>
    </div>
    </div>

    <!-- VALIDACIÓN JAVASCRIPT -->
        <script src="validacionForm.js"></script>
    </body>
</html>

<?php
    function datos() {
        //conectamos a la BBDD
        include_once "conexionBBDD.php";

        $BBDD = new ConexionBD(); //clase de la página conexionBBDD.php
        $conexion = $BBDD->getConexion();

        $consulta = 'SELECT * FROM productos';
        $datos = $conexion->prepare($consulta);
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        $datos->execute();
        $resultado = $datos->fetchAll();

        $BBDD->cerrarConexion();

        return $resultado;
    }

    function dameRol($user) {
        //conectamos a la BBDD de usuarios para obtener el rol
        include_once 'conexionBBDD.php';

        $BBDD = new ConexionBD();
        $conexion = $BBDD->getConexion();
        $consulta = 'SELECT rol FROM usuarios WHERE USER = :user';
        $datos = $conexion->prepare($consulta);
        $datos->execute(array (':user' => $user));
        $resultado = $datos->fetch(PDO::FETCH_ASSOC);
        // $datos->bindValue(":rol", $rol);
        
        $BBDD->cerrarConexion();
        return $resultado;
    }

    function insertar($datos_nuevos) {
        //$datos_nuevos = $_POST

        //Conexion a BBDD
        include_once 'conexionBBDD.php';
        $BBDD = new ConexionBD();
        $conexion = $BBDD->getConexion();

        //variables de imagen para insertar
        $imagen = "gafas/" . $_FILES['imagen']['name']; //src de la imagen al mostrar
        $imagen_blob = file_get_contents($_FILES['imagen']['tmp_name']); //coge el binario

        //IMP - Lleva la imagen a la carpeta de la aplicación
        move_uploaded_file($_FILES['imagen']['tmp_name'], $imagen);

        $insert = "INSERT INTO productos (modelo, precio, stock, imagen, imagen_blob) 
                            VALUES (:modelo, :precio, :stock, :imagen, :imagen_blob)";
        $datos = $conexion->prepare($insert);

        try {
            $datos->execute(array(  ":modelo" => $datos_nuevos['modelo'], 
                                    ":precio" => $datos_nuevos['precio'], 
                                    ":stock" => $datos_nuevos['stock'], 
                                    ":imagen" => $imagen,
                                    ":imagen_blob" => $imagen_blob));
        } catch (PDOException $e) {
            die("Error! " . $e->getMessage());
        }
        $BBDD->cerrarConexion();
    }
?>