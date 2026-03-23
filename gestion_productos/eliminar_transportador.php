<?php
require_once '../config/conexion.php';
if (isset($_GET['idTransportador'])) {
    $id = intval($_GET['idTransportador']);

    $sql = "DELETE FROM transportador WHERE idTransportador = $id";
    if (mysqli_query($conexion, $sql)) {
        header("Location: gestionar_transportadores.php?mensaje=Conductor eliminado con éxito");
        exit;
    } else {
        echo "Error al eliminar: " . mysqli_error($conexion);
    }
} else {
    echo "ID inválido.";
}

mysqli_close($conexion);
?>






