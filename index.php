<?php
session_start();
require_once 'config/conexion.php';

// Obtener los últimos 4 productos para la sección "Novedades" u "Ofertas"
$sql = "SELECT codigoBarras, nombre, categoria, precio, imagen FROM producto ORDER BY codigoBarras DESC LIMIT 4";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$page_title = 'Supermercado Piolín - Tu tienda en casa';
require_once 'includes/header.php';
?>

<main>
    <!-- HERO SECTION -->
    <section class="position-relative bg-dark text-white text-center py-5 d-flex align-items-center" style="min-height: 60vh; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.7)), url('assets/img/hero-bg.jpg') center/cover no-repeat; background-color: #2b0000;">
        <div class="container position-relative z-2">
            <span class="badge bg-danger px-3 py-2 rounded-pill mb-3 fs-6">#1 EN SUPERMERCADOS DIGITALES</span>
            <h1 class="display-3 fw-bold mb-4" style="font-family: 'Montserrat', sans-serif;">La Frescura y el Ahorro<br><span class="text-danger">Llegan a tu Hogar</span></h1>
            <p class="lead mb-5 mx-auto" style="max-width: 600px; opacity: 0.9;">Descubre miles de productos de calidad garantizada al mejor precio del mercado. Haz tu mercado hoy mismo desde la comodidad de tu casa.</p>
            
            <div class="d-flex justify-content-center gap-3">
                <a href="productos/productos.php" class="btn btn-danger btn-lg rounded-pill px-5 py-3 fw-bold shadow">
                    Explorar Catálogo <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- BANDAS DE VENTAJAS COMPETITIVAS -->
    <section class="bg-white py-4 shadow-sm border-bottom">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <i class="bi bi-truck text-primary display-6 mb-2"></i>
                        <h6 class="fw-bold mb-1">Envíos Rápidos</h6>
                        <p class="text-muted small m-0">Logística coordinada de 24 a 48H.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center flex-column border-start border-end border-light">
                        <i class="bi bi-shield-check text-success display-6 mb-2"></i>
                        <h6 class="fw-bold mb-1">Pagos Seguros</h6>
                        <p class="text-muted small m-0">Múltiples pasarelas y efectivo contra entrega.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center justify-content-center flex-column">
                        <i class="bi bi-star-fill text-warning display-6 mb-2"></i>
                        <h6 class="fw-bold mb-1">Calidad Garantizada</h6>
                        <p class="text-muted small m-0">Productos frescos y despensa de primera.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ÚLTIMOS PRODUCTOS / OFERTAS DINÁMICAS -->
    <section class="container py-5 my-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold text-dark m-0" style="font-family: 'Montserrat', sans-serif;">Nuevos Ingresos</h2>
                <p class="text-muted">Descubre las últimas adiciones a nuestro inventario.</p>
            </div>
            <a href="productos/productos.php" class="btn btn-outline-danger rounded-pill px-4 fw-semibold d-none d-sm-inline-block">
                Ver todos <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">
            <?php if (mysqli_num_rows($resultado) > 0): ?>
                <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <!-- Tarjeta interactiva exportada de productos.php -->
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden product-card" style="transition: transform 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 .5rem 1rem rgba(0,0,0,.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 .125rem .25rem rgba(0,0,0,.075)';">
                        
                        <!-- Etiqueta opcional dinámica de "NUEVO" -->
                        <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-3 z-1 shadow-sm">NUEVO</span>

                        <div class="bg-light d-flex align-items-center justify-content-center p-3" style="height: 200px; position: relative;">
                            <img src="assets/img/<?= $fila['imagen'] ?>" class="img-fluid" alt="<?= $fila['nombre'] ?>" style="max-height: 100%; object-fit: contain;">
                        </div>
                        <div class="card-body d-flex flex-column text-center bg-white p-4">
                            <h5 class="card-title fw-bold text-dark mb-1 lh-sm" style="font-size: 1.1rem; min-height: 2.5rem; display: flex; align-items: center; justify-content: center;"><?= $fila['nombre'] ?></h5>
                            <p class="text-muted small mb-2 lh-1"><?= $fila['categoria'] ?></p>
                            <p class="card-text text-danger fs-4 fw-bold mt-auto mb-3">$<?= number_format($fila['precio'], 0, ',', '.') ?></p>
                            
                            <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                                <a href="productos/producto.php?codigo=<?= $fila['codigoBarras'] ?>" class="btn btn-primary rounded-pill shadow-sm w-100 py-2 fw-bold text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                                    <i class="bi bi-cart-plus-fill me-1 fs-5 align-middle"></i> Agregar
                                </a>
                            <?php else: ?>
                                <a href="ingresar/ingresar.php" class="btn btn-outline-secondary rounded-pill w-100 py-2 fw-semibold" style="font-size: 0.85rem;">
                                    <i class="bi bi-person me-1"></i> Inicia sesión
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 py-5 text-center">
                    <i class="bi bi-box-seam text-muted display-4 d-block mb-3"></i>
                    <p class="text-muted">Aún no hay productos registrados en el sistema.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="d-sm-none text-center mt-4">
            <a href="productos/productos.php" class="btn btn-outline-danger w-100 rounded-pill px-4 fw-semibold">
                Ver todo el catálogo <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </section>

</main>

<?php require_once 'includes/footer.php'; ?>
