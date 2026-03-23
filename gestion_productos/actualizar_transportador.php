<?php
require_once '../config/conexion.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = intval($_POST['idTransportador']);
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $vehiculo = $_POST['vehiculo'];
    $placa = $_POST['placa'];
    $calificacion = $_POST['calificacion'];

    $sql = "UPDATE transportador 
            SET nombre='$nombre', telefono='$telefono', correo='$correo', 
                vehiculo='$vehiculo', placa='$placa', calificacion='$calificacion' 
            WHERE idTransportador=$id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: gestionar_transportadores.php?mensaje=Transportador actualizado con éxito");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>






