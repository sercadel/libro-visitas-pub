<?php

include "biblioteca.php";
crearSesion();

if (isset($_SESSION['Tipo Cuenta'])
    && $_SESSION['Tipo Cuenta'] == "administrador"
) {
    if (isset($_POST['borrar'])
        && !empty($_POST['comentario'])
    ) {
        $idBorrar = $_POST['comentario'];
    } else {
        header('location: index.php');
        exit;
    }
} else {
    header('location: no_autorizado.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmar Borrar</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <div class="contenedor">
<?php include "includes/navbar.php"; ?>
        
        
        <div class="contenido">
<?php mostrarVariablesSesion();// Descomentar únicamente para depuración ?>
<div class="confirmar-borrar">
                <div class="titulo-aviso-confirmar-borrar">
                    ¡ATENCIÓN!
                </div>
                <div class="aviso-confirmar-borrar">
                    <p>¿Está seguro que desea borrar el comentario?</p>
                    <?php mostrarVisitaABorrar($idBorrar); ?>
                    <div class="confirmar-borrar">
                        <form action="borrar_visita.php" method="post">
                            <input type="hidden" name="comentario" value="<?php if (isset($idBorrar)) { echo $idBorrar; } ?>">
                            <input type="submit" class="boton-aviso-rojo" name="cancelar" value="Cancelar">
                            <input type="submit" class="boton-aviso" name="borrar" value="Borrar">
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php include "includes/footer.php"; ?>
    </div>
</body>
</html>