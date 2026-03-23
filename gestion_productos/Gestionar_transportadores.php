<?php
require_once '../config/conexion.php';

// Si viene de insertar
$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ Conductor registrado con éxito.";
}

// Traer todos los transportadores
$sql = "SELECT * FROM transportador ORDER BY idTransportador DESC";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

$page_title = 'Gestión de Transportadores - Admin';
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
            <h2 class="fw-bold text-dark m-0"><i class="bi bi-truck me-2 text-success"></i>Gestión de Transportadores</h2>
            <p class="text-muted mt-1 mb-0">Administra el personal de logística, visualiza sus vehículos y calificaciones.</p>
        </div>
        <a href="formulario_transportador.php" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">
            <i class="bi bi-plus-circle-fill me-2"></i> Nuevo Transportador
        </a>
    </div>

    <?php if ($mensaje != ""): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><strong>¡Éxito!</strong> <?php echo htmlspecialchars($mensaje); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= htmlspecialchars($_GET['mensaje']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mt-2">
        <div class="table-responsive">
            <table class="table table-hover table-custom mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="py-3 px-4"># ID</th>
                        <th scope="col" class="py-3">Nombre</th>
                        <th scope="col" class="py-3">Contacto</th>
                        <th scope="col" class="py-3">Vehículo</th>
                        <th scope="col" class="py-3">Calificación</th>
                        <th scope="col" class="py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td class="px-4 fw-bold text-muted"><?= htmlspecialchars($fila['idTransportador']) ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-secondary"></i>
                                        </div>
                                        <span class="fw-bold text-dark"><?= htmlspecialchars($fila['nombre']) ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="bi bi-telephone-fill text-muted me-1"></i><?= htmlspecialchars($fila['telefono']) ?></div>
                                        <div><i class="bi bi-envelope-fill text-muted me-1"></i><a href="mailto:<?= htmlspecialchars($fila['correo']) ?>" class="text-decoration-none text-secondary"><?= htmlspecialchars($fila['correo']) ?></a></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary rounded-pill px-3 py-2 fw-normal">
                                        <i class="bi bi-car-front-fill me-1"></i><?= htmlspecialchars($fila['vehiculo']) ?> - <?= htmlspecialchars($fila['placa']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="text-warning">
                                        <i class="bi bi-star-fill"></i> <span class="text-dark fw-bold ms-1"><?= htmlspecialchars($fila['calificacion']) ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="editar_transportador.php?idTransportador=<?= $fila['idTransportador'] ?>" class="btn btn-sm btn-outline-primary" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="eliminar_transportador.php?idTransportador=<?= $fila['idTransportador'] ?>" class="btn btn-sm btn-outline-danger" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar definitivamente a este transportador?');">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-truck text-muted" style="font-size: 3rem;"></i>
                                <h5 class="mt-3 fw-bold text-dark">No hay transportadores registrados</h5>
                                <p class="text-muted mb-0">Comienza añadiendo a tu equipo logístico en el botón superior.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</main>

<?php require_once '../includes/admin_footer.php'; ?>

