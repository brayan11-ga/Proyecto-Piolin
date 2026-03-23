<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/PROYECTO';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $base_url ?>/assets/img/favicon-32x32.png"/>
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'Supermercado Piolín' ?></title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom Modern CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/main.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <header class="main-header py-3 shadow-sm position-relative z-3" style="background-color: var(--primary);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-md-4 text-start">
                    <a href="<?= $base_url ?>/index.php" class="bg-white d-inline-block rounded p-2 shadow-sm">
                        <img src="<?= $base_url ?>/assets/img/Logo.png" alt="Logo Piolín" class="img-fluid" style="max-height: 65px;">
                    </a>
                </div>
                <div class="col-md-4 d-none d-md-block text-center">
                    <h1 class="brand-title m-0 fw-bold" style="font-family: 'Montserrat', sans-serif; color: white; -webkit-text-fill-color: white; background: none;">PIOLÍN</h1>
                </div>
                <div class="col-6 col-md-4 text-end">
                    <?php if (isset($_SESSION['logueado']) && $_SESSION['logueado'] === true): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle rounded-pill px-4" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i><?= htmlspecialchars($_SESSION['nombres'] ?? 'Usuario') ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item text-danger fw-semibold" href="<?= $base_url ?>/cerrar_sesion/cerrar_sesion.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?= $base_url ?>/ingresar/ingresar.php" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm text-danger">Entrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top shadow-sm">
        <div class="container">
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav text-center fw-semibold">
                    <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/productos/productos.php">Productos</a></li>
                    
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'cliente'): ?>
                        <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/productos/mis_compras.php">Mis compras</a></li>
                    <?php elseif(!isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/formulario/formulario.php">Registro</a></li>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'empleado'): ?>
                        <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/gestion_productos/gestionar_transportadores.php">Transportadores</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/gestion_productos/gestioproductos.php">Gestión Productos</a></li>
                    <?php endif; ?>
                    
                    <li class="nav-item"><a class="nav-link px-3" href="<?= $base_url ?>/acerca/acerca.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1 pb-5 pt-4">
