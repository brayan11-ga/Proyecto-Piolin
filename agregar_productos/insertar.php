<?php
session_start();
require_once '../config/conexion.php';

// Sanitizar datos para evitar inyecciones SQL simples
$codigobarras = mysqli_real_escape_string($conexion, $_POST['codigobarras']);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
$categoria = mysqli_real_escape_string($conexion, $_POST['categoria']);
$precio = (float) $_POST['precio'];
$stock = (int) $_POST['stock'];
$descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);

$imagen = $_FILES['imagen']['name'];
$tmp_name = $_FILES['imagen']['tmp_name'];
$error = $_FILES['imagen']['error'];

$nombre_final = "default.png"; // Imagen por defecto si no se puede subir

// Reglas de validación para la carga de imágenes
if ($error === UPLOAD_ERR_OK && !empty($imagen)) {
    // Soportar múltiples formatos de forma estricta incluyendo WebP
    $extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    
    if (in_array($extension, $allowed_extensions)) {
        // Generar un nombre único para evitar que fotos con el mismo nombre se sobreescriban
        $nombre_final = uniqid("prod_") . "." . $extension;
        
        // El punto clave: mover al directorio principal de utilidades web
        $destino = "../assets/img/" . $nombre_final;
        move_uploaded_file($tmp_name, $destino);
    } else {
        die("❌ Formato de imagen no permitido. Solo se aceptan extensiones: JPG, PNG, GIF o WEBP.");
    }
}

// Inserción final garantizando que la imagen existe
$sql = "INSERT INTO producto (codigoBarras, nombre, categoria, precio, stock, descripcion, imagen) 
        VALUES ('$codigobarras','$nombre','$categoria','$precio','$stock','$descripcion','$nombre_final')";

if (mysqli_query($conexion, $sql)) {
    header('Location: ../gestion_productos/gestioproductos.php?verificar=insertar');
    exit();
} else {
    echo "Error crítico de base de datos: " . mysqli_error($conexion);
}
?>
