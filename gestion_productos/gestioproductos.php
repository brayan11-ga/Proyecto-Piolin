<?php
require_once '../config/conexion.php';

// Si viene de insertar
$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ Producto guardado con éxito.";
}

// Mensajes adicionales si existen
if (isset($_GET['mensaje'])) {
    $mensaje = $_GET['mensaje'];
}

// Traer todos los productos
$sql = "SELECT * FROM producto ORDER BY codigoBarras DESC";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$page_title = 'Gestión de Productos - Admin';
require_once '../includes/admin_header.php';

// Validar que realmente sea un empleado/administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    echo "<script>window.location.href = '../index.php';</script>";
    exit;
}
?>

<main class="container py-5">
    
    <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-3">
        <div>
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-box-seam me-2 text-primary"></i>Gestión de Productos</h2>
            <p class="text-muted mt-1 mb-0">Administra el inventario, edita precios o elimina productos del catálogo.</p>
        </div>
        <a href="../agregar_productos/agregarproductos.php" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">
            <i class="bi bi-cloud-upload-fill me-2"></i> Añadir Nuevo
        </a>
    </div>

    <?php if ($mensaje != ""): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><strong>¡Éxito!</strong> <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i><strong>¡Acción Denegada!</strong> <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4 mt-2">
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm product-card border-0">
                        <div class="img-container position-relative bg-light rounded-top d-flex align-items-center justify-content-center p-3" style="height: 200px; overflow:hidden;">
                            <img src="../assets/img/<?= htmlspecialchars($fila['imagen']) ?>" class="img-fluid" alt="<?= htmlspecialchars($fila['nombre']) ?>" style="max-height: 100%; object-fit: contain;">
                            
                            <!-- Etiqueta de Categoría o Stock -->
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2 px-3 py-2 rounded-pill shadow-sm">
                                <i class="bi bi-tag-fill me-1"></i><?= htmlspecialchars($fila['categoria'] ?? "General") ?>
                            </span>
                        </div>
                        
                        <div class="card-body d-flex flex-column text-center pb-2">
                            <h5 class="card-title fw-bold text-dark mb-1"><?= htmlspecialchars($fila['nombre']) ?></h5>
                            <p class="text-muted small mb-2 text-truncate" title="<?= htmlspecialchars($fila['descripcion'] ?? "Sin descripción") ?>">
                                <?= htmlspecialchars($fila['descripcion'] ?? "Sin descripción") ?>
                            </p>
                            
                            <p class="card-text text-danger fs-4 fw-bold mt-auto mb-3">$<?= number_format($fila['precio'], 0, ',', '.') ?></p>
                            
                            <div class="d-flex justify-content-center gap-2 mt-auto">
                                <a href="formulario_editar.php?codigoBarras=<?= urlencode($fila['codigoBarras']) ?>" class="btn btn-warning flex-fill fw-bold text-dark shadow-sm">
                                    <i class="bi bi-pencil-square"></i> Editar
                               </a>
                                <a href="eliminar.php?codigoBarras=<?= urlencode($fila['codigoBarras']) ?>" class="btn btn-outline-danger flex-fill fw-bold bg-white shadow-sm" onclick="return confirm('¿Estás totalmente seguro de que deseas eliminar <?= htmlspecialchars($fila['nombre']) ?>? Esta acción es irreversible.');">
                                    <i class="bi bi-trash-fill"></i> Borrar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-box2 text-muted" style="font-size: 5rem;"></i>
                <h3 class="mt-3 fw-bold text-dark">No hay productos disponibles</h3>
                <p class="text-muted">El catálogo de productos de Piolín está vacío. Empieza añadiendo el primero para verlo aquí.</p>
                <a href="../agregar_productos/agregarproductos.php" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm mt-3">Añadir Mí Primer Producto</a>
            </div>
        <?php endif; ?>
    </div>

</main>

<?php require_once '../includes/admin_footer.php'; ?>

