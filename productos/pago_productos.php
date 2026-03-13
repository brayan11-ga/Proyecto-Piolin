<?php
session_start();
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

// Manejo simple para eliminar un item (opcional)
if (isset($_GET['quitar'])) {
    $codigoQ = (string)$_GET['quitar'];
    if (isset($_SESSION['carrito'][$codigoQ])) {
        unset($_SESSION['carrito'][$codigoQ]);
    }
    header('Location: pago_productos.php');
    exit;
}

// Obtener carrito desde la sesión
$carrito = $_SESSION['carrito'] ?? [];

// Conectar a la DB
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Preparar array con datos completos del carrito y calcular total
$cart_items = [];
$total = 0.0;

if (!empty($carrito)) {
    foreach ($carrito as $codigo => $item) {
        // Convertir a entero o limpiar según tu esquema
        $cod = mysqli_real_escape_string($conexion, $codigo);

        // Traer nombre y precio del producto
        $sql = "SELECT codigoBarras, nombre, precio, imagen FROM producto WHERE codigoBarras = '$cod' LIMIT 1";
        $res = mysqli_query($conexion, $sql);

        if ($res && mysqli_num_rows($res) > 0) {
            $prod = mysqli_fetch_assoc($res);
            $cantidad = isset($item['cantidad']) ? (int)$item['cantidad'] : 1;
            $precio = (float)$prod['precio'];
            $subtotal = $precio * $cantidad;
            $total += $subtotal;

            $cart_items[] = [
                'imagen'   => $prod['imagen'],
                'codigo'   => $prod['codigoBarras'],
                'nombre'   => $prod['nombre'],
                'precio'   => $precio,
                'cantidad' => $cantidad,
                'subtotal' => $subtotal
            ];
        }
    }
}

mysqli_close($conexion);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar - Piolín</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="pago_productos.css">
    
</head>
<body>
    <header>
        <div class="logo">
            <img src="../img/Logo.png" width="500" height="150" alt="Piolín">
        </div>
        <div class="titulo"><h1 class="textotitulo">PIOLIN</h1></div>
        <div class="boton"><?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
        <!-- Está logueado -->
        <a href="../cerrar sesión/cerrar_sesión.php" class="cerrar">Salir</a>
    <?php else: ?>
        <!-- No ha iniciado sesión -->
        <a href="../ingresar/ingresar.php" class="ingreso">Entrar</a>
    <?php endif; ?></div>
    </header>

    <nav> <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="../formulario/formulario.php">Registro</a></li>
            <li><a href="../acerca/acerca.php">Acerca de</a></li>
        </ul> </nav>


        <?php if (empty($cart_items)): ?>
            <div class="carro-vacio">
                <i class="bi bi-cart-x-fill"></i> <p class="carrito-vacio">Tu carrito está vacío. <a href="productos.php">Ver productos</a></p>
            </div>
            
        <?php else: ?>
                             
            <main class="container">
  <h2>Resumen del carrito</h2>

  <div class="cart-cards">
   <?php foreach ($cart_items as $it): ?>
    <div class="card cart-item">
      <img src="../agregar productos/img/<?= e($it['imagen']) ?>" class="card-img-top" alt="<?= e($it['nombre']) ?>">
      <div class="card-body">
        <h5 class="card-title"><?= e($it['nombre']) ?></h5>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Precio: <?= '$' . number_format($it['precio'], 0, ',', '.') ?></li>
        
         <li class="list-group-item">Cantidad: <?= (int)$it['cantidad'] ?></li>
         
        <li class="list-group-item">Subtotal: <?= '$' . number_format($it['subtotal'], 0, ',', '.') ?></li>
      </ul>
      <div class="card-body">
        <a href="pago_productos.php?quitar=<?= e($it['codigo']) ?>" class="card-link">Eliminar</a>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="total-box">Total a pagar: <?= '$' . number_format($total, 0, ',', '.') ?></div>
  
  <a href="procesar_pago.php" class="btn-pagar">Pagar <?= '$' . number_format($total, 0, ',', '.') ?></a>
</button>
</main>

    
            <!-- Formulario de pago: incluimos los items del carrito como campos ocultos -->
            <form action="procesar_pago.php" method="post">
                <?php foreach ($cart_items as $i => $it): ?>
                    <input type="hidden" name="items[<?= $i ?>][codigo]" value="<?= e($it['codigo']) ?>">
                    <input type="hidden" name="items[<?= $i ?>][cantidad]" value="<?= e($it['cantidad']) ?>">
                    <input type="hidden" name="items[<?= $i ?>][precio]" value="<?= e($it['precio']) ?>">
                <?php endforeach; ?>

                <input type="hidden" name="total" value="<?= $total ?>">

                <!-- Aquí puedes poner tus campos de facturación que ya tenías -->
                <div class="row">
                   <!-- campo: Nombre, Email, Dirección, etc. (tu html original) -->
                </div>

            </form>
        <?php endif; ?>
    </main>

    <footer><p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p></footer>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>