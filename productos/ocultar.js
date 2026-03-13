const carrito = document.getElementById("carrito");
const carritoInfo = document.getElementById("carrito-info");

carrito.addEventListener("mouseenter", () => {
    carritoInfo.style.display = "block";
});

carrito.addEventListener("mouseleave", () => {
    carritoInfo.style.display = "none";
});
