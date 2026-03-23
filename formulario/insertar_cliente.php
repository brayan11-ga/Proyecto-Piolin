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
$numeroIdentificacion = $_POST['numero'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$contraseña = $_POST['contraseña'];

// Consulta SQL para insertar datos
$sql = "INSERT INTO cliente (numeroIdentificacion, nombres, apellidos, telefono, correo, `contraseña` ) 
        VALUES ('$numeroIdentificacion', '$nombres', '$apellidos', '$telefono', '$correo', '$contraseña' )";


if (mysqli_query($conexion, $sql)) {
    echo "Nuevo registro creado con éxito";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}

// Cerrar la conexión
mysqli_close($conexion);

header('Location: ../ingresar/ingresar.php?verificar=formulario');
?>





