<?php

include "biblioteca.php";
crearSesion();
existeBD($nombreDb);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio Libro de Visitas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
<?php include "includes/navbar.php"; ?>
        
        <h1>Bienvenido al Libro de visitas</h1>
        <div class="contenido">
        <?php
        include "includes/notificaciones.php";
        mostrarVariablesSesion();// Descomentar únicamente para depuración
        include "includes/saludo_pagina_inicio.php";
        ?>
        </div>
        <?php unsetVariables(); ?>
<?php include "includes/footer.php"; ?>
    </div>
</body>
</html>