    </div> <!-- Cierra admin-content -->
</div> <!-- Cierra flex div -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Lógica para togglear el Sidebar en dispositivos móviles
    document.addEventListener("DOMContentLoaded", function() {
        const toggleBtn = document.getElementById("toggleSidebar");
        const closeBtn = document.getElementById("closeSidebar");
        const sidebar = document.getElementById("sidebarMenu");
        const content = document.getElementById("mainContent");
        const backdrop = document.getElementById("sidebarBackdrop");

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function() {
                // Si es móbil (el margin-left original es -280px via Media Query), usamos "show"
                if (window.innerWidth < 992) {
                    sidebar.classList.add("show");
                    backdrop.classList.add("show");
                } else {
                    // Si es Desktop, usamos el toggle manual
                    sidebar.classList.toggle("collapsed");
                    content.classList.toggle("expanded");
                }
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener("click", function() {
                sidebar.classList.remove("show");
                backdrop.classList.remove("show");
            });
        }

        if (backdrop) {
            backdrop.addEventListener("click", function() {
                sidebar.classList.remove("show");
                backdrop.classList.remove("show");
            });
        }
        
        // Agregar "active" a los links de la sidebar basado en la URL
        const currentLocation = location.href;
        const navLinks = document.querySelectorAll('.admin-nav-link');
        navLinks.forEach(link => {
            if(link.href === currentLocation) {
                link.classList.add('active');
            }
        });
    });
</script>
</body>
</html>
