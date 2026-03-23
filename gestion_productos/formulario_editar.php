<?php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");

if (isset($_GET['codigoBarras'])) {
    $codigo = $_GET['codigoBarras'];
    $sql = "SELECT * FROM producto WHERE codigoBarras = '$codigo'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        die("❌ Producto no encontrado.");
    }
} else {
    die("❌ No se recibió código de barras.");
}

$page_title = 'Editar Producto - Admin';
require_once '../includes/admin_header.php';

// Validar credenciales
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    echo "<script>window.location.href = '../index.php';</script>";
    exit;
}
?>

<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            
            <div class="d-flex align-items-center mb-4">
                <a href="../gestion_productos/gestioproductos.php" class="btn btn-outline-secondary rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark m-0"><i class="bi bi-pencil-square me-2 text-warning"></i>Editar Producto</h2>
                    <p class="text-muted mt-1 mb-0">Modifica la información o actualiza el stock de "<?= htmlspecialchars($producto['nombre']) ?>".</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="editar.php" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="codigobarras" value="<?= htmlspecialchars($producto['codigoBarras']) ?>">

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Código de Barras (Solo lectura)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" value="<?= htmlspecialchars($producto['codigoBarras']) ?>" readonly disabled>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold text-secondary small">Nombre del Producto</label>
                                <input type="text" class="form-control bg-light" id="nombre" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label fw-bold text-secondary small">Categoría Principal</label>
                            <select class="form-select bg-light" id="categoria" name="categoria" required>
                                <option value="" disabled>Seleccione una categoría</option>
                                <?php
                                $categorias = [
                                    "Frutas y verduras" => "🥬 Alimentos frescos",
                                    "Carnes, pescados y proteínas" => "🥩 Carnes, pescados y proteínas",
                                    "Lácteos y derivados" => "🥛 Lácteos y derivados",
                                    "Panadería" => "🍞 Panadería y repostería",
                                    "Alimentos" => "🥫 Alimentos no perecederos",
                                    "Snacks" => "🍫 Snacks y dulces",
                                    "Bebidas" => "🥤 Bebidas",
                                    "Congelados" => "🧊 Congelados",
                                    "Productos para bebés" => "🍼 Productos para bebés",
                                    "Higiene Personal" => "🧼 Higiene personal",
                                    "Limpieza personal" => "🧹 Limpieza del hogar",
                                    "Mascota" => "🐶 Mascotas"
                                ];
                                foreach ($categorias as $val => $label) {
                                    $selected = ($producto['categoria'] === $val) ? "selected" : "";
                                    echo "<option value=\"$val\" $selected>$label</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label fw-bold text-secondary small">Precio de Venta (COP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0">$</span>
                                    <input type="number" class="form-control bg-light border-start-0 ps-0" id="precio" name="precio" min="0" step="0.01" value="<?= htmlspecialchars($producto['precio']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold text-secondary small">Unidades en Stock</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-boxes"></i></span>
                                    <input type="number" class="form-control bg-light border-start-0 ps-0" id="stock" name="stock" min="0" value="<?= htmlspecialchars($producto['stock']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-secondary small">Descripción Detalles</label>
                            <textarea class="form-control bg-light" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($producto['descripcion']) ?></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small">Imagen Actual</label>
                            <div class="d-flex align-items-center p-3 bg-light rounded border">
                                <div class="bg-white p-2 shadow-sm rounded me-4" style="width: 100px; height: 100px; display:flex; justify-content:center; align-items:center;">
                                    <img src="../assets/img/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen actual" style="max-height:100%; max-width:100%; object-fit:contain;">
                                </div>
                                <div class="flex-grow-1">
                                    <label for="imagen" class="btn btn-outline-secondary btn-sm rounded-pill px-3 mb-2">
                                        <i class="bi bi-arrow-repeat me-1"></i> Cambiar Fotografía
                                    </label>
                                    <input type="file" id="imagen" name="imagen" class="d-none" accept="image/*">
                                    <div class="form-text small m-0">Si no seleccionas un archivo, la imagen actual se mantendrá sin cambios.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-warning btn-lg rounded-pill fw-bold shadow-sm" name="guardar">
                                <i class="bi bi-check2-circle me-2"></i> Guardar Cambios
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/admin_footer.php'; ?>
