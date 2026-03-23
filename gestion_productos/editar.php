<?php
session_start();

if (isset($_POST['guardar'])) {
    require_once '../config/conexion.php';
    
    // Sanitizar datos texturizados
    $codigo = mysqli_real_escape_string($conexion, trim($_POST['codigobarras']));  
    $nombre = mysqli_real_escape_string($conexion, trim($_POST['nombre']));
    $categoria = mysqli_real_escape_string($conexion, trim($_POST['categoria']));
    $precio = (float) $_POST['precio'];
    $stock = (int) $_POST['stock'];
    $descripcion = mysqli_real_escape_string($conexion, trim($_POST['descripcion']));
    
    $imagen = $_FILES['imagen']['name'];
    $tmp_name = $_FILES['imagen']['tmp_name'];
    $error = $_FILES['imagen']['error'];

    // Si el usuario NO subió archivo, preservamos el nombre que ya existía en DB
    if (empty($imagen) || $error !== UPLOAD_ERR_OK) {
        $sql = "UPDATE producto 
                SET nombre = '$nombre', categoria = '$categoria', precio = '$precio', 
                    stock = '$stock', descripcion = '$descripcion' 
                WHERE codigoBarras = '$codigo'";
    } else {
        // Si subió un archivo, lo movemos EN FORMA a assets/img/ 
        $extension = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        
        if (in_array($extension, $allowed_extensions)) {
            $nombre_final = uniqid("prod_") . "." . $extension;
            $destino = "../assets/img/" . $nombre_final;
            move_uploaded_file($tmp_name, $destino);
            
            $sql = "UPDATE producto 
                    SET nombre = '$nombre', categoria = '$categoria', precio = '$precio', 
                        stock = '$stock', descripcion = '$descripcion', imagen = '$nombre_final' 
                    WHERE codigoBarras = '$codigo'";
        } else {
            die("❌ Formato de imagen inválido. Intenta de nuevo con JPG, PNG, GIF o WEBP.");
        }
    }

    if (mysqli_query($conexion, $sql)) {
        header("Location: gestioproductos.php?mensaje=Producto actualizado correctamente");
        exit();
    } else {
        echo "❌ Error al modificar producto: " . mysqli_error($conexion);
    }
}
?>
