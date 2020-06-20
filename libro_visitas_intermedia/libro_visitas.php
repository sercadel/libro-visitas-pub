<?php

include "biblioteca.php";

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
        <h1>Listado de Visitas</h1>
        <?php mostrarComentarios(); ?>
        <ul>
            <li><a href="index.php">Volver a la página principal</a></li>
            <li><a href="nueva_visita.php">Nueva Visita</a></li>
        </ul>
    </div>
</body>
</html>