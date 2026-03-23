<?php
require_once '../config/conexion.php';
if (!isset($_GET['idTransportador'])) {
    die("❌ ID de transportador no especificado.");
}

$id = intval($_GET['idTransportador']);
$sql = "SELECT * FROM transportador WHERE idTransportador = $id";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("❌ Transportador no encontrado.");
}
$fila = mysqli_fetch_assoc($resultado);

$page_title = 'Editar Conductor - Admin';
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
                    <h2 class="fw-bold text-dark m-0"><i class="bi bi-person-lines-fill me-2 text-primary"></i>Editar Transportador</h2>
                    <p class="text-muted mt-1 mb-0">Actualiza los datos de contacto o estado vehicular de "<?= htmlspecialchars($fila['nombre']) ?>".</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <form action="actualizar_transportador.php" method="POST">
                        
                        <input type="hidden" name="idTransportador" value="<?= $fila['idTransportador'] ?>">

                        <div class="row g-3">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold text-secondary small">Nombre Completo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="nombre" value="<?= htmlspecialchars($fila['nombre']) ?>" required maxlength="100">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Teléfono</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="telefono" value="<?= htmlspecialchars($fila['telefono']) ?>" maxlength="50">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control bg-light border-start-0 ps-0" name="correo" value="<?= htmlspecialchars($fila['correo']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Vehículo</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-truck"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="vehiculo" value="<?= htmlspecialchars($fila['vehiculo']) ?>">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-secondary small">Número de Placa</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control bg-light border-start-0 ps-0" name="placa" value="<?= htmlspecialchars($fila['placa']) ?>" maxlength="20">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 bg-light p-3 rounded border">
                            <label class="form-label fw-bold text-secondary small text-dark d-block">Calificación Actual / Ajuste</label>
                            
                            <div class="btn-group gap-2 w-100 mt-2" role="group">
                                <?php 
                                $cali = intval($fila['calificacion']);
                                for($i=1; $i<=5; $i++): 
                                    $checked = ($i == $cali) ? 'checked' : '';
                                ?>
                                    <input type="radio" class="btn-check" name="calificacion" id="estrella<?= $i ?>" value="<?= $i ?>" autocomplete="off" <?= $checked ?>>
                                    <label class="btn btn-outline-warning rounded border fs-5 py-2 w-100" for="estrella<?= $i ?>" title="<?= $i ?> estrellas">
                                        <?= $i ?> <i class="bi bi-star-fill"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-arrow-repeat me-2"></i> Actualizar Transportador
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.btn-check:checked + .btn-outline-warning {
    background-color: #ffc107;
    color: white !important;
}
.btn-outline-warning {
    color: #ffc107;
}
</style>

<?php require_once '../includes/admin_footer.php'; ?>
