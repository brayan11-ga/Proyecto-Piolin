<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

$cliente_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] : null;
$carrito = $_SESSION['carrito'] ?? [];

if (!$cliente_id) {
    die("No hay cliente identificado en sesión.");
}

if (empty($carrito)) {
    echo "El carrito está vacío.";
    exit;
}

$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$correo = $_POST['correo'] ?? '';
$metodoPago = $_POST['metodoPago'] ?? '';
$comentarios = $_POST['comentarios'] ?? '';
$direccion = $_POST['direccion'] ?? '';
$fecha = date("Y-m-d");
$estado = "Pendiente";

mysqli_begin_transaction($conexion);

try {
    // 1) Insertar venta
    $sqlVenta = "INSERT INTO venta (fechaVenta, metodoPago, estado, comentarios, direccionEnvio, FK_IdentificacionCliente) 
                 VALUES (?, ?, ?, ?, ?, ?)";
    $stmtVenta = mysqli_prepare($conexion, $sqlVenta);
    if (!$stmtVenta) throw new Exception("Prepare venta: " . mysqli_error($conexion));

    // Tipos: s=string, i=int. Aquí: fecha s, metodoPago s, estado s, comentarios s, direccion s, cliente_id i
    mysqli_stmt_bind_param($stmtVenta, "ssssis", $fecha, $metodoPago, $estado, $comentarios, $direccion, $cliente_id);
    if (!mysqli_stmt_execute($stmtVenta)) {
        throw new Exception("Execute venta: " . mysqli_stmt_error($stmtVenta));
    }
    $numeroFactura = mysqli_insert_id($conexion);
    mysqli_stmt_close($stmtVenta);

    // 2) Preparar statement para detalle de productos
    $sqlDetalle = "INSERT INTO producto_venta (FK_NumeroFactura, FK_CodigoBarras, cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = mysqli_prepare($conexion, $sqlDetalle);
    if (!$stmtDetalle) throw new Exception("Prepare detalle: " . mysqli_error($conexion));

    // 3) Preparar statement para actualizar stock (una vez)
    $sqlStock = "UPDATE producto SET stock = stock - ? WHERE codigoBarras = ?";
    $stmtStock = mysqli_prepare($conexion, $sqlStock);
    if (!$stmtStock) throw new Exception("Prepare stock: " . mysqli_error($conexion));

    // Recorremos carrito
    foreach ($carrito as $codigo => $item) {
        // Asegura tipos correctos
        $cantidad = (int)($item['cantidad'] ?? 0);
        // Si los códigos de barras contienen letras, usa 's' en lugar de 'i'. Aquí asumo que son enteros:
        $codigo_barras = (int)$codigo;

        // insertar en producto_venta: (numeroFactura int, codigoBarras int, cantidad int)
        mysqli_stmt_bind_param($stmtDetalle, "iii", $numeroFactura, $codigo_barras, $cantidad);
        if (!mysqli_stmt_execute($stmtDetalle)) {
            throw new Exception("Execute detalle: " . mysqli_stmt_error($stmtDetalle));
        }

        // actualizar stock: stock = stock - cantidad WHERE codigoBarras = ?
        mysqli_stmt_bind_param($stmtStock, "ii", $cantidad, $codigo_barras);
        if (!mysqli_stmt_execute($stmtStock)) {
            throw new Exception("Execute stock: " . mysqli_stmt_error($stmtStock));
        }
    }

    // cerrar statements
    mysqli_stmt_close($stmtDetalle);
    mysqli_stmt_close($stmtStock);

    // 4) Vaciar carrito y confirmar transacción
    unset($_SESSION['carrito']);
    mysqli_commit($conexion);

} catch (Exception $e) {
    mysqli_rollback($conexion);
    // muestra error (en producción mejor registrar en log y mostrar mensaje genérico)
    die("Error al finalizar compra: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../img/img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="finalizarpago.css">
    <title>Finalizar compra</title>
</head>
<body>
    <div id="animation-overlay">
      <div class="overlay-content">
        <h2 class="mensaje">PRODUCTO EN CAMINO...</h2>
        <img src="../img/animaciónpiolin.png" alt="Piolin" class="piolin">
      </div>
    </div>

    <script>
    window.addEventListener("load", function() {
      const overlay = document.getElementById("animation-overlay");
      // Mostrar overlay al cargar
      overlay.classList.remove("hidden");

      // Ocultar y redirigir después de 5s
      setTimeout(() => {
        overlay.classList.add("hidden");
        window.location.href = "productos.php";
      }, 5000);
    });
    </script>
</body>
</html>
