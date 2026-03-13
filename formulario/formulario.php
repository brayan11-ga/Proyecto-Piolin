
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <title>Registro - Supermercado Piolín</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="formulario.css">
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
                    <li class="nav-item"><a class="nav-link" href="../productos/productos.php">Productos</a></li>
                    <?php if (isset($_SESSION['id'])): ?>
                        <li class="nav-item"><a class="nav-link" href="../productos/mis_compras.php">Mis compras</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link active" href="../formulario/formulario.php">Registro</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="../acerca/acerca.php">Acerca de</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section class="principalregistro">
        <div class="contenedor">
            <div class="formulario">
                
                <div style="text-align: center; margin-bottom: 10px;">
                    <img src="../img/login.png" alt="Logo" width="100px" class="logoregistro">
                </div>

                <h1>Registro</h1>

                <form action="conexion.php" method="post">
                    
                    <div class="input-contenedor">
                        <input type="text" name="numero" required>
                        <label>Número de Identificación</label>
                    </div>
                    
                    <div class="input-contenedor">
                        <input type="text" name="nombres" required>
                        <label>Nombres</label>
                    </div>
                    
                    <div class="input-contenedor">
                        <input type="text" name="apellidos" required>
                        <label>Apellidos</label>
                    </div>
                    
                    <div class="input-contenedor">
                        <input type="tel" name="telefono" required pattern="\d{10}" minlength="10" maxlength="10">
                        <label>Teléfono</label>
                    </div>
                    
                    <div class="input-contenedor">
                        <input type="email" name="correo" required>
                        <label>Correo Electrónico</label>
                    </div>
                    
                    <div class="input-contenedor">
                        <input type="password" name="contraseña" required>
                        <label>Contraseña</label>
                    </div>
                    
                    <input type="submit" value="Registrarse" class="botoningreso" name="guardar">
                    
                    <div class="registrar">
                        <p>¿Ya tienes cuenta? <a href="../ingresar/ingresar.php">Inicia sesión</a></p>
                    </div>

                </form>
            </div>
        </div>
    </section>

<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    
</body>
</html>