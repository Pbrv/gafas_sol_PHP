<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 4 Validación Javascript</title>
</head>
<body>
    <h2>Formulario de inserción </h2>
        <form action="" method="post" id="formulario" onsubmit="return validacionFormulario()">
            Id: <input type="text" name="id" id="id"><br>
            Modelo: <input type="text" name="modelo" id="modelo"><br>
            Precio: <input type="text" name="precio" id="precio"><br>
            Stock: <input type="text" name="stock" id="stock"><br>
            Imagen: <input type="text" name="imagen" id="imagen"><br>
            <!-- Imagen_BLOB: <input type="text" name="imagen_blob" id="imagen_blob"> -->
            <input type="submit" name="enviar" value="Introduce datos">
        </form>

    <h2>Gafas de Sol</h2>
        <?php 
        if (isset($_POST['enviar'])){
            insertar($_POST);
        }

        $gafas = datos();
        if (count($gafas) > 0) {
        ?>
            <table>
                <tr>
                    <th>id</th>
                    <th>modelo</th>
                    <th>precio</th>
                    <th>stock</th>
                    <th>imagen</th>
                    <!-- <th>imagen_blob</th> -->
                </tr>
                <?php
                    //sacar datos en la tabla
                    foreach ($gafas as $gafa) {
                        echo "<tr>" . "<td>" . $gafa['id'] . "</td><td>" . $gafa['modelo'] . "</td><td>" . $gafa['precio'] . "</td><td>" . $gafa['stock'] . "</td><td>" . $gafa['imagen'] . "</td><td>" /*. $gafa['imagen_blob']*/ . "</tr>";
                    }
                ?>
            </table>
    <?php
                echo "Número de filas: " . count($gafas);
            } else {
                echo "NO HAY DATOS PARA MOSTRAR";
            }
    ?>
    <!-- CERRAR SESION  -->
    <a href="cerrarSesion.php">Cerrar Sesión</a>
    <!-- VALIDACIÓN JAVASCRIPT -->
    <script type="text/javascript" src="validacionForm.js"></script>
</body>
</html>

<?php
    //conexcion igual que el Ejercicio1.php
    function datos() {
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

    function insertar($datos_nuevos) {
        include_once 'conexionBBDD.php';

        $BBDD = new ConexionBD();
        $conexion = $BBDD->getConexion();

        $insert = "INSERT INTO productos (id, modelo, precio, stock, imagen)" . "VALUES (:id, :modelo, :precio, :stock, :imagen)";
        $datos = $conexion->prepare($insert);

        try {
            $datos->execute(array( ":id" => $datos_nuevos['id'],
                                    ":modelo" => $datos_nuevos['modelo'], 
                                    ":precio" => $datos_nuevos['precio'], 
                                    ":stock" => $datos_nuevos['stock'], 
                                    ":imagen" => $datos_nuevos['imagen']));
        } catch (PDOException $e) {
            print "ERROR" . $e->getMessage();
            die();
        }
        $BBDD->cerrarConexion();
    }
?>