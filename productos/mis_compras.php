<?php
session_start();
require_once '../config/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../ingresar/ingresar.php");
    exit;
}

$id_cliente = $_SESSION['id']; 

// Reemplazo del Stored Procedure por un equivalente JOIN 100% compatible
$sql = "SELECT 
            v.numeroFactura, 
            v.fechaVenta, 
            p.nombre AS producto, 
            pv.cantidad, 
            p.precio AS precio_unitario, 
            (pv.cantidad * p.precio) AS subtotal
        FROM venta v
        INNER JOIN producto_venta pv ON v.numeroFactura = pv.FK_NumeroFactura
        INNER JOIN producto p ON pv.FK_CodigoBarras = p.codigoBarras
        WHERE v.FK_IdentificacionCliente = ?
        ORDER BY v.numeroFactura DESC";

$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
$page_title = 'Mis Compras - Piolín';
require_once '../includes/header.php';
?>

<main class="container py-5">
  <div class="card shadow border-0 rounded-4 overflow-hidden mb-5">
    <div class="card-header bg-dark text-white text-center py-4">
      <h3 class="m-0 fw-bold" style="font-family: 'Montserrat', sans-serif;"><i class="bi bi-bag-check-fill me-2"></i> Mis Compras</h3>
      <p class="mb-0 text-white-50 mt-1">Historial de tus pedidos recientes en Piolín.</p>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover text-center align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="py-3 text-secondary">N° Orden</th>
              <th class="py-3 text-secondary">Fecha</th>
              <th class="py-3 text-secondary text-start">Producto</th>
              <th class="py-3 text-secondary">Cantidad</th>
              <th class="py-3 text-secondary">Precio Unit.</th>
              <th class="py-3 text-secondary">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
              <?php while($fila = $result->fetch_assoc()): ?>
              <tr>
                <td class="fw-bold">#<?= str_pad($fila['numeroFactura'], 6, "0", STR_PAD_LEFT) ?></td>
                <td class="text-muted"><?= htmlspecialchars($fila['fechaVenta']) ?></td>
                <td class="text-start fw-semibold"><?= htmlspecialchars($fila['producto']) ?></td>
                <td><span class="badge bg-secondary rounded-pill px-3"><?= $fila['cantidad'] ?></span></td>
                <td>$<?= number_format($fila['precio_unitario'], 0, ',', '.') ?></td>
                <td class="fw-bold text-success">$<?= number_format($fila['subtotal'], 0, ',', '.') ?></td>
              </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="py-5 text-muted">
                  <i class="bi bi-emoji-frown fs-1 d-block mb-3 text-black-50"></i>
                  No tienes compras registradas todavía. ¡Anímate a explorar el catálogo!
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <?php if ($result && $result->num_rows > 0): ?>
    <div class="text-center mb-5">
      <a href="reporte.php" class="btn btn-danger btn-lg rounded-pill shadow-sm px-5 fw-bold">
        <i class="bi bi-file-earmark-pdf-fill me-2"></i> Descargar Historial en PDF
      </a>
    </div>
  <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>
