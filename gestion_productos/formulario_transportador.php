<?php
$page_title = 'Registrar Conductor - Admin';
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
                <a href="gestionar_transportadores.php" class="btn btn-outline-secondary rounded-circle me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <div>
                    <h2 class="fw-bold text-dark m-0"><i class="bi bi-person-plus-fill me-2 text-success"></i>Registrar Conductor</h2>
                    <p class="text-muted mt-1 mb-0">Agrega un nuevo transportador a la logística de envíos de Piolín.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="insertar_transportador.php" method="POST">
                        
                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary small">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="nombre" required maxlength="100" placeholder="Ej: Juan Pérez">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="telefono" maxlength="50" placeholder="Ej: 3001234567">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control bg-light border-start-0 ps-0" name="correo" required placeholder="correo@ejemplo.com">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Vehículo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-truck"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="vehiculo" placeholder="Moto, Camioneta, Bici...">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Número de Placa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="placa" maxlength="20" placeholder="AAA-123">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 text-center p-3 bg-light rounded border">
                            <label class="form-label fw-bold text-dark mb-3 d-block">Calificación Inicial / Estrellas</label>
                            
                            <div class="btn-group gap-2" role="group">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <input type="radio" class="btn-check" name="calificacion" id="estrella<?= $i ?>" value="<?= $i ?>" autocomplete="off" <?= $i==5 ? 'checked' : '' ?>>
                                    <label class="btn btn-outline-warning rounded border fs-4 pt-1 pb-1" for="estrella<?= $i ?>" title="<?= $i ?> estrellas">
                                        <?= $i ?> <i class="bi bi-star-fill"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill fw-bold shadow-sm" name="guardar">
                                <i class="bi bi-person-check-fill me-2"></i> Guardar Conductor
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
/* Estilos para que los botones radio parezcan estrellas seleccionadas usando Bootstrap */
.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    color: white !important;
}
.btn-outline-warning {
    color: #ffc107;
}
</style>

<?php require_once '../includes/admin_footer.php'; ?>
