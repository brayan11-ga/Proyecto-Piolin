<?php
session_start();

// Verificar login del cliente
if (!isset($_SESSION['cliente_id'])) {
    header("Location: ../ingresar/ingresar.php");
    exit;
}

// Conexión a la BD
require_once '../config/conexion.php';
$cliente_id = $_SESSION['cliente_id'];
$carrito = $_SESSION['carrito'] ?? [];

if (empty($carrito)) {
    echo "Tu carrito está vacío.";
    exit;
}

// 1. Crear venta (cabecera)
$metodoPago = "Efectivo"; // luego puedes cambiar a tarjeta, etc.
$estado = "Pendiente";
$fecha = date("Y-m-d");

$sqlVenta = "INSERT INTO venta (fechaVenta, metodoPago, estado, FK_IdentificacionCliente) 
             VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conexion, $sqlVenta);
mysqli_stmt_bind_param($stmt, "sssi", $fecha, $metodoPago, $estado, $cliente_id);
mysqli_stmt_execute($stmt);

$numeroFactura = mysqli_insert_id($conexion); // ID generado

// 2. Insertar detalle de la venta
$sqlDetalle = "INSERT INTO producto_venta (FK_NumeroFactura, FK_CodigoBarras, cantidad) 
               VALUES (?, ?, ?)";
$stmtDetalle = mysqli_prepare($conexion, $sqlDetalle);

foreach ($carrito as $codigo => $item) {
    $cantidad = (int)$item['cantidad'];

    mysqli_stmt_bind_param($stmtDetalle, "iii", $numeroFactura, $codigo, $cantidad);
    mysqli_stmt_execute($stmtDetalle);

    // 3. Actualizar stock
    $sqlStock = "UPDATE producto SET stock = stock - ? WHERE codigoBarras = ?";
    $stmtStock = mysqli_prepare($conexion, $sqlStock);
    mysqli_stmt_bind_param($stmtStock, "ii", $cantidad, $codigo);
    mysqli_stmt_execute($stmtStock);
}

// 4. Vaciar carrito de la sesión
unset($_SESSION['carrito']);

// 5. Confirmación al usuario
echo "<h2>Â¡Gracias por tu compra!</h2>";
echo "<p>Tu número de factura es <strong>$numeroFactura</strong></p>";
echo "<a href='../index.php'>Volver al inicio</a>";

mysqli_close($conexion);
?>




