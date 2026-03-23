<?php
session_start(); // Inicia la sesión actual
session_unset(); // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión

// Redirigir al login o a la página principal
header("Location: ../ingresar/ingresar.php"); 
exit();
?>





