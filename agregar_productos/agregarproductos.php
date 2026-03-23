<?php
$page_title = 'Añadir Producto - Admin';
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
                    <h2 class="fw-bold text-dark m-0"><i class="bi bi-cloud-plus-fill me-2 text-primary"></i>Añadir Nuevo Producto</h2>
                    <p class="text-muted mt-1 mb-0">Llena los datos para agregar un artículo nuevo al inventario virtual.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="insertar.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="codigobarras" class="form-label fw-bold text-secondary small">Código de Barras</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-upc-scan"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" id="codigobarras" name="codigobarras" required placeholder="Ej: 77020001000">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label fw-bold text-secondary small">Nombre del Producto</label>
                                <input type="text" class="form-control bg-light" id="nombre" name="nombre" required placeholder="Ej: Arroz Diana">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="categoria" class="form-label fw-bold text-secondary small">Categoría Principal</label>
                            <select class="form-select bg-light" id="categoria" name="categoria" required>
                                <option value="" selected disabled>Seleccione una categoría</option>
                                <option value="Frutas y verduras">🥬 Alimentos frescos (Frutas y verduras)</option>
                                <option value="carnes">🥩 Carnes, pescados y proteínas</option>
                                <option value="Lacteos">🥛 Lácteos y derivados</option>
                                <option value="Panadería">🍞 Panadería y repostería</option>
                                <option value="Alimentos">🥫 Alimentos no perecederos (despensa)</option>
                                <option value="Snacks">🍫 Snacks y dulces</option>
                                <option value="Bebidas">🥤 Bebidas</option>
                                <option value="Congelados">🧊 Congelados</option>
                                <option value="Bebes">🍼 Productos para bebés</option>
                                <option value="Higiene">🧼 Higiene personal</option>
                                <option value="Limpieza">🧹 Limpieza del hogar</option>
                                <option value="Mascotas">🐶 Mascotas</option>
                            </select>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label for="precio" class="form-label fw-bold text-secondary small">Precio de Venta (COP)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0">$</span>
                                    <input type="number" class="form-control bg-light border-start-0 ps-0" id="precio" name="precio" min="0" required placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label fw-bold text-secondary small">Unidades en Stock</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-boxes"></i></span>
                                    <input type="number" class="form-control bg-light border-start-0 ps-0" id="stock" name="stock" min="0" required placeholder="0">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-bold text-secondary small">Descripción Detalles</label>
                            <textarea class="form-control bg-light" id="descripcion" name="descripcion" rows="3" placeholder="Información relevante sobre la presentación o gramaje..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary small">Imagen del Producto</label>
                            <div class="border rounded px-3 py-4 text-center bg-light" style="border-style: dashed !important; border-width: 2px !important; border-color: #dee2e6 !important;">
                                <i class="bi bi-image text-muted fs-1 mb-2 d-block"></i>
                                <input class="form-control" type="file" id="imagen" name="imagen" accept="image/*" required>
                                <div class="form-text mt-2">Sube una imagen cuadrada de buena calidad (JPG o PNG, máx. 2MB).</div>
                            </div>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm" name="guardar">
                                <i class="bi bi-save2-fill me-2"></i> Guardar Producto en el Catálogo
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once '../includes/admin_footer.php'; ?>
