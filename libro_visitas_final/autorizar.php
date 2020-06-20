<?php

// Comprueba si el usuario está conectado,
// si no, rediríge a la página de inicio de sesión.
if (!isset($_SESSION["conectado"])
    || $_SESSION["conectado"] !== true
) {
    header('location: salir.php');
    exit;
}

?>