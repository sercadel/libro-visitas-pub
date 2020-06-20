<?php

include "biblioteca.php";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nueva Visita</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <h1>Añada un comentario al Libro de Visitas</h1>
        <form action="insertar_visita.php" method="post">
            <fieldset>
                <legend>Nueva Visita</legend>
                <label for="nombre">Nombre:</label>
                <br>
                <input type="text" name="nombre" id="nombre">
                <br>
                <label for="comentario">Comentario:</label>
                <br>
                <textarea name="comentario" id="comentario" cols="30" rows="10"></textarea>
            </fieldset>
            <input type="reset" name="restablecer" value="Restablecer">
            <input type="submit" name="enviar" value="Enviar">
        </form>
        <ul>
            <li><a href="index.php">Volver a la página principal</a></li>
        </ul>
    </div>
</body>
</html>