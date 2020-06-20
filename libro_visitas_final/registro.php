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
    <title>Registro</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
<?php include "includes/navbar.php"; ?>
        <div class="contenido">
            <h1>Crear una cuenta</h1>
<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>
            <form name="registro" method="post" action="crear_usuario.php">
                <input type="text" name="usuario" placeholder="Nombre de Usuario" autofocus>
<?php mensajeError("Nombre Usuario"); mensajeError("Crear Usuario"); ?>

                <input class="campo-contrasena" type="password" name="contrasenna1" placeholder="Contraseña">
                <input class="campo-contrasena" type="password" name="contrasenna2" placeholder="Repita la contraseña">
                <?php mensajeError("Contraseña"); ?>
                
                <div class="boton-formulario">
                    <input class="btn btn-secundario btn-bloque btn-ancho" type="reset" name="restablecer" value="Restablecer">
                    <input class="btn btn-primario btn-bloque btn-ancho" type="submit" name="registrar" value="Registrarse">
                </div>
            </form>
            <div class="registrarse-login">
                ¿Ya tienes una cuenta?<a href="acceso.php">Iniciar sesión</a>
            </div>
        </div>
        <?php unsetVariables(); ?>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>