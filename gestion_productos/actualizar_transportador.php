<?php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

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
        header("Location: Gestionar_transportadores.php?mensaje=Transportador actualizado con éxito");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
}
?>
