<?php
    session_start();

    if (!isset($_SESSION["user"])) {
        header("location:login.php");
    } else {
        $user = $_SESSION["user"];
    }

// hay que hacerlo con GET para que nos llegue el id por la URL
$id = $_GET['id'];

$dat = detalle($id);

function detalle($id) {
    //conectamos a la BBDD
    include_once "conexionBBDD.php";

    $BBDD = new ConexionBD(); //clase de la página conexionBBDD.php
    $conexion = $BBDD->getConexion();
    $consulta = 'SELECT * FROM productos WHERE id = :id';
    $datos = $conexion->prepare($consulta);
    $datos->execute(array (':id' => $id));
    $resultado = $datos->fetch(PDO::FETCH_ASSOC);

    $BBDD->cerrarConexion();
    return $resultado;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1<.0">
    <title>PÁGINA DE DETALLE</title>
    <link rel="stylesheet" href="../styles/listado.css">
</head>
<body>
    <div class="cuerpo">
    <nav class="nav">
        <?php echo "Conectado como: " . $user?>
        <!-- CERRAR SESION  -->
        <div><a href="cerrarSesion.php" class="cerrar">Cerrar Sesión</a></div>
    </nav>
    <div class="tabla">
        <table>
            <th colspan="2" class="titulo"><h2>Detalle del producto con id <?php echo $dat['id']?></h2></th>
            <tr><th>ID: <br></th>  <td><?php echo $dat['id']?> </td></tr>
            <tr><th>Modelo: <br></th>  <td><?php echo $dat['modelo']?> </td></tr>
            <tr><th>Precio: <br></th>  <td><?php echo $dat['precio']?> </td></tr>
            <tr><th>Stock: <br></th>  <td><?php echo $dat['stock']?> </td></tr>
            <tr>
                <th>Imagen: </th>
                <td> <img src="<?php echo "../" . $dat['imagen'] ?>" width="350px" height="auto"> </td>
            </tr>
        </table>
    </div>
    <div>
        <!-- hay que volver atras con ruta relativa para que salga de la url amigable -->
    <a href="../aplicacion.php" class="volver">Volver al Listado Completo de Gafas</a>
    </div>
    </div>

</body>
</html>