<?php
session_start();
include 'conexion.php';

$id_cliente = $_SESSION['id']; 

$sql = "CALL ConsultarComprasDetalle(?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param('i', $id_cliente);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Compras</title>
  <link rel="shortcut icon" href="../img/img/favicon-32x32.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-dark text-white text-center rounded-top-4">
      <h3><i class="bi bi-cart4"></i> Mis Compras</h3>
    </div>
    <div class="card-body">
      <table class="table table-striped table-hover text-center align-middle">
        <thead class="table-dark">
          <tr>
            <th>N° Factura</th>
            <th>Fecha</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php while($fila = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $fila['numeroFactura'] ?></td>
            <td><?= $fila['fechaVenta'] ?></td>
            <td><?= $fila['producto'] ?></td>
            <td><?= $fila['cantidad'] ?></td>
            <td>$<?= number_format($fila['precio_unitario'], 2) ?></td>
            <td>$<?= number_format($fila['subtotal'], 2) ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <div class="text-center mt-4">
        <a href="reporte.php" class="btn btn-danger btn-lg rounded-pill shadow">
          <i class="bi bi-file-earmark-pdf"></i> Generar PDF
        </a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
