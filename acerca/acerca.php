<?php
$page_title = 'Acerca de - Supermercado Piolín';
require_once '../includes/header.php';
?>

<section class="container py-5 my-md-5">
    <div class="row align-items-center bg-white rounded-5 shadow-lg overflow-hidden flex-row-reverse border-0">
        <div class="col-lg-6 p-0 position-relative h-100">
            <img src="../assets/img/arroz.jpg" alt="Acerca de Supermercado Piolín" class="img-fluid w-100 h-100 object-fit-cover" style="min-height: 450px;">
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);"></div>
        </div>
        <div class="col-lg-6 p-5 p-xl-6 text-center text-lg-start position-relative z-1" style="margin-right: -20px;">
            <div class="mb-4">
                <div class="d-inline-block bg-white p-2 rounded-3 shadow-sm mb-4">
                    <img src="../assets/img/Logo.png" alt="Logo" class="img-fluid" style="height: 60px;">
                </div>
                <h2 class="display-5 fw-bold text-dark" style="font-family: 'Montserrat', sans-serif;">Sobre Nosotros</h2>
                <div class="bg-danger mt-3" style="height: 5px; width: 70px; margin: 0 auto;" class="d-lg-none"></div>
                <div class="bg-danger mt-3 d-none d-lg-block rounded" style="height: 5px; width: 70px;"></div>
            </div>
            <p class="lead text-muted lh-lg mb-4 fs-5">
                <strong>Supermercado Piolín</strong> es una plataforma web pensada para facilitar tus compras del día a día desde la comodidad de tu hogar.<br><br>
                Ofrecemos una amplia variedad de productos de uso cotidiano, desde alimentos y bebidas hasta artículos de aseo y limpieza. Nuestro principal objetivo es brindarte una experiencia de compra rápida, segura y sumamente eficiente.
            </p>
            
            <div class="d-flex justify-content-center justify-content-lg-start gap-3 mt-5">
                <a href="#" class="btn btn-outline-primary rounded-circle d-flex align-items-center justify-content-center text-decoration-none transition-transform" style="width: 55px; height: 55px; font-size: 1.3rem;">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="btn btn-outline-success rounded-circle d-flex align-items-center justify-content-center text-decoration-none transition-transform" style="width: 55px; height: 55px; font-size: 1.3rem;">
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a href="mailto:contacto@piolin.com" class="btn btn-outline-danger rounded-circle d-flex align-items-center justify-content-center text-decoration-none transition-transform" style="width: 55px; height: 55px; font-size: 1.3rem;">
                    <i class="bi bi-envelope-at-fill"></i>
                </a>
                <a href="https://brayan11-ga.github.io/Supermercado-Piolin/" target="_blank" class="btn btn-outline-dark rounded-circle d-flex align-items-center justify-content-center text-decoration-none transition-transform" style="width: 55px; height: 55px; font-size: 1.3rem;">
                    <i class="bi bi-github"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
