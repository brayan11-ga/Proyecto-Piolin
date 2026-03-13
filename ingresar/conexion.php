 <?php
   $host = "localhost";
   $usuario = "root";
   $contrasena = "";
   $nombre_base_datos = "proyecto_venta";

   $conexion = new mysqli($host, $usuario, $contrasena, $nombre_base_datos);

   if ($conexion->connect_error) {
       die("La conexión falló: " . $conexion->connect_error);
   }
   echo "Conectado a la base de datos";
   $conexion->close();
   ?>