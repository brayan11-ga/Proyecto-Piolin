<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="../estilos/estiloindex.css">
    <link rel="stylesheet" href="agregarproductos.css">
    <link rel="icon" type="image/jpg" href="../img/favicon-32x32.png"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
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

<h2 class="tituloformulario">Agregar Productos</h2>

<div class="frm">
<form class="formularioProducto" action="insertar.php" method="post" enctype="multipart/form-data">

    <label for="nombre">Código de Barras:</label>
    <input type="text" id="codigobarras" name="codigobarras" required>

    <label for="nombre">Nombre del producto:</label>
    <input type="text" id="nombre" name="nombre" required>

    <label for="categoria">Categoría:</label>
    <select id="categoria" name="categoria" required>
    <option value="">Seleccione una categoría</option>
    <option value="Frutas y verduras">🥦 Alimentos frescos</option>
    <option value="carnes">🥩 Carnes, pescados y proteínas</option>
    <option value="Lacteos">🥛 Lácteos y derivados</option>
    <option value="Panadería">🥖 Panadería y repostería</option>
    <option value="Alimentos">🥫 Alimentos no perecederos (despensa)</option>
    <option value="Snacks">🍫 Snacks y dulces</option>
    <option value="Bebidas">🥤 Bebidas</option>
    <option value="frutas_verduras">🧃 Congelados</option>
    <option value="frutas_verduras">🍼 Productos para bebés</option>
    <option value="frutas_verduras">🧴 Higiene personal</option>
    <option value="frutas_verduras">🧹 Limpieza del hogar</option>
    <option value="frutas_verduras">🐶 Mascotas</option>



    <label for="precio"> Precio: </label>
    <input type="number" id="precio" name="precio" min="0" required>

    <label for="stock">Cantidad en stock:</label>
    <input type="number" id="stock" name="stock" min="0" required>

    <label for="descripcion">Descripción:</label>
    <textarea id="descripcion" name="descripcion" rows="4"></textarea>

    <label for="imagen">Imagen del producto:</label>


 <div style="text-align:center; margin-top:20px;">
    <label class="boton-subir">
      Subir Archivo
      <input type="file" class="input-oculto" onchange="mostrarArchivo(this)">
    </label>
    <span id="nombre-archivo">Ningún archivo seleccionado</span>
  </div>

  <script>
    function mostrarArchivo(input) {
      const archivo = input.files[0];
      document.getElementById("nombre-archivo").textContent = archivo ? archivo.name : "Ningún archivo seleccionado";
    }
  </script>



    <input type="submit"  value="Guardar" class="botonguardar" name="guardar"> 
</form>
</div>

<footer>
    <p>&copy; 2025 Supermercado Piolín. Todos los derechos reservados.</p>
</footer>
