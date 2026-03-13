<?php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['idTransportador'])) {
    $id = intval($_GET['idTransportador']);

    $sql = "DELETE FROM transportador WHERE idTransportador = $id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: Gestionar_transportadores.php?mensaje=Conductor eliminado con éxito");
        exit;
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    echo "ID inválido.";
}

mysqli_close($conexion);
?>
