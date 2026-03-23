<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombre_base_de_datos = "proyecto_ventas";

// Crear la conexión
$conexion = mysqli_connect($host, $usuario, $contrasena, $nombre_base_de_datos);

// Verificar la conexión
if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Datos a insertar
$nombre   = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo   = $_POST['correo'];
$vehiculo = $_POST['vehiculo'];
$placa    = $_POST['placa'];
$calificacion = $_POST['calificacion'];

// Consulta SQL para insertar datos (sin idTransportador porque es AUTO_INCREMENT)
$sql = "INSERT INTO transportador (nombre, telefono, correo, vehiculo, placa, calificacion) 
        VALUES ('$nombre', '$telefono', '$correo', '$vehiculo', '$placa', '$calificacion')";

if (mysqli_query($conexion, $sql)) {
    echo "Nuevo registro creado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

mysqli_close($conexion);

header('Location: ../gestion_productos/gestionar_transportadores.php?verificar=formulario');
?>






