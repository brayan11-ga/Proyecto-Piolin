<?php
if (isset($_POST['guardar'])) {
    $conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
    


    if (!$conexion) {
        die("❌ Error de conexión: " . mysqli_connect_error());
    }


    $codigo = $_POST['codigobarras'];  
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $descripcion = $_POST['descripcion'];
    $imagen = $_FILES['imagen']['name'];

 

    if ($_FILES['imagen']['name'] == ""){
    $sql ="UPDATE producto SET nombre = '$nombre', categoria = '$categoria', precio = '$precio', stock = '$stock', descripcion = '$descripcion' WHERE codigoBarras = '$codigo'";
    }

    else{
        move_uploaded_file($_FILES['imagen']['tmp_name'], "../agregar productos/img/" . $imagen);
        $sql= "UPDATE producto SET nombre ='$nombre', categoria ='$categoria', precio ='$precio', stock= '$stock', descripcion= '$descripcion', imagen='$imagen' WHERE codigoBarras='$codigo'"; 
    }

    


            

    if (mysqli_query($conexion, $sql)) {
        header("Location: gestioproductos.php?mensaje=Producto actualizado correctamente");
        exit();
    } else {
        echo "❌ Error al actualizar: " . mysqli_error($conexion);
    }
}
?>

