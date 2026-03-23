<?php
$page_title = 'Panel de Administración - Supermercado Piolín';
require_once '../includes/admin_header.php';

// Validar que realmente sea un empleado/administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    echo "<script>window.location.href = '../index.php';</script>";
    exit;
}
?>

<section class="container py-5">
    <div class="d-flex align-items-center mb-5">
        <div class="bg-primary text-white p-3 rounded-circle shadow-sm me-3">
            <i class="bi bi-speedometer2 fs-2"></i>
        </div>
        <div>
            <h2 class="fw-bold m-0 text-dark">Panel de Control Administrativo</h2>
            <p class="text-muted mb-0">Bienvenido, <?= htmlspecialchars($_SESSION['nombres']) ?>. ¿Qué deseas gestionar hoy?</p>
        </div>
    </div>

    <div class="row g-4">
        
        <!-- Gestión de Productos -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-transform product-card">
                <div class="card-body p-4 text-center">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-box-seam text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Gestión de Productos</h4>
                    <p class="text-muted mb-4">Añade, edita, actualiza stock o elimina productos del catálogo para los clientes.</p>
                    <a href="../gestion_productos/gestioproductos.php" class="btn btn-outline-primary w-100 rounded-pill fw-semibold">Administrar</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Transportadores -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-transform product-card">
                <div class="card-body p-4 text-center">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-truck text-success fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Transportadores</h4>
                    <p class="text-muted mb-4">Administra el personal de entrega, vincula vehículos y revisa transportes activos.</p>
                    <a href="../gestion_productos/gestionar_transportadores.php" class="btn btn-outline-success w-100 rounded-pill fw-semibold">Administrar</a>
                </div>
            </div>
        </div>

        <!-- Gestión de Pedidos (Visual Only Placeholder as requested by standard admin templates) -->
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm transition-transform product-card">
                <div class="card-body p-4 text-center">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-cart-check text-warning fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Pedidos / Ventas</h4>
                    <p class="text-muted mb-4">Visualiza el registro histórico de ventas realizadas por los clientes.</p>
                    <a href="#" class="btn btn-outline-warning w-100 rounded-pill fw-semibold">Próximamente</a>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once '../includes/admin_footer.php'; ?>
