<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombre_base_de_datos = "proyecto_ventas";

// Crear la conexión
$conexion = mysqli_connect($host, $usuario, $contrasena, $nombre_base_de_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['codigoBarras'])) {
    $id = intval($_GET['codigoBarras']); 

    $sql = "DELETE FROM producto WHERE codigoBarras = $id";

    if (mysqli_query($conexion, $sql)) {
        // Redirigir de nuevo a la página principal
        header("Location: gestioproductos.php?mensaje=Producto eliminado correctamente");
        exit();
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
}

?>
