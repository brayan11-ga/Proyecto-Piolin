<?php
session_start();
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Manejo simple para eliminar un item (opcional)
if (isset($_GET['quitar'])) {
    $codigoQ = (string)$_GET['quitar'];
    if (isset($_SESSION['carrito'][$codigoQ])) {
        unset($_SESSION['carrito'][$codigoQ]);
    }
    header('Location: pago_productos.php');
    exit;
}

// Obtener carrito desde la sesión
$carrito = $_SESSION['carrito'] ?? [];

// Conectar a la DB
require_once '../config/conexion.php';
// Preparar array con datos completos del carrito y calcular total
$cart_items = [];
$total = 0.0;
$cantidad_total = 0;

if (!empty($carrito)) {
    foreach ($carrito as $codigo => $item) {
        $cod = mysqli_real_escape_string($conexion, $codigo);
        $sql = "SELECT codigoBarras, nombre, precio, imagen FROM producto WHERE codigoBarras = '$cod' LIMIT 1";
        $res = mysqli_query($conexion, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            $prod = mysqli_fetch_assoc($res);
            $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
            $precio = (float)$prod['precio'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;
            $cantidad_total += $cantidad;

            $cart_items[] = [
                'imagen'   => $prod['imagen'],
                'codigo'   => $prod['codigoBarras'],
                'nombre'   => $prod['nombre'],
                'precio'   => $precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ];
        }
    }
}

mysqli_close($conexion);
$page_title = 'Carrito de Compras - Supermercado Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5">
    
    <div class="mb-5 text-center">
        <h2 class="display-6 fw-bold text-dark" style="font-family: 'Montserrat', sans-serif;">Tu Carrito de Compras</h2>
        <p class="text-muted">Revisa tus productos antes de finalizar la compra.</p>
    </div>

    <?php if (empty($cart_items)): ?>
        <div class="card border-0 shadow-sm rounded-4 text-center py-5">
            <div class="card-body">
                <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                <h3 class="mt-4 fw-bold text-dark">Tu carrito está vacío</h3>
                <p class="text-muted mb-4">Parece que aún no has añadido nada a tu lista de mercado. ¡Explora nuestras ofertas!</p>
                <a href="productos.php" class="btn btn-primary rounded-pill px-5 py-3 fw-bold shadow">
                    <i class="bi bi-shop me-2"></i> Ir a la Tienda
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="row g-5">
            
            <!-- Columna Izquierda: Lista de Productos -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="m-0 fw-bold"><i class="bi bi-bag-check-fill text-primary me-2"></i> Productos (<?= $cantidad_total ?>)</h5>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <?php foreach ($cart_items as $it): ?>
                            <div class="list-group-item bg-transparent p-4">
                                <div class="row align-items-center">
                                    <div class="col-4 col-sm-3 col-md-2 text-center">
                                        <div class="bg-light rounded p-2 ratio ratio-1x1 position-relative overflow-hidden">
                                             <img src="../assets/img/<?= e($it['imagen']) ?>" alt="<?= e($it['nombre']) ?>" class="img-fluid position-absolute top-50 start-50 translate-middle" style="max-height: 90%; object-fit: contain;">
                                        </div>
                                    </div>
                                    
                                    <div class="col-8 col-sm-6 col-md-5">
                                        <h5 class="fw-bold mb-1 text-dark"><?= e($it['nombre']) ?></h5>
                                        <p class="text-muted small mb-0">SKU: <?= e($it['codigo']) ?></p>
                                    </div>
                                    
                                    <div class="col-6 col-sm-3 col-md-2 text-center mt-3 mt-sm-0">
                                        <div class="bg-light rounded-pill px-3 py-1 d-inline-block border">
                                            <span class="text-muted small fw-bold">Cant:</span> <span class="fw-bold text-dark"><?= (int)$it['cantidad'] ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6 col-sm-12 col-md-3 text-end mt-3 mt-md-0 d-flex flex-md-column justify-content-between align-items-end h-100">
                                        <span class="fw-bold text-danger fs-5">$<?= number_format($it['subtotal'], 0, ',', '.') ?></span>
                                        <a href="pago_productos.php?quitar=<?= e($it['codigo']) ?>" class="btn btn-sm btn-outline-danger rounded-pill mt-2">
                                            <i class="bi bi-trash"></i> Quitar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Columna Derecha: Tarjeta de Resumen / Checkout -->
            <div class="col-lg-4">
                <div class="card border-0 shadow position-sticky rounded-4" style="top: 100px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="m-0 fw-bold"><i class="bi bi-receipt text-success me-2"></i> Resumen del Pedido</h5>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">$<?= number_format($total, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Envío estimado</span>
                            <span class="text-success fw-bold">Gratis</span>
                        </div>
                        
                        <hr class="my-3 border-secondary opacity-25">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fs-5 fw-bold text-dark">Total</span>
                            <span class="fs-3 fw-bold text-danger">$<?= number_format($total, 0, ',', '.') ?></span>
                        </div>

                        <!-- Formulario de compra oculto -->
                        <form action="procesar_pago.php" method="POST">
                            <?php foreach ($cart_items as $i => $it): ?>
                                <input type="hidden" name="items[<?= $i ?>][codigo]" value="<?= e($it['codigo']) ?>">
                                <input type="hidden" name="items[<?= $i ?>][cantidad]" value="<?= e($it['cantidad']) ?>">
                                <input type="hidden" name="items[<?= $i ?>][precio]" value="<?= e($it['precio']) ?>">
                            <?php endforeach; ?>
                            <input type="hidden" name="total" value="<?= $total ?>">
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold text-secondary">Método de Pago</label>
                                <select class="form-select bg-light" name="metodoPago" required>
                                    <option value="Efectivo">Efectivo contra entrega</option>
                                    <option value="Tarjeta">Tarjeta de Crédito / Débito</option>
                                    <option value="Transferencia">Transferencia Bancaria (PSE)</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-secondary">Notas / Comentarios</label>
                                <textarea class="form-control bg-light" name="comentarios" rows="2" placeholder="Agrega instrucciones de entrega (opcional)"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold fs-5 shadow">
                                Procesar Pago <i class="bi bi-arrow-right-circle-fill ms-2"></i>
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="productos.php" class="text-decoration-none text-muted small"><i class="bi bi-arrow-left me-1"></i> Seguir comprando</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>
