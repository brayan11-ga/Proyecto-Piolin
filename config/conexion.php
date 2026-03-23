<?php
$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombre_base_de_datos = "proyecto_ventas";

$conexion = mysqli_connect($host, $usuario, $contrasena, $nombre_base_de_datos);
mysqli_set_charset($conexion, "utf8mb4");

if (!$conexion) {
    die("Conexión fallida: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8");
?>




