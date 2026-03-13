<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="estiloacerca.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acerca de</title>
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
                    <li class="nav-item"><a class="nav-link" href="productos.php">Productos</a></li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="mis_compras.php">Mis compras</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="../formulario/formulario.php">Registro</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link active" href="../acerca/acerca.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>

<section>

<div class="card">
    <div class="content">
        <div class="img">
            <img src="../img/Logo.png" alt="">
        </div>
        <h2>Supermercado Piolin</h2>
        <p> Es una plataforma web pensada para facilitar tus compras del día a día desde la comodidad de tu hogar. Ofrecemos una amplia variedad de productos de uso cotidiano, desde alimentos y bebidas hasta artículos de aseo y limpieza. Nuestro objetivo es brindarte una experiencia de compra rápida, segura y eficiente, con información clara de cada producto y un sistema de pedidos sencillo.</p>
    </div>
</div>
    <div class="links">
    <a href="#"><i class="bi bi-facebook"></i></a>
    <a href="#"><i class="bi bi-whatsapp"></i></a>
    <a href="#"><i class="bi bi-envelope-at-fill"></i></a>
    <a href=" https://brayan11-ga.github.io/Supermercado-Piolin/"><i class="bi bi-github"></i></a>
    </div>
</div>
</section>
<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    
</body>
</html>