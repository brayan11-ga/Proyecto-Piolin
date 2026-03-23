<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // inicializar carrito
}

if (isset($_GET['agregar'])) {
    $codigo = (int)$_GET['agregar'];

    // Si ya existe, aumentar cantidad
    if (isset($_SESSION['carrito'][$codigo])) {
        $_SESSION['carrito'][$codigo]['cantidad']++;
    } else {
        $conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
        $stmt = mysqli_prepare($conexion, "SELECT precio, nombre FROM producto WHERE codigoBarras = ?");
        mysqli_stmt_bind_param($stmt, "i", $codigo);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $prod = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);


        $_SESSION['carrito'][$codigo] = [
            'id' => $codigo,
            'nombre' => $prod['nombre'],
            'precio' => (float) $prod['precio'],
            'cantidad' => 1
        ];
    }
    // Redirigir de nuevo al producto
    header("Location: producto.php?codigo=$codigo&agregado=1");
    exit;
}

$codigoBarras = $_GET['codigo'];

// producto.php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    http_response_code(500);
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_GET['codigo']) || !ctype_digit($_GET['codigo'])) {
    http_response_code(400);
    die("Solicitud inválida: falta id de producto.");
}

$id = (int)$_GET['codigo'];

$stmt = mysqli_prepare($conexion, "SELECT codigoBarras, nombre, categoria, precio, stock, descripcion, imagen FROM producto WHERE codigoBarras = ?");
mysqli_stmt_bind_param($stmt, "s", $codigoBarras);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    http_response_code(404);
    die("Producto no encontrado.");
}

$producto = mysqli_fetch_assoc($result);
mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

function e($str) { return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
$page_title = e($producto['nombre']) . ' - Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5">
    
    <!-- Breadcrumb moderno -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded-pill shadow-sm">
            <li class="breadcrumb-item"><a href="productos.php" class="text-decoration-none text-muted"><i class="bi bi-shop me-1"></i>Catálogo</a></li>
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-muted"><?= e($producto['categoria']) ?></a></li>
            <li class="breadcrumb-item active fw-bold text-dark" aria-current="page"><?= e($producto['nombre']) ?></li>
        </ol>
    </nav>

    <?php if(isset($_GET['agregado'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-pill shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> ¡El producto <strong><?= e($producto['nombre']) ?></strong> se añadió correctamente a tu carrito de compras!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="row g-0">
            <!-- Galería de fotos (Izquierda) -->
            <div class="col-md-5 col-lg-6 bg-white border-end d-flex align-items-center justify-content-center p-4">
                <div class="ratio ratio-1x1 position-relative w-75">
                    <img src="../assets/img/<?= e($producto['imagen']) ?>" alt="<?= e($producto['nombre']) ?>" class="img-fluid position-absolute top-50 start-50 translate-middle" style="object-fit: contain; max-height: 90%; transition: transform 0.3s ease;" onmouseover="this.style.transform='translate(-50%, -50%) scale(1.1)'" onmouseout="this.style.transform='translate(-50%, -50%) scale(1)'">
                </div>
            </div>
            
            <!-- Detalles e Info de Venta (Derecha) -->
            <div class="col-md-7 col-lg-6 p-4 p-md-5 d-flex flex-column">
                <div class="mb-1 text-muted small"><i class="bi bi-upc-scan me-1"></i> SKU: <?= (int)$producto['codigoBarras'] ?> | <i class="bi bi-tag text-primary ms-2 me-1"></i> <?= e($producto['categoria']) ?></div>
                <h1 class="display-5 fw-bold text-dark mb-3" style="font-family: 'Montserrat', sans-serif;"><?= e($producto['nombre']) ?></h1>
                
                <div class="mb-4">
                    <span class="fs-1 fw-bold text-danger">$<?= number_format((float)$producto['precio'], 0, ',', '.') ?></span>
                </div>

                <div class="mb-4">
                    <span class="badge bg-success rounded-pill px-3 py-2 fs-6 fw-semibold shadow-sm"><i class="bi bi-box-seam me-1"></i> <?= (int)$producto['stock'] ?> Unidades Disp.</span>
                </div>

                <div class="mb-4 flex-grow-1">
                    <h5 class="fw-bold text-secondary mb-2">Acerca de este artículo</h5>
                    <p class="text-muted lh-lg"><?= e($producto['descripcion']) ?></p>
                </div>

                <hr class="border-secondary opacity-25 my-4">

                <div class="d-grid gap-3 d-sm-flex">
                    <a href="producto.php?codigo=<?= $producto['codigoBarras'] ?>&agregar=<?= $producto['codigoBarras'] ?>" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm px-5 py-3 flex-grow-1">
                        <i class="bi bi-cart-plus-fill fs-5 me-2"></i> Agregar al carrito
                    </a>
                    
                    <a href="productos.php" class="btn btn-light border btn-lg rounded-pill fw-bold text-secondary px-4 py-3">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mini-Carrito en la vista (Fijo Abajo Izquierda como antes pero con estilo nuevo) -->
    <?php
    $cartCount = 0;
    $cartTotal = 0;
    if (isset($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $cartCount += $item['cantidad'];
            $cartTotal += $item['precio'] * $item['cantidad'];
        }
    }
    ?>
    <?php if($cartCount > 0): ?>
        <div class="position-fixed bottom-0 end-0 p-4 z-3" style="pointer-events: none;">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden pointer-events-auto" style="width: 250px; pointer-events: auto;">
                <div class="card-header bg-danger text-white text-center py-2 fw-bold">
                    <i class="bi bi-cart-check-fill me-1"></i> Tu Carrito
                </div>
                <div class="card-body text-center p-3 bg-white">
                    <p class="mb-1 text-muted small"><?= $cartCount ?> Artículo(s)</p>
                    <h5 class="fw-bold text-dark mb-3">$<?= number_format($cartTotal, 0, ',', '.') ?></h5>
                    <div class="d-grid gap-2">
                        <a href="pago_productos.php" class="btn btn-outline-danger btn-sm rounded-pill fw-bold">Ir a Pagar</a>
                        <a href="vaciar_carrito.php" class="btn btn-light text-muted btn-sm rounded-pill"><i class="bi bi-trash"></i> Vaciar</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</main>

<?php require_once '../includes/footer.php'; ?>
