<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Registrar Conductor</title>
  <link rel="stylesheet" href="../estilos/estiloindex.css">
  <link rel="stylesheet" href="../agregar productos/agregarproductos.css"> <!-- aquí pones tu CSS -->
</head>
<body>

<header>
      <div class="logo">
        <img src="../img/Logo.png" width="500px" height="150px">
        
    </div>

        <div class="titulo">
            <h1 class="textotitulo">Administrador</h1>
        </div>
        
        <div class="boton">
            <a href="../ingresar/ingresar.php" class="ingreso">SALIR</a>
        </div>
    </header>

</header>
<nav>
  <ul>
    <ul>
        <li><a href="../home/home.php">Inicio</a></li>
        <li><a href="gestioproductos.php">Gestionar Productos</a></li>
        <li><a href="Gestionar_transportadores.php">Gestionar transportadores</a></li>
        <li><a href="#">Gestionar Pedidos</a></li>
        <li><a href="#">Reporte</a></li>
        <li><a href="#">Configuración</a></li>
    </ul>
</nav>


  <!-- Título -->
  <h1 class="tituloformulario">Registrar / Editar Conductor</h1>

  <!-- Contenedor centrado -->
  <div class="frm">
    <!-- Caja del formulario -->
    <form class="formularioProducto" action="conexión.php" method="post">

      <label>Nombre</label>
      <input type="text" name="nombre" required maxlength="100">

      <label>Teléfono</label>
      <input type="text" name="telefono" maxlength="50">

      <label>Correo</label>
      <input type="email" name="correo" required>

      <label>Vehículo</label>
      <input type="text" name="vehiculo">

      <label>Placa</label>
      <input type="text" name="placa" maxlength="20">

      <label>Calificación</label>
  <div class="estrellas">
  <input type="radio" id="estrella5" name="calificacion" value="5">
  <label for="estrella5" title="5 estrellas">★</label>

  <input type="radio" id="estrella4" name="calificacion" value="4">
  <label for="estrella4" title="4 estrellas">★</label>

  <input type="radio" id="estrella3" name="calificacion" value="3">
  <label for="estrella3" title="3 estrellas">★</label>

  <input type="radio" id="estrella2" name="calificacion" value="2">
  <label for="estrella2" title="2 estrellas">★</label>

  <input type="radio" id="estrella1" name="calificacion" value="1">
  <label for="estrella1" title="1 estrella">★</label>
</div>

      <!-- Botón guardar -->
      <button type="submit" class="botonguardar">
        Guardar Conductor
      </button>
    </form>
  </div>

  <footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
