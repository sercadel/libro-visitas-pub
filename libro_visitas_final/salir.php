<?php

include "biblioteca.php";
crearSesion();

// Destruir todas las variables de sesión.
$_SESSION = array();

// Destruir la sesión.
session_destroy();

// Redirige al la página de inicio.
header('location: index.php');
exit;

?>