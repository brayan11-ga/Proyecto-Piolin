<?php
$page_title = 'Ingresar - Supermercado Piolín';
require_once '../includes/header.php';

$mensaje = "";
$tipo_mensaje = "";
$redireccion = "";

if (isset($_POST['ingresar'])) {
    require_once '../config/conexion.php';
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $contrasena = mysqli_real_escape_string($conexion, $_POST['contrasena']); 

    // Buscar en empleados
    $sqlEmpleado = "SELECT identificacion, nombres FROM empleado 
                    WHERE email = '$correo' AND contraseña = '$contrasena'";
    $resultadoEmpleado = mysqli_query($conexion, $sqlEmpleado);

    if ($resultadoEmpleado && mysqli_num_rows($resultadoEmpleado) > 0) {
        $row = mysqli_fetch_assoc($resultadoEmpleado);
        $_SESSION['id'] = $row['identificacion'];
        $_SESSION['nombres'] = $row['nombres'];
        $_SESSION['rol'] = "empleado";
        $_SESSION['logueado'] = true;

        $mensaje = "Bienvenido, Administrador {$row['nombres']}. Redirigiendo...";
        $tipo_mensaje = "success";
        $redireccion = "../admin/index.php";

    } else {
        // Buscar en clientes
        $sqlCliente = "SELECT numeroIdentificacion, nombres, apellidos FROM cliente 
                       WHERE correo = '$correo' AND contraseña = '$contrasena'";
        $resultadoCliente = mysqli_query($conexion, $sqlCliente);

        if ($resultadoCliente && mysqli_num_rows($resultadoCliente) > 0) {
            $row = mysqli_fetch_assoc($resultadoCliente);
            $_SESSION['id'] = $row['numeroIdentificacion'];
            $_SESSION['nombres'] = $row['nombres'];
            $_SESSION['apellidos'] = $row['apellidos'];
            $_SESSION['rol'] = "cliente";
            $_SESSION['logueado'] = true;

            $mensaje = "Bienvenido, Cliente {$row['nombres']}. Redirigiendo...";
            $tipo_mensaje = "success";
            $redireccion = "../productos/productos.php";
        } else {
            $mensaje = "Usuario o contraseña incorrectos. Verifica tus datos.";
            $tipo_mensaje = "danger";
        }
    }
}
?>

<section class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        
        <?php if ($mensaje != ""): ?>
            <div class="alert alert-<?= $tipo_mensaje ?> alert-dismissible fade show shadow-sm text-center mb-4" role="alert">
                <i class="bi bi-<?= $tipo_mensaje == 'success' ? 'check-circle' : 'exclamation-circle' ?>-fill me-2 fs-5 align-middle"></i>
                <span class="align-middle"><?= $mensaje ?></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            
            <?php if ($redireccion != ""): ?>
            <script>
                setTimeout(function(){
                  window.location.href = '<?= $redireccion ?>';
                }, 1500);
            </script>
            <?php endif; ?>
        <?php endif; ?>

        <form action="ingresar.php" method="POST" class="auth-container border-0 rounded-4 overflow-hidden p-0">
            <div class="bg-primary text-white text-center py-4 px-3" style="background: linear-gradient(135deg, var(--dark-nav) 0%, #111 100%) !important;">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-circle text-dark fs-1"></i>
                </div>
                <h2 class="fw-bold m-0" style="font-family: 'Montserrat', sans-serif;">Iniciar Sesión</h2>
                <p class="text-white-50 mt-1 mb-0">Accede a tu cuenta de Supermercado Piolín</p>
            </div>

            <div class="p-4 p-md-5 bg-white">
                <div class="mb-3 text-start">
                    <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" class="form-control bg-light border-start-0 ps-0" required name="correo" placeholder="ejemplo@correo.com">
                    </div>
                </div>

                <div class="mb-4 text-start">
                    <div class="d-flex justify-content-between">
                        <label class="form-label fw-bold text-secondary small">Contraseña</label>
                        <a href="#" class="text-danger small text-decoration-none fw-semibold">¿Olvidaste tu contraseña?</a>
                    </div>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control bg-light border-start-0 ps-0" required name="contrasena" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fs-5 text-uppercase fw-bold rounded-pill shadow" name="ingresar">Entrar a mi cuenta</button>
                
                <div class="mt-4 text-center border-top pt-4">
                    <p class="mb-1 text-muted">¿Eres nuevo por aquí?</p>
                    <a href="../formulario/formulario.php" class="btn btn-outline-danger rounded-pill px-4 fw-bold">Crear una Cuenta Nueva</a>
                </div>
            </div>
        </form>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>
