<?php
$conexion = mysqli_connect("localhost", "root", "", "proyecto_ventas");

if (isset($_GET['codigoBarras'])) {
    $codigo = $_GET['codigoBarras'];
    $sql = "SELECT * FROM producto WHERE codigoBarras = '$codigo'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $producto = mysqli_fetch_assoc($resultado);
    } else {
        die("❌ Producto no encontrado.");
    }
} else {
    die("❌ No se recibió código de barras.");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="../agregar productos/agregarproductos.css">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <title>Editar Productos</title>
</head>
<body>

 <header>
        <div class="logo">
            <img src="../img/Logo.png" width="500px" height="150px">
        </div>

        <div class="titulo">
            <h1 class="textotitulo">PIOLIN</h1>
        </div>
        
        <div class="boton">
            <a href="../ingresar/ingresar.php" class="ingreso">INGRESAR</a>
        </div>
    </header>


<nav>
    <ul>
    <li><a href="home.php">Inicio</a></li>
    <li><a href="../gestion_productos/gestioproductos.php">Gestionar Productos</a></li>
    <li><a href="#">Gestionar Pedidos</a></li>
    <li><a href="#">Reporte</a></li>
    <li><a href="#">Configuración</a></li>
    </ul>
</nav>

    <h2 class="tituloformulario">Editar Productos</h2>

<div class="frm">
<form class="formularioProducto" action="editar.php" method="post" enctype="multipart/form-data">

   <label for="nombre">Código de Barras:</label>
  <input type="hidden" id="codigobarras" name="codigobarras"  value="<?php echo $producto['codigoBarras']; ?>">

  <label for="nombre">Nombre del producto:</label>
  <input type="text" id="nombre" name="nombre" required value="<?php echo $producto['nombre']; ?>" >

  <label for="categoria">Categoría:</label>
  <select id="categoria" name="categoria" required>
    <option value="">Seleccione una categoría</option>
    <option value="Frutas y verduras"  <?= $producto['categoria'] == "Frutas y verduras" ? "selected" : "" ?> >🥦 Alimentos frescos</option>
    <option value="Carnes, pescados y proteínas"  <?= $producto['categoria'] == "Carnes, pescados y proteínas" ? "selected" : "" ?> >🥩 Carnes, pescados y proteínas</option>
    <option value="Lácteos y derivados"  <?= $producto['categoria'] == "Lácteos y derivados" ? "selected" : "" ?> >🥛 Lácteos y derivados</option>
    <option value="Panadería"  <?= $producto['categoria'] == "Panadería" ? "selected" : "" ?> >🥖 Panadería y repostería</option>
   <option value="Alimentos"  <?= $producto['categoria'] == "Alimentos" ? "selected" : "" ?> >🥫 Alimentos no perecederos (despensa)</option>
   <option value="Snacks"  <?= $producto['categoria'] == "Snacks" ? "selected" : "" ?> >🍫 Snacks y dulces</option>
   <option value="Bebidas" <?= $producto['categoria'] == "Bebidas" ? "selected" : "" ?> >🥤 Bebidas</option>
   <option value="Congelados" <?= $producto['categoria'] == "Congelados" ? "selected" : "" ?> >🧃 Congelados</option>
   <option value="Productos para bebés" <?= $producto['categoria'] == "Productos para bebés" ? "selected" : "" ?> >🍼 Productos para bebés</option>
   <option value="Higiene Personal" <?= $producto['categoria'] == "Higiene Personal" ? "selected" : "" ?> >🧴 Higiene personal</option>
   <option value="Limpieza personal" <?= $producto['categoria'] == "Limpieza Personal" ? "selected" : "" ?> >🧹 Limpieza del hogar</option>
   <option value="Mascota" <?= $producto['categoria'] == "Mascota" ? "selected" : "" ?>  >🐶 Mascotas</option>

  

  <label for="precio">Precio:</label>
  <input type="number" id="precio" name="precio" step="0.01" min="0" required value="<?= $producto['precio'] ?>">

  <label for="stock">Cantidad en stock:</label>
  <input type="number" id="stock" name="stock" min="0" required value="<?= $producto['stock'] ?>">

  <label for="descripcion">Descripción:</label>
  <textarea id="descripcion" name="descripcion" rows="4"> <?= $producto['descripcion'] ?> </textarea>

  <label for="imagen">Imagen del producto:</label>

<img src="../agregar productos/img/<?= $producto['imagen'] ?>" alt="Imagen actual" width="100">
<input type="file" id="imagen" name="imagen" class="input-oculto">

<label for="imagen" class="boton-subir">Seleccionar imagen<i class="bi bi-file-earmark-image"></i></label>



  <input type="submit"  value="Guardar Cambios" class="botonguardar" name="guardar"> 
</form>
</div>
</body>
</html>