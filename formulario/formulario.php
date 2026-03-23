<?php
$page_title = 'Registro - Supermercado Piolín';
require_once '../includes/header.php';
?>

<section class="container py-5 my-4">
  <div class="row justify-content-center">
    <div class="col-md-9 col-lg-7">
        <form action="insertar_cliente.php" method="POST" class="auth-container border-0 rounded-4 overflow-hidden p-0">
            <div class="bg-danger text-white text-center py-4 px-3" style="background: linear-gradient(135deg, var(--primary) 0%, #b0050d 100%);">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px;">
                    <i class="bi bi-person-plus-fill text-danger fs-1"></i>
                </div>
                <h2 class="fw-bold m-0" style="font-family: 'Montserrat', sans-serif;">Registro de Cliente</h2>
                <p class="text-white-50 mt-1 mb-0">Únete a Supermercado Piolín y empieza a ahorrar</p>
            </div>
            
            <div class="p-4 p-md-5 bg-white">
                <div class="row text-start g-3">
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold text-secondary small">Nombres</label>
                        <input type="text" class="form-control form-control-lg bg-light" required name="nombres" placeholder="Tus nombres">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold text-secondary small">Apellidos</label>
                        <input type="text" class="form-control form-control-lg bg-light" required name="apellidos" placeholder="Tus apellidos">
                    </div>
                </div>

                <div class="mb-3 mt-2 text-start">
                    <label class="form-label fw-bold text-secondary small">Número de Identificación</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person-badge"></i></span>
                        <input type="number" class="form-control bg-light border-start-0 ps-0" required name="numero" placeholder="Ej: 1000000000">
                    </div>
                </div>

                <div class="row text-start g-3 mt-1">
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold text-secondary small">Teléfono Móvil</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-telephone-fill"></i></span>
                            <input type="tel" class="form-control bg-light border-start-0 ps-0" required name="telefono" pattern="\d{10}" minlength="10" maxlength="10" placeholder="10 dígitos">
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label fw-bold text-secondary small">Correo Electrónico</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0" required name="correo" placeholder="ejemplo@correo.com">
                        </div>
                    </div>
                </div>

                <div class="mb-4 mt-2 text-start">
                    <label class="form-label fw-bold text-secondary small">Contraseña</label>
                    <div class="input-group input-group-lg">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" class="form-control bg-light border-start-0 ps-0" required name="contraseña" placeholder="••••••••">
                    </div>
                </div>
                
                <div class="form-check mb-4 text-start">
                    <input class="form-check-input" type="checkbox" value="" id="terminos" required>
                    <label class="form-check-label text-muted small" for="terminos">
                        Acepto los <a href="#" class="text-danger text-decoration-none">términos y condiciones</a> y la política de privacidad.
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-3 fs-5 text-uppercase fw-bold rounded-pill shadow" name="guardar">Crear Mi Cuenta</button>
                
                <div class="mt-4 text-center border-top pt-4">
                    <p class="mb-1 text-muted">¿Ya tienes cuenta?</p>
                    <a href="../ingresar/ingresar.php" class="btn btn-outline-dark rounded-pill px-4 fw-bold">Inicia Sesión Aquí</a>
                </div>
            </div>
        </form>
    </div>
  </div>
</section>

<?php require_once '../includes/footer.php'; ?>
