<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error conexión: " . mysqli_connect_error());
}


$cliente_id = $_SESSION['id'] ?? null;  
$cliente = null;

if ($cliente_id) {
    $sql = "SELECT * FROM cliente WHERE numeroIdentificacion = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cliente_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);

    if ($res && mysqli_num_rows($res) > 0) {
        $cliente = mysqli_fetch_assoc($res);
    }
}
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Si no hay carrito, redirige a productos
$carrito = $_SESSION['carrito'] ?? [];
if (empty($carrito)) {
    header('Location: productos.php');
    exit;
}

// Conexión MySQL
$host = "localhost";
$user = "root";
$pass = "";
$db   = "proyecto_ventas";
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_error) {
    die("Error conexión: " . $mysqli->connect_error);
}


$stmt = $mysqli->prepare("SELECT codigoBarras, nombre, precio, imagen FROM producto WHERE codigoBarras = ? LIMIT 1");
$cart_items = [];
$total = 0.0;

foreach ($carrito as $codigo => $item) {
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
        $precio = (float)$row['precio'];
        $subtotal = $precio * $cantidad;
        $total += $subtotal;
        $cart_items[] = [
            'codigo'   => $row['codigoBarras'],
            'nombre'   => $row['nombre'],
            'precio'   => $precio,
            'imagen'   => $row['imagen'],
            'cantidad' => $cantidad,
            'subtotal' => $subtotal
        ];
    }
}
$stmt->close();
$mysqli->close();

// Ajusta envío a lo que desees
$shipping = 10000;   // ejemplo fijo
$grand_total = $total + $shipping;

$nombreCliente   = $cliente ? $cliente['nombres'] . ' ' . $cliente['apellidos'] : '';
$telefonoCliente = $cliente ? $cliente['telefono'] : '';
$correoCliente   = $cliente ? $cliente['correo'] : '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>finalizar compra - Piolín</title>
  <link rel="shortcut icon" href="../img/favicon-32x32.png" type="image/x-icon">
  <link rel="stylesheet" href="procesar_pago.css">
  <link rel="stylesheet" href="../estilos/estiloindex.css">
  <!-- si usas iconos o bootstrap agrégalos -->
</head>
<body>
  <header>
        <div class="logo">
            <img src="../img/Logo.png" width="500px" height="150px">
        </div>

        <div class="titulo">
            <h1 class="textotitulo">PIOLIN</h1>
        </div>
        
        <div class="boton">
            <a href="../cerrar sesión/cerrar_sesión.php" class="ingreso">SALIR</a>
        </div>
    </header>
<div class="textofin"><h3>Finalizar compra</h3></div>
<main>
  <section class="checkout-form">

    <!-- Formulario de contacto / envío -->
    <form action="final_pago.php" method="post">
  <h6>Información de contacto</h6>

  <div class="form-control">
    <label for="checkout-name">Nombre</label>
    <input type="text" id="checkout-name" name="nombre" 
           value="<?= htmlspecialchars($cliente['nombres'] . ' ' . $cliente['apellidos']) ?>" required>
  </div>

  <div class="form-control">
    <label for="checkout-phone">Teléfono</label>
    <input type="tel" id="checkout-phone" name="telefono" 
           value="<?= htmlspecialchars($cliente['telefono']) ?>" required>
  </div>

  <div class="form-control">
  <label for="direccion">Dirección de envío</label>
  <input type="text" id="direccion" name="direccion" placeholder="Calle, número, barrio..." required>
</div>

  <div class="form-control">
    <label for="checkout-email">Correo</label>
    <input type="email" id="checkout-email" name="correo" 
           value="<?= htmlspecialchars($cliente['correo']) ?>" required>
  </div>

  <h6>Forma de pago</h6>
  <div class="form-control">
    <select name="metodoPago" required>
      <option value="">-- Selecciona un método --</option>
      <option value="Efectivo">Efectivo</option>
      <option value="Tarjeta">Tarjeta de crédito/débito</option>
      <option value="Nequi">Nequi</option>
      <option value="Daviplata">Daviplata</option>
    </select>
  </div>

  <div class="form-control">
    <label for="comentarios">Comentarios</label>
    <textarea name="comentarios" id="comentarios" rows="3" placeholder="Notas sobre tu pedido"></textarea>
  </div>

  <button type="submit" class="btn-pagar">Finalizar compra</button>
</form>

  </section>

  <section class="checkout-details">
    <div class="checkout-details-inner">
      <div class="checkout-lists">

      <?php foreach ($cart_items as $it): ?>
  <div class="card">
    <div class="card-image">
      <img src="../agregar productos/img/<?= e($it['imagen']) ?>" alt="<?= e($it['nombre']) ?>">
    </div>

    <div class="card-details">
      <div class="card-name"><?= e($it['nombre']) ?></div>

      <div class="card-price"><?= '$' . number_format($it['precio'], 0, ',', '.') ?></div>

      <!-- controles: cantidad + eliminar (separados) -->
      <div class="controls">
        <div class="card-wheel">
          <!-- disminuir -->
          <form action="actualizar_carrito.php" method="post" class="qty-form">
            <input type="hidden" name="codigo" value="<?= e($it['codigo']) ?>">
            <button type="submit" name="action" value="dec" class="qty-btn" aria-label="Disminuir cantidad">-</button>
          </form>

          <span class="qty-number"><?= (int)$it['cantidad'] ?></span>

          <!-- aumentar -->
          <form action="actualizar_carrito.php" method="post" class="qty-form">
            <input type="hidden" name="codigo" value="<?= e($it['codigo']) ?>">
            <button type="submit" name="action" value="inc" class="qty-btn" aria-label="Incrementar cantidad">+</button>
          </form>
        </div>

        <!-- eliminar (fuera del wheel para que no se solape) -->
        <form action="actualizar_carrito.php" method="post" class="remove-form">
          <input type="hidden" name="codigo" value="<?= e($it['codigo']) ?>">
          <button type="submit" name="action" value="remove" class="remove-btn" aria-label="Eliminar producto">Eliminar</button>
        </form>
      </div>

      <div class="card-subtotal">Subtotal: <?= '$' . number_format($it['subtotal'], 0, ',', '.') ?></div>
    </div>
  </div>
<?php endforeach; ?>
      </div>

      <div class="checkout-shipping">
        <h6>Envío</h6>
        <p><?= '$' . number_format($shipping, 0, ',', '.') ?></p>
      </div>
      <div class="checkout-total">
        <h6>Total</h6>
        <p><?= '$' . number_format($grand_total, 0, ',', '.') ?></p>
      </div>
    </div>
  </section>
</main>

<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
</body>
</html>
