<?php
session_start();
require_once '../config/conexion.php';

// Validar credenciales y seguridad
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: ../index.php");
    exit();
}

if (isset($_GET['codigoBarras'])) {
    $id = intval($_GET['codigoBarras']); 

    $sql = "DELETE FROM producto WHERE codigoBarras = $id";

    try {
        if (mysqli_query($conexion, $sql)) {
            // Se eliminó un producto que nunca se había vendido o no tiene dependencias
            header("Location: gestioproductos.php?mensaje=Producto eliminado permanentemente del catálogo.");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        $error_code = $e->getCode();
        
        // Código 1451: Restricción de Llave Foránea de MySQL. 
        // Significa que este producto ya fue comprado y la factura en producto_venta lo necesita.
        if ($error_code == 1451) {
            $mensajeError = "No puedes eliminar este producto porque ya ha sido comprado en facturas pasadas. Borrarlo destruiría el historial de compras de tus clientes. Como alternativa, edítalo y pon su Stock en 0.";
        } else {
            $mensajeError = "Ocurrió un error inesperado al intentar borrar desde la base de datos (Código: $error_code).";
        }
        
        // Devolver a la vista de gestor con el error empacado
        header("Location: gestioproductos.php?error=" . urlencode($mensajeError));
        exit();
    }
} else {
    header("Location: gestioproductos.php");
    exit();
}
?>
