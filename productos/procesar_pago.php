<?php
session_start();
require_once '../config/conexion.php';
$cliente_id = $_SESSION['id'] ?? null;  
$cliente = null;

if ($cliente_id) {
    $sql = "SELECT * FROM cliente WHERE numeroIdentificacion = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && mysqli_num_rows($res) > 0) {
        $cliente = mysqli_fetch_assoc($res);
    }
}
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Si no hay carrito, redirige a productos
$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
    header('Location: productos.php');
    exit;
}

$mysqli = $conexion;
$stmt = $mysqli->prepare("SELECT codigoBarras, nombre, precio, imagen FROM producto WHERE codigoBarras = ? LIMIT 1");
$cart_items = [];
$total = 0.0;
$cantidad_total = 0;

foreach ($carrito as $codigo => $item) {
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
        $precio = (float)$row['precio'];
        $subtotal = $precio * $cantidad;
        $total += $subtotal;
        $cantidad_total += $cantidad;
        
        $cart_items[] = [
            'codigo'   => $row['codigoBarras'],
            'nombre'   => $row['nombre'],
            'precio'   => $precio,
            'imagen'   => $row['imagen'],
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ];
    }
}
$stmt->close();
$mysqli->close();

$shipping = 10000;   // Costo de envío fijo
$grand_total = $total + $shipping;

$metodoPago = $_POST['metodoPago'] ?? 'Efectivo';
$comentarios = $_POST['comentarios'] ?? '';

$page_title = 'Finalizar Compra - Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5">
    <div class="mb-5 text-center">
        <h2 class="display-6 fw-bold text-dark" style="font-family: 'Montserrat', sans-serif;">Paso Final Requerido</h2>
        <p class="text-muted">Confirma tu dirección de entrega para despachar tu pedido.</p>
    </div>

    <div class="row justify-content-center g-4">
        
        <!-- Detalles de Envío -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="m-0 fw-bold"><i class="bi bi-geo-alt-fill text-danger me-2"></i> Detalles de Facturación y Envío</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="final_pago.php" method="POST">
                        
                        <!-- Datos heredados ocultos -->
                        <input type="hidden" name="metodoPago" value="<?= e($metodoPago) ?>">
                        <input type="hidden" name="comentarios" value="<?= e($comentarios) ?>">

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Nombre Completo</label>
                                <input type="text" class="form-control bg-light" name="nombre" value="<?= e($cliente ? $cliente['nombres'] . ' ' . $cliente['apellidos'] : '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-secondary small fw-bold">Teléfono Móvil</label>
                                <input type="tel" class="form-control bg-light" name="telefono" value="<?= e($cliente ? $cliente['telefono'] : '') ?>" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-bold">Correo Electrónico</label>
                            <input type="email" class="form-control bg-light" name="correo" value="<?= e($cliente ? $cliente['correo'] : '') ?>" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-dark fw-bold"><i class="bi bi-house-door-fill text-primary"></i> Dirección de Entrega</label>
                            <input type="text" class="form-control form-control-lg bg-light border-primary" name="direccion" placeholder="Ej: Calle 45 # 12-34, Barrio Centro..." required>
                            <div class="form-text text-muted mt-2">Especifica el número de apartamento u oficinas si es necesario.</div>
                        </div>

                        <div class="alert alert-info border-0 shadow-sm mt-4 bg-primary text-white" style="background: linear-gradient(135deg, var(--primary) 0%, #b0050d 100%) !important;">
                            <i class="bi bi-info-circle-fill me-2"></i> Método de pago seleccionado: <strong><?= e($metodoPago) ?></strong>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow">
                                Confirmar y Pagar (<?= '$' . number_format($grand_total, 0, ',', '.') ?>)
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Resumen Rápido -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-light">
                <div class="card-header bg-transparent border-bottom py-3">
                    <h5 class="m-0 fw-bold"><i class="bi bi-cart-check-fill text-success me-2"></i> Resumen del Pedido</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-group list-group-flush mb-4 bg-transparent">
                        <?php foreach ($cart_items as $it): ?>
                            <li class="list-group-item bg-transparent px-0 border-secondary border-opacity-25 d-flex justify-content-between lh-sm">
                                <div>
                                    <h6 class="my-0 text-dark fw-semibold"><?= e($it['nombre']) ?></h6>
                                    <small class="text-muted">Cantidad: <?= $it['cantidad'] ?></small>
                                </div>
                                <span class="text-muted fw-bold">$<?= number_format($it['subtotal'], 0, ',', '.') ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal (<?= $cantidad_total ?> items)</span>
                        <span class="fw-semibold">$<?= number_format($total, 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 text-danger">
                        <span>Costo de envío logístico</span>
                        <span class="fw-semibold">$<?= number_format($shipping, 0, ',', '.') ?></span>
                    </div>
                    
                    <hr class="border-secondary opacity-25">
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="fs-5 fw-bold text-dark">Total a pagar</span>
                        <span class="fs-3 fw-bold text-primary">$<?= number_format($grand_total, 0, ',', '.') ?></span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
