<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio 1</title>
    <link rel="stylesheet" href="Ejercicio1.css">
</head>
<body>
    <h2>Gafas de Sol</h2>
    <?php 
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
</body>
</html>

<?php
    function datos() {
        include_once 'conexionBBDD.php';

        $BBDD = new ConexionBD(); //clase de la página conexionBBDD.php
        $conexion = $BBDD->getConexion();

        //consulta de lo que queremos que nos saque en la tabla
        //VIDEO 53
        //nuestra variable $datos es la PDO Statement
        $consulta = 'SELECT * FROM productos';
        $datos = $conexion->prepare($consulta);
        $datos->setFetchMode(PDO::FETCH_ASSOC);
        $datos->execute();
        $resultado = $datos->fetchAll();

        $BBDD->cerrarConexion();

        return $resultado;
    }
?>