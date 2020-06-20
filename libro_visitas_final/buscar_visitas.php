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

if (isset($_POST["buscar"])) {
    if (isset($_POST["buscar-nombre"]) 
        && !empty($_POST["buscar-nombre"])
    ) {
        $nombre = $_POST["buscar-nombre"];
    } else {
        $errores = array();
        $errores += ["Nombre Usuario" => "El campo Nombre de usuario es requerido."];
        $_SESSION['errores'] = $errores;
    }
}

if (isset($_POST["buscar-nombre"]) 
    && !empty($_POST["buscar-nombre"])
) {
    $nombre = $_POST["buscar-nombre"];
}

if (isset($nombre) && !empty($nombre)) {
    $parametrosBuscar = array(
        "Nombre" => $nombre,
        "Criterio" => "$criterio",
        "Orden" => "$orden"
    );
    $_SESSION['Busqueda'] = $parametrosBuscar;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Buscar Visitas</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <?php include "includes/navbar.php"; ?>
        <h1>Buscar todas las visitas de un usuario</h1>
        <div class="contenido">
<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>
            <div class="buscar-mensajes-top">
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="buscar-mensajes">
                  <input type="text" name="buscar-nombre" placeholder="Nombre de usuario" autofocus
                    value="<?php
                    if (isset($nombre) && !empty($nombre)) {
                        echo $nombre;
                    } ?>">
                    <?php mensajeError("Nombre Usuario"); ?>
                  <input type="submit" class="btn btn-primario btn-bloque btn-ancho" name="buscar" value="Buscar">
                </form>
            </div>
            <?php
            if (empty($_SESSION['errores'])
                && isset($nombre)
            ) {
                echo "<h1>Mensajes del usuario $nombre</h1>";
                mostrarBuscarComentarios($nombreDb, $nombre, $criterio, $orden);
            }
            mensajeError("Mensajes Usuario");
            unsetVariables();
            ?>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>