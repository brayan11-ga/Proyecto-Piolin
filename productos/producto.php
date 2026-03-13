
<?php
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = []; // inicializar carrito
}

if (isset($_GET['agregar'])) {
    $codigo = (int)$_GET['agregar'];

    // Si ya existe, aumentar cantidad
    if (isset($_SESSION['carrito'][$codigo])) {
        $_SESSION['carrito'][$codigo]['cantidad']++;
    } else {

        $conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
        $stmt = mysqli_prepare($conexion, "SELECT precio, nombre FROM producto WHERE codigoBarras = ?");
        mysqli_stmt_bind_param($stmt, "i", $codigo);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $prod = mysqli_fetch_assoc($res);
        mysqli_stmt_close($stmt);
        mysqli_close($conexion);


        $_SESSION['carrito'][$codigo] = [
            'id' => $codigo,
            'nombre' => $prod['nombre'],
            'precio' => (float) $prod ['precio'],
            'cantidad' => 1
        ];
    }

    // Redirigir de nuevo al producto
    header("Location: producto.php?codigo=$codigo");
    exit;
}

$codigoBarras = $_GET['codigo'];

// producto.php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    http_response_code(500);
    die("Error de conexión: " . mysqli_connect_error());
}

// Validar ID
if (!isset($_GET['codigo']) || !ctype_digit($_GET['codigo'])) {
    http_response_code(400);
    die("Solicitud inválida: falta id de producto.");
}

$id = (int)$_GET['codigo'];

// Prepared statement para evitar inyección
$stmt = mysqli_prepare($conexion, "SELECT codigoBarras, nombre, categoria, precio, stock, descripcion, imagen FROM producto WHERE codigoBarras = ?");
mysqli_stmt_bind_param($stmt, "s", $codigoBarras);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) === 0) {
    http_response_code(404);
    die("Producto no encontrado.");
}

$producto = mysqli_fetch_assoc($result);
mysqli_free_result($result);
mysqli_stmt_close($stmt);
mysqli_close($conexion);

// Helpers de salida segura
function e($str) { return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title><?= e($producto['nombre']) ?> | Piolín</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"> 
    <link rel="icon" type="image/png" href="../img/favicon-32x32.png"/>
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="estiloproducto.css">
    <link rel="stylesheet" href="estilosproductos.css">
</head>
<body>
    <!-- Puedes reutilizar tu header/nav actual -->
    <header>
        <div class="logo">
            <img src="../img/Logo.png" width="500" height="150" alt="Piolín">
        </div>
        <div class="titulo"><h1 class="textotitulo">PIOLIN</h1></div>
        
        <div class="botoncerrar"><?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
        <!-- Está logueado -->
        <a href="../cerrar sesión/cerrar_sesión.php" class="cerrar">Salir</a>
    <?php else: ?>
        <!-- No ha iniciado sesión -->
        <a href="../formulario/formulario.php" class="ingreso">Entrar</a>
    <?php endif; ?></div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="productos.php">Productos</a></li>
            <li><a href="../formulario/formulario.php">Registro</a></li>
            <li><a href="../acerca/acerca.php">Acerca de</a></li>
        </ul>
    </nav>

    <div class="breadcrumb">
        <a href="productos.php">Productos</a> &nbsp;/&nbsp; <?= e($producto['nombre']) ?>
    </div>

    <main class="contenedor-detalle detalle-producto">
        <section class="detalle-producto__galeria">
            <img src="../agregar productos/img/<?= e($producto['imagen']) ?>" alt="<?= e($producto['nombre']) ?>">
        </section>

        <section class="detalle-producto__info">
            <h1><?= e($producto['nombre']) ?></h1>
            <div class="detalle-producto__precio">
                <?= '$' . number_format((float)$producto['precio'], 0, ',', '.') ?>
            </div>

            <div class="detalle-producto__meta">
                <?php if (!empty($producto['categoria'])): ?>
                    <span class="chip">Categoría: <?= e($producto['categoria']) ?></span>
                <?php endif; ?>
                <?php if ($producto['stock'] !== null && $producto['stock'] !== ''): ?>
                    <span class="chip">Stock: <?= (int)$producto['stock'] ?></span>
                <?php endif; ?>
                <span class="chip">codigo: <?= (int)$producto['codigoBarras'] ?></span>
            </div>

            <?php if (!empty($producto['descripcion'])): ?>
                <h3>Descripción</h3>
                <p class="detalle-producto__descripcion"><?= e($producto['descripcion']) ?></p>
            <?php endif; ?>

    <div class="acciones">
    <a class="btn btn-primary" 
        href="producto.php?codigo=<?= $producto['codigoBarras'] ?>&agregar=<?= $producto['codigoBarras'] ?>">
        <i class="bi bi-cart-plus-fill"></i> Agregar al carrito</a>
        
                <a class="btn btn-outline" href="productos.php"><i class="bi bi-arrow-left" style="margin: 5px;"></i>Volver a productos</a>
            </div>
    
        </section>
    </main>

    <div class="contenedor-carrito" style="position: relative; display: inline-block;">

    <a class='flotante' id="carrito" href='pago_productos.php'><i class="bi bi-cart4">
        <?php
$cartCount = 0;
$cartTotal = 0;
if (isset($_SESSION['carrito'])) {
    foreach ($_SESSION['carrito'] as $item) {
        $cartCount += $item['cantidad'];
        $cartTotal += $item['precio'] * $item['cantidad'];
    }
}
?>
<span id="cart-count" style="
            position: absolute; 
            top: -10px; 
            right: -15px; 
            background: red; 
            color: white; 
            border-radius: 50%; 
            padding: 2px 6px; 
            font-size: 12px;
            font-weight: bold;
            "><?= $cartCount ?></span>
        

    </i>
</a>

<div id="carrito-info" class="carrito-info">
    <p><strong>Total:</strong> $<?= number_format($cartTotal, 0, ',', '.') ?></p>
    <a href="vaciar_carrito.php" class="vaciar_carrito">Vaciar carrito</a>
</div>


    </div>
    

    <footer>
        <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
    </footer>
<script src="ocultar.js"></script>
</body>
</html>
