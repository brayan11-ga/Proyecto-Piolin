<?php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Si viene de insertar
$mensaje = "";
if (isset($_GET['verificar']) && $_GET['verificar'] == "insertar") {
    $mensaje = "✅ Producto guardado con éxito.";
}

// Traer todos los productos
$sql = "SELECT * FROM producto ORDER BY id DESC"; // Ordenado por último insertado
$resultado = mysqli_query($conexion, $sql);

$sql = "SELECT * FROM producto";
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
    <title>Gestionar Productos</title>
    <style>
        .mensaje {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 15px auto;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            width: 90%;
            max-width: 800px;
            text-align: center;
            font-weight: bold;
        }
    </style>
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

    <div class="productos">
        <div class="item">
            <img src="../img/arroz.jpg" alt="Arroz boluga">
            <div class="info-producto">
                <h2>Arroz Boluga</h2>
                <p class="precio">
                    $2800
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>
        

        <div class="item">
            <img src="../img/tomate.jpg" alt="Tomate">
            <div class="info-producto">
                <h2>Tomate</h2>
                <p class="precio">
                    Libra x $3200
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>
        

        <div class="item">
            <img src="../img/sal.jpg" alt="Sal Refisal">
            <div class="info-producto">
                <h2>Sal de mesa</h2>
                <p class="precio">
                    $2700
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>
        

        <div class="item">
            <img src="../img/leche.jpg" alt="Arroz boluga">
            <div class="info-producto">
                <h2>Leche Alqueria</h2>
                <p class="precio">
                    $5800
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>
        

        <div class="item">
            <img src="../img/aguila.jpg" alt="Arroz boluga">
            <div class="info-producto">
                <h2>Cerveza en lata Aguila</h2>
                <p class="precio">
                    $19000
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>
        

        <div class="item">
            <img src="../img/jabon.avif" alt="Arroz boluga">
            <div class="info-producto">
                <h2>Jabón Protex</h2>
                <p class="precio">
                    $8800
                </p>
                <button class="btn-editar">Editar Producto</button>
                <button class="btn-eliminar">Eliminar Producto</button>
            </div>
        </div>

         <?php while($fila = mysqli_fetch_assoc($resultado)): ?>
            <div class="item">
                <img src="../agregar productos/img/<?= $fila['imagen'] ?>" alt="<?= $fila['nombre'] ?>">
                <div class="info-producto">
                    <h2><?= $fila['nombre'] ?></h2>
                    <p class="precio"><?= number_format($fila['precio'], 0, ',', '.') ?></p>

                    <a class="btn-editar" href="formulario_editar.php?codigoBarras=<?= urldecode($fila['codigoBarras']) ?>" > Editar Producto </a>
         
            

                    <a href="eliminar.php?codigoBarras=<?= $fila['codigoBarras'] ?>" 
                   class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">Eliminar Producto
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    </div>

     

    <button class="btn-agregar">
        
        <a href="../agregar productos/agregarproductos.php"><i class="bi bi-cloud-upload"></i>Agregar Productos</a>
        </button>
</section>




<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>