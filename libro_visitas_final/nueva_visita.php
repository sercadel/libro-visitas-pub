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
    <title>Nueva Visita</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <?php include "includes/navbar.php"; ?>
        
        <h1>Añada un comentario al Libro de Visitas</h1>

        <div class="contenido">
<?php include "includes/notificaciones.php"; ?>

<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>

            <form action="insertar_visita.php" method="post">
                <!-- <legend>Nueva Visita</legend> -->
                <label for="nombre">Nombre:</label>
                <br>
                <input type="text" name="nombre" id="nombre" value="<?php
                if (isset($_SESSION["usuario"])) {
                    echo $_SESSION["usuario"];
                }
                ?>" readonly>
                <br>
                <label for="comentario">Comentario:</label>
                <br>
                <textarea name="comentario" id="comentario" cols="30" rows="10"></textarea>
                <h4 class="texto-izquierda">*Máximo 250 carácteres.</h4>
                <?php
                mensajeError("Comentario Vacío");
                mensajeError("Limite Caracteres");
                ?>
                <div class="boton-formulario">
                    <input class="btn btn-secundario btn-bloque btn-ancho" type="reset" name="restablecer" value="Restablecer">
                    <input class="btn btn-primario btn-bloque btn-ancho" type="submit" name="enviar" value="Enviar">
                </div>
            </form>
        </div>
        <?php unsetVariables(); ?>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>