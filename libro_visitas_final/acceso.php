<?php

include "biblioteca.php";
crearSesion();
existeBD($nombreDb);

if (isset($_SESSION["conectado"])
    && $_SESSION["conectado"] == true
) {
    header('location: index.php');
    exit;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acceso</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
<?php include "includes/navbar.php"; ?>
        <div class="contenido">
            <h1>Iniciar Sesión</h1>
<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>
            <form action="autenticar.php" method="post">
                <input type="text" name="usuario" id="usuario" placeholder="Nombre de Usuario" autofocus>
                <?php mensajeError("Nombre Usuario"); ?>
                <input type="password" name="contrasenna1" id="contrasenna1" placeholder="Contraseña">
                <?php mensajeError("Contraseña"); ?>
                <div class="boton-formulario">
                    <input class="btn btn-secundario btn-bloque btn-ancho" type="reset" name="restablecer" value="Restablecer">
                    <input class="btn btn-primario btn-bloque btn-ancho" type="submit" name="acceder" value="Acceder">
                </div>
            </form>
            <div class="registrarse-login">
                ¿No tienes una cuenta?<a href="registro.php">Regístrarse</a>
            </div>
        </div>
        <?php unsetVariables(); ?>
<?php include "includes/footer.php"; ?>
    </div>
</body>
</html>