<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="./img/favicon-32x32.png"/>
    <title>Supermercado Piolín - Tu Tienda de Confianza</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./estilos/estiloindex.css">
</head>
<body>

    <header class="main-header py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-4 text-start">
                    <img src="img/Logo.png" alt="Logo Piolin" class="img-fluid header-logo">
                </div>
                <div class="col-md-4 d-none d-md-block text-center">
                    <h1 class="brand-title m-0">PIOLÍN</h1>
                </div>
                <div class="col-6 col-md-4 text-end">
                    <a href="./ingresar/ingresar.php" class="btn btn-outline-light login-btn">INGRESAR</a>
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
                    <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="./productos/productos.php">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="./formulario/formulario.php">Registro</a></li>
                    <li class="nav-item"><a class="nav-link" href="./acerca/acerca.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="container py-5">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold text-dark">¡Bienvenido a Supermercado Piolín!</h2>
                <p class="lead text-muted">Calidad y ahorro directo a tu hogar.</p>
            </div>

<h3 class="mb-4 text-center text-uppercase fw-bold text-danger">Ofertas Destacadas</h3>

<div class="row g-4">
    
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0 shadow-sm product-card">
            <img src="img/arroz.jpg" class="card-img-top p-3" alt="Producto">
            <div class="card-body text-center">
                <h5 class="card-title">Promoción 1</h5>
                <p class="card-text text-danger fs-4 fw-bold">$20.000</p>
                <a href="productos/productos.php" class="btn btn-danger w-100">Ver Detalles</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card h-100 border-0 shadow-sm product-card">
            <img src="img/aguila.jpg" class="card-img-top p-3" alt="Producto">
            <div class="card-body text-center">
                <h5 class="card-title">Promoción 2</h5>
                <p class="card-text text-danger fs-4 fw-bold">$15.000</p>
                <a href="productos/productos.php" class="btn btn-danger w-100">Ver Detalles</a>
            </div>
        </div>
    </div>

    </div>
                
        </section>

        <section class="hero-carousel">
            <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="img/piolin.png" class="d-block w-100 h-custom" alt="Oferta 1">
                    </div>
                    <div class="carousel-item">
                        <img src="img/piolin2.png" class="d-block w-100 h-custom" alt="Oferta 2">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </section>      
    </main>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2026 Supermercado Piolín. Todos los derechos reservados.</p>
            <small class="text-muted">Bogotá, Colombia</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>