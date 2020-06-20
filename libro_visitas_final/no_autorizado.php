<?php

include "biblioteca.php";
crearSesion();

if (isset($_SESSION['Tipo Cuenta'])
    && $_SESSION['Tipo Cuenta'] == "administrador"
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
    <title>No Autorizado</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
        <?php include "includes/navbar.php"; ?>
        
        <div class="contenido">
<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>
            <div class="no-autorizado">
                <div class="titulo-aviso-no-autorizado">
                    Acceso denegado
                </div>
                <div class="aviso-no-autorizado">
<?php
if (isset($_SESSION['Tipo Cuenta'])
    && $_SESSION['Tipo Cuenta'] !== "administrador"
) {
    echo "La página a la que intenta acceder requiere permisos de administrador";
} else {
    echo "La página a la que intenta acceder requiere autenticación.";
}
?>
                    <a class="boton-aviso" href="salir.php">Salir</a>
                </div>
            </div>
        </div>
        <?php include "includes/footer.php"; ?>
    </div>
</body>
</html>