<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso</title>
    <link rel="stylesheet" href="../ingresar/estiloingreso.css">
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
  </head>

<body class="bg-light">

 <?php
session_start();

if (isset($_POST['ingresar'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena']; 

    $conn = mysqli_connect("localhost", "root", "", "proyecto_ventas");

    if (!$conn) {
        die("Error en la conexión: " . mysqli_connect_error());
    }


    $sqlEmpleado = "SELECT identificacion, nombres
                    FROM empleado 
                    WHERE email = '$correo' AND contraseña = '$contrasena'";
    $resultadoEmpleado = mysqli_query($conn, $sqlEmpleado);

    if (mysqli_num_rows($resultadoEmpleado) > 0) {
        $row = mysqli_fetch_assoc($resultadoEmpleado);


        $_SESSION['id'] = $row['identificacion'];
        $_SESSION['nombres'] = $row['nombres'];
        $_SESSION['rol'] = "empleado";
        $_SESSION['logueado'] = true;

        echo "<div class='alert alert-success' role='alert'>
                Bienvenido administrador {$row['nombres']}
              </div>";

        echo "<script>
                setTimeout(function(){
                  window.location.href = '../home/home.php';
                }, 2000);
              </script>";
        exit;
    }


    $sqlCliente = "SELECT numeroIdentificacion, nombres, apellidos 
                   FROM cliente 
                   WHERE correo = '$correo' AND contraseña = '$contrasena'";
    $resultadoCliente = mysqli_query($conn, $sqlCliente);

    if (mysqli_num_rows($resultadoCliente) > 0) {
        $row = mysqli_fetch_assoc($resultadoCliente);

        // Guardar en sesión como cliente
        $_SESSION['id'] = $row['numeroIdentificacion'];
        $_SESSION['nombres'] = $row['nombres'];
        $_SESSION['apellidos'] = $row['apellidos'];
        $_SESSION['rol'] = "cliente";
        $_SESSION['logueado'] = true;

        echo "<div class='alert alert-success' role='alert'>
                Bienvenido cliente {$row['nombres']}
              </div>";

        echo "<script>
                setTimeout(function(){
                  window.location.href = '../productos/productos.php';
                }, 2000);
              </script>";
        exit;
    }


    echo "<div class='alert alert-danger'>
            Verifique su usuario y contraseña
          </div>";
}
?>

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

<section>
        <a href="../index.php" class="volver"><img src="../img/regre.png" alt="" width="50px" height="50px"></a>
  <div class="contenedor">
    <div class="formulario">
      
        <form action="ingresar.php" method="POST">
            <h1>Iniciar Sesión</h1>
            <div class="input-contenedor">
                <i class="bi bi-envelope-at-fill"></i>
                <input type="email" required name="correo">
                <label for="#">Email</label>
            </div>

            <div class="input-contenedor">
                <i class="bi bi-lock-fill"></i>
                <input type="password" required name="contrasena">
                <label for="#">Contraseña</label>
            </div>

            <div class="olvidar">
                <label for="#">
                    <input type="checkbox">Recordar.
                    <a href="#">Olvide mi Contraseña</a>
                </label>
            </div>

            <div class="ini">
            <input type="submit" value="Iniciar Sesión" class="botoningreso" name="ingresar">
          
        </div>
        </form>

        

        <div class="registrar">
            <p>No tengo cuenta. <a href="../formulario/formulario.php">Crear una</a></p>
        </div>

    </div>
  </div>
</section>
<footer>
  <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  </body>
  
</html>

