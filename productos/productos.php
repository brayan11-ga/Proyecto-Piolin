<?php
session_start();
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}


$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ Producto guardado con éxito.";
}

// Traer todos los productos
$sql = "SELECT * FROM producto ORDER BY id DESC"; // Ordenado por último insertado
$sql = "SELECT * FROM producto";
$resultado = mysqli_query($conexion, $sql);
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <title>Productos - Supermercado Piolín</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="estilosproductos.css">
</head>
<body class="bg-light">

    <header class="main-header py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-4 text-start">
                    <img src="../img/Logo.png" alt="Logo Piolin" class="img-fluid header-logo">
                </div>
                <div class="col-md-4 d-none d-md-block text-center">
                    <h1 class="brand-title m-0">PIOLÍN</h1>
                </div>
                <div class="col-6 col-md-4 text-end">
                    <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                        <a href="../cerrar_sesion/cerrar_sesion.php" class="btn btn-outline-light login-btn">SALIR</a>
                    <?php else: ?>
                        <a href="../ingresar/ingresar.php" class="btn btn-outline-light login-btn">ENTRAR</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="productos.php">Productos</a></li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="mis_compras.php">Mis compras</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../formulario/formulario.php">Registro</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="../acerca/acerca.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <h2 class="text-center mb-5 text-uppercase fw-bold text-danger">Catálogo de Productos</h2>
        
        <?php if($mensaje != ""): ?>
            <div class="alert alert-success text-center"><?= $mensaje ?></div>
        <?php endif; ?>

        <div class="row g-4">
            

            <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm product-card border-0">
                    <div class="img-container">
                        <img src="../agregar productos/img/<?= $fila['imagen'] ?>" class="card-img-top producto-img" alt="<?= $fila['nombre'] ?>">
                    </div>
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title fw-bold"><?= $fila['nombre'] ?></h5>
                        <p class="card-text text-danger fs-5 fw-bold mt-auto">$<?= number_format($fila['precio'], 0, ',', '.') ?></p>
                        
                        <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                            <a href="producto.php?codigo=<?= $fila['codigoBarras'] ?>" class="btn btn-comprar w-100 mt-2">Agregar producto</a>
                        <?php else: ?>
                            <a href="../ingresar/ingresar.php" class="btn btn-outline-dark w-100 mt-2"><small>Inicia sesión para comprar</small></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>

        </div>
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <p class="mb-0">&copy; 2026 Supermercado Piolín. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>