<?php

$codigobarras = $_POST['codigobarras'];
$nombre = $_POST['nombre'];
$categoria = $_POST['categoria'];
$precio = $_POST['precio'];
$stock = $_POST['stock'];
$descripcion = $_POST['descripcion'];
$imagen = $_FILES['imagen']['name'];


move_uploaded_file($_FILES['imagen']['tmp_name'], "img/" . $imagen);


$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombre_base_de_datos = "proyecto_ventas";

// Crear la conexión
$conexion = mysqli_connect($host, $usuario, $contrasena, $nombre_base_de_datos);


// Consulta SQL para insertar datos
$sql = "INSERT INTO producto (codigoBarras, nombre, categoria, precio, stock, descripcion, imagen) 
        VALUES ('$codigobarras','$nombre','$categoria','$precio','$stock','$descripcion','$imagen')";


header('Location: ../gestion_productos/gestioproductos.php?verificar=insertar');

if (mysqli_query($conexion, $sql)) {
    echo "Producto guardado con exito";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
}




?>