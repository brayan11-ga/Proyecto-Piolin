<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$base_url = '/PROYECTO';

// Validar credenciales y roles para ver este layout
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'empleado') {
    header("Location: $base_url/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="<?= $base_url ?>/assets/img/favicon-32x32.png"/>
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard Admin' ?></title>
    
    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom CSS Base -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/main.css">
    
    <style>
        .admin-sidebar {
            width: 280px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--dark-nav) 0%, #111 100%);
            color: #fff;
            transition: all 0.3s ease;
        }
        .admin-sidebar.collapsed {
            margin-left: -280px !important;
        }
        .admin-content {
            margin-left: 280px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            width: calc(100% - 280px);
            transition: all 0.3s ease;
        }
        .admin-content.expanded {
            margin-left: 0 !important;
            width: 100% !important;
        }
        .admin-nav-link {
            color: rgba(255,255,255,0.7);
            padding: 10px 20px;
            transition: all 0.3s;
            border-radius: 8px;
            margin-bottom: 5px;
            font-weight: 500;
        }
        .admin-nav-link:hover, .admin-nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.1);
            transform: translateX(3px);
            font-weight: 600;
        }
        
        .admin-nav-link.active {
            border-left: 4px solid var(--primary);
            border-radius: 0 8px 8px 0;
            background: rgba(227, 7, 18, 0.15); /* light primary tint */
        }
        @media (max-width: 991px) {
            .admin-sidebar {
                margin-left: -280px;
                position: absolute;
            }
            .admin-sidebar.show {
                margin-left: 0;
                z-index: 1060;
            }
            .admin-content {
                margin-left: 0;
                width: 100%;
            }
            .sidebar-backdrop {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5); z-index: 1050; display: none;
            }
            .sidebar-backdrop.show { display: block; }
        }
    </style>
</head>
<body class="bg-light">

<div class="d-flex w-100 position-relative">
    
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- Sidebar Dashboard -->
    <div class="admin-sidebar shadow position-fixed h-100 z-3 p-3 flex-column d-flex" id="sidebarMenu">
        <div class="d-flex align-items-center mb-4 px-2 mt-2">
            <img src="<?= $base_url ?>/assets/img/Logo.png" alt="Logo" class="rounded bg-white p-1 me-2 shadow-sm" style="max-height: 40px;">
            <span class="fs-4 fw-bold" style="font-family: 'Montserrat'; color: #fff;">PIOLÍN<span class="text-danger">.</span></span>
            <button class="btn btn-outline-light d-lg-none ms-auto border-0" id="closeSidebar"><i class="bi bi-x-lg"></i></button>
        </div>
        
        <hr class="text-white-50 mt-0 mb-3 mx-2 opacity-25">
        
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="<?= $base_url ?>/admin/index.php" class="nav-link admin-nav-link text-decoration-none">
                    <i class="bi bi-speedometer2 me-2"></i> Tablero Principal
                </a>
            </li>
            
            <li class="nav-item text-white-50 small text-uppercase mt-4 mb-2 ps-3 fw-bold opacity-75" style="letter-spacing: 1px;">Gestión de Tienda</li>
            <li>
                <a href="<?= $base_url ?>/gestion_productos/gestioproductos.php" class="nav-link admin-nav-link text-decoration-none">
                    <i class="bi bi-box-seam me-2"></i> Inventario de Productos
                </a>
            </li>
            
            <li class="nav-item text-white-50 small text-uppercase mt-4 mb-2 ps-3 fw-bold opacity-75" style="letter-spacing: 1px;">Logística</li>
            <li>
                <a href="<?= $base_url ?>/gestion_productos/gestionar_transportadores.php" class="nav-link admin-nav-link text-decoration-none">
                    <i class="bi bi-truck me-2"></i> Transportadores
                </a>
            </li>
            
            <li class="nav-item text-white-50 small text-uppercase mt-4 mb-2 ps-3 fw-bold opacity-75" style="letter-spacing: 1px;">Público</li>
            <li>
                <a href="<?= $base_url ?>/index.php" class="nav-link admin-nav-link text-decoration-none">
                    <i class="bi bi-shop me-2"></i> Ver Tienda
                </a>
            </li>
        </ul>
        
        <hr class="text-white-50 my-3 mx-2 opacity-25">
        <div class="dropdown px-2 mb-2">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle w-100 rounded p-2" style="background: rgba(255,255,255,0.05);" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white shadow-sm" style="width: 32px; height: 32px;"><i class="bi bi-person-fill"></i></div>
                <strong class="text-truncate"><?= htmlspecialchars($_SESSION['nombres'] ?? 'Administrador') ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow w-100 border-0 mt-1">
                <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Ajustes</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger fw-bold" href="<?= $base_url ?>/cerrar_sesion/cerrar_sesion.php"><i class="bi bi-box-arrow-right me-2"></i>Cerrar sesión</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="admin-content bg-light" id="mainContent">
        <!-- Top Navbar para Mobile/Desktop utils -->
        <header class="p-3 bg-white shadow-sm d-flex align-items-center justify-content-between z-2 sticky-top border-bottom">
            <div class="d-flex align-items-center">
                <button class="btn btn-light me-3 border-0 shadow-sm" id="toggleSidebar">
                    <i class="bi bi-list fs-4"></i>
                </button>
                <div class="text-muted d-none d-md-block fs-5 ps-2 border-start ps-3"><i class="bi bi-clock me-2"></i> <?= date('d M Y') ?></div>
            </div>
            <div class="d-flex align-items-center text-muted">
                <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm d-none d-sm-inline-block"><i class="bi bi-shield-lock-fill me-1"></i> Entorno de Administración Secure</span>
            </div>
        </header>
