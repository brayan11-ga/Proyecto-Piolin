<?php
session_start();
require_once '../config/conexion.php';
$cliente_id = isset($_SESSION['id']) ? (int)$_SESSION['id'] : null;
$carrito = $_SESSION['carrito'] ?? [];

if (!$cliente_id) {
    die("No hay cliente identificado en sesión.");
}

if (empty($carrito)) {
    header('Location: productos.php');
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

    // 3) Preparar statement para actualizar stock
    $sqlStock = "UPDATE producto SET stock = stock - ? WHERE codigoBarras = ?";
    $stmtStock = mysqli_prepare($conexion, $sqlStock);
    if (!$stmtStock) throw new Exception("Prepare stock: " . mysqli_error($conexion));

    // Recorremos carrito
    foreach ($carrito as $codigo => $item) {
        $cantidad = (int)($item['cantidad'] ?? 0);
        $codigo_barras = (string)$codigo; // casteado a string para códigos de barras largos

        mysqli_stmt_bind_param($stmtDetalle, "isi", $numeroFactura, $codigo_barras, $cantidad);
        if (!mysqli_stmt_execute($stmtDetalle)) {
            throw new Exception("Execute detalle: " . mysqli_stmt_error($stmtDetalle));
        }

        mysqli_stmt_bind_param($stmtStock, "is", $cantidad, $codigo_barras);
        if (!mysqli_stmt_execute($stmtStock)) {
            throw new Exception("Execute stock: " . mysqli_stmt_error($stmtStock));
        }
    }

    mysqli_stmt_close($stmtDetalle);
    mysqli_stmt_close($stmtStock);

    // 4) Vaciar carrito y confirmar transacción
    unset($_SESSION['carrito']);
    mysqli_commit($conexion);

} catch (Exception $e) {
    mysqli_rollback($conexion);
    die("Error al finalizar compra: " . $e->getMessage());
}

$page_title = '¡Compra Exitosa! - Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5 text-center" style="min-height: 70vh; display: flex; flex-direction: column; justify-content: center; align-items: center;">
    
    <!-- Animación Pantalla Completa Piolín -->
    <div id="piolin-animation-overlay" style="position: fixed; inset: 0; z-index: 9999; background-color: var(--primary); display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.8s ease, visibility 0.8s ease;">
        <h1 class="text-white display-3 fw-bold mb-5" style="font-family: 'Montserrat', sans-serif;">PEDIDO EN CAMINO...</h1>
        <img src="../assets/img/animaciónpiolin.png" alt="Piolin en camino" style="max-width: 400px; width: 80%; animation: bounce 2s infinite ease-in-out;">
        <style>
            @keyframes bounce { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-30px); } }
        </style>
    </div>

    <!-- Script de desvanecimiento -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(function() {
                var overlay = document.getElementById("piolin-animation-overlay");
                overlay.style.opacity = "0";
                overlay.style.visibility = "hidden";
            }, 3500); // Aparece por 3.5 segundos exactos
        });
    </script>
    
    <div id="success-animation" class="mb-4 mt-5">
        <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 120px; height: 120px; margin: 0 auto; animation: scaleIn 0.5s ease-out;">
            <i class="bi bi-check-lg text-white" style="font-size: 5rem;"></i>
        </div>
    </div>

    <h1 class="display-5 fw-bold text-dark mt-3 mb-3" style="font-family: 'Montserrat', sans-serif;">¡Pedido Confirmado!</h1>
    <p class="lead text-muted mb-4 max-w-75">Tu compra (Factura #<?= $numeroFactura ?>) ha sido procesada con éxito. Ya estamos preparando tus productos para despacharlos a la dirección proporcionada.</p>
    
    <div class="card bg-light border-0 shadow-sm rounded-4 p-4 mb-5 max-w-50" style="max-width: 500px; width: 100%;">
        <div class="d-flex justify-content-between mb-2">
            <span class="text-secondary fw-bold">Número de Orden:</span>
            <span class="text-dark">#<?= str_pad($numeroFactura, 6, "0", STR_PAD_LEFT) ?></span>
        </div>
        <div class="d-flex justify-content-between mb-2">
            <span class="text-secondary fw-bold">Método de Pago:</span>
            <span class="text-dark"><?= htmlspecialchars($metodoPago) ?></span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="text-secondary fw-bold">Estado:</span>
            <span class="badge bg-warning text-dark text-uppercase"><?= $estado ?></span>
        </div>
    </div>

    <div>
        <a href="mis_compras.php" class="btn btn-outline-primary rounded-pill px-4 py-3 fw-bold me-2">Ver Mis Compras</a>
        <a href="productos.php" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">Seguir Comprando</a>
    </div>

    <style>
        @keyframes scaleIn {
            0% { transform: scale(0); opacity: 0; }
            80% { transform: scale(1.1); opacity: 1; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</main>

<script>
    // Confeti simple opcional (si tuvieras librería, pero se ve excelente así nativo)
</script>

<?php require_once '../includes/footer.php'; ?>
