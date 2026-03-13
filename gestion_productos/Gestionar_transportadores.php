<?php

$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Si viene de insertar
$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ conductor registrado con éxito.";
}

// Traer todos los productos
$sql = "SELECT * FROM transportador ORDER BY idTransportador DESC"; // Ordenado por último insertado
$resultado = mysqli_query($conexion, $sql);

$sql = "SELECT * FROM transportador";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>



<!DOCTYPE html>
<html lang="es">
<head>
    
    <link rel="stylesheet" href="estilohm.css">
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="../productos/estilosproductos.css">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar transportadores</title>
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
            <a href="cerrar_sesión.php" class="ingreso">SALIR</a>
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





<section>
    <?php if ($mensaje != ""): ?>
    <div class="alert alert-success">
        <?php echo $mensaje; ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['mensaje'])): ?>
  <div class="alert alert-success" role="alert">
    <i class="bi bi-check-circle"></i> <?= $_GET['mensaje']; ?>
  </div>
<?php endif; ?>

<div class="transportadores">

<?php while($fila = mysqli_fetch_assoc($resultado)): ?>
  <div class="item">
    <div class="info-producto">
      <h2><?= htmlspecialchars($fila['nombre']) ?></h2>
      <p>📞 <?= htmlspecialchars($fila['telefono']) ?></p>
      <p>✉️ <?= htmlspecialchars($fila['correo']) ?></p>
      <p>🚗 <?= htmlspecialchars($fila['vehiculo']) ?> - <?= htmlspecialchars($fila['placa']) ?></p>
      <p>⭐ Calificación: <?= htmlspecialchars($fila['calificacion']) ?></p>

      <a class="btn-editar" 
     href="editar_transportador.php?idTransportador=<?= $fila['idTransportador'] ?>">
     Editar Transportador
     </a>
    


      <a class="btn-eliminar" href="eliminar_transportador.php?idTransportador=<?= $fila['idTransportador'] ?>"
         onclick="return confirm('¿Seguro que deseas eliminar este transportador?');">Eliminar</a>
    </div>
  </div>
<?php endwhile; ?>
    
</section>

 <button class="btn-agregar">
        
        <a href="../gestion_productos/formulario_transportador.php"><i class="bi bi-cloud-upload"></i>Agregar Transportador</a>
        </button>




<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>