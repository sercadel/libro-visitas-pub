<?php

include "biblioteca.php";
crearSesion();
existeBD($nombreDb);

$criterio = "fecha";
$orden = "DESC";

if (isset($_POST["fecha-asc"])) {
    $criterio = "fecha";
    $orden = "ASC";
}

if (isset($_POST["fecha-desc"])) {
    $criterio = "fecha";
    $orden = "DESC";
}

if (isset($_POST["autor-asc"])) {
    $criterio = "comentarios.iDUsuario";
    $orden = "ASC";
}

if (isset($_POST["autor-desc"])) {
    $criterio = "comentarios.iDUsuario";
    $orden = "DESC";
}

$parametrosBuscar = array(
    "Criterio" => "$criterio",
    "Orden" => "$orden"
);

$_SESSION['Busqueda'] = $parametrosBuscar;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listado Libro de Visitas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <?php include "includes/navbar.php"; ?>
        <h1>Listado de Visitas</h1>
        <div class="contenido">
        <?php
        include "includes/notificaciones.php";
        mostrarVariablesSesion();// Descomentar únicamente para depuración
        mostrarComentarios($nombreDb, $criterio, $orden);
        unsetVariables();
        ?>
        </div>
        </div>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>