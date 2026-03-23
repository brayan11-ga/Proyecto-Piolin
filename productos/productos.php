<?php
session_start();
require_once '../config/conexion.php';
$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ Producto guardado con éxito.";
}

// Traer todos los productos
$sql = "SELECT * FROM producto ORDER BY id DESC"; // Ordenado por último insertado
$sql = "SELECT * FROM producto";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
$page_title = 'Catálogo de Productos - Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5">
    <div class="text-center mb-5">
        <h2 class="display-6 fw-bold text-dark text-uppercase" style="font-family: 'Montserrat', sans-serif;">Catálogo de Productos</h2>
        <p class="text-muted">Encuentra los artículos que necesitas al mejor precio.</p>
    </div>
    
    <?php if($mensaje != ""): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-pill text-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $mensaje ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden product-card" style="transition: transform 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                <div class="bg-light d-flex align-items-center justify-content-center p-3" style="height: 200px; position: relative;">
                    <img src="../assets/img/<?= $fila['imagen'] ?>" class="img-fluid" alt="<?= $fila['nombre'] ?>" style="max-height: 100%; object-fit: contain;">
                </div>
                <div class="card-body d-flex flex-column text-center bg-white p-4">
                    <h5 class="card-title fw-bold text-dark mb-1 lh-sm" style="font-size: 1.1rem; min-height: 2.5rem; display: flex; align-items: center; justify-content: center;"><?= $fila['nombre'] ?></h5>
                    <p class="text-muted small mb-2 lh-1"><?= $fila['categoria'] ?></p>
                    <p class="card-text text-danger fs-4 fw-bold mt-auto mb-3">$<?= number_format($fila['precio'], 0, ',', '.') ?></p>
                    
                    <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                        <a href="producto.php?codigo=<?= $fila['codigoBarras'] ?>" class="btn btn-primary rounded-pill shadow-sm w-100 py-2 fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                            <i class="bi bi-cart-plus-fill me-1 fs-5 align-middle"></i> Agregar al carrito
                        </a>
                    <?php else: ?>
                        <a href="../ingresar/ingresar.php" class="btn btn-outline-secondary rounded-pill w-100 py-2 fw-semibold" style="font-size: 0.85rem;">
                            <i class="bi bi-person me-1"></i> Inicia sesión
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>
