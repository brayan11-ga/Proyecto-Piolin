<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$baseDatos = "proyecto_ventas"; // aquí va el nombre de tu base de datos

$conexion = new mysqli($servidor, $usuario, $clave, $baseDatos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
