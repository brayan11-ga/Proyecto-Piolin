<?php
var_dump($_GET);
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!isset($_GET['idTransportador'])) {
    die("ID de transportador no especificado.");
}

$id = intval($_GET['idTransportador']);

$sql = "SELECT * FROM transportador WHERE idTransportador = $id";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado || mysqli_num_rows($resultado) === 0) {
    die("Transportador no encontrado.");
}

$fila = mysqli_fetch_assoc($resultado);
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Editar Transportador</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../estilos/estiloindex.css">
  <link rel="stylesheet" href="../agregar productos/agregarproductos.css">
  <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
  
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

 
  <h1 class="tituloformulario">Editar Transportador</h1>

 
  <div class="frm">

    <form action="actualizar_transportador.php" method="post" class="formularioProducto">

      <input type="hidden" name="idTransportador" value="<?= $fila['idTransportador'] ?>">

      <label>Nombre</label>
      <input type="text" name="nombre" value="<?= htmlspecialchars($fila['nombre']) ?>" required>

      <label>Teléfono</label>
      <input type="text" name="telefono" value="<?= htmlspecialchars($fila['telefono']) ?>">

      <label>Correo</label>
      <input type="email" name="correo" value="<?= htmlspecialchars($fila['correo']) ?>">

      <label>Vehículo</label>
      <input type="text" name="vehiculo" value="<?= htmlspecialchars($fila['vehiculo']) ?>">

      <label>Placa</label>
      <input type="text" name="placa" value="<?= htmlspecialchars($fila['placa']) ?>">

      <label>Calificación</label>
      <input type="text" name="calificacion" value="<?= htmlspecialchars($fila['calificacion']) ?>">

      <!-- botón con clase -->
      <button type="submit" class="botonguardar">Actualizar</button>
    </form>
  </div>
   <footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

</body>
</html>
