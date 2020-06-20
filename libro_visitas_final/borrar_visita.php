<?php

include "biblioteca.php";
crearSesion();

if (!isset($_SESSION['Tipo Cuenta'])
    || $_SESSION['Tipo Cuenta'] != "administrador"
) {
    header('location: no_autorizado.php');
    exit;
}

if (isset($_POST['borrar']) && !empty($_POST['comentario'])) {
    $idVisita = $_POST['comentario'];

    $confirmar = array();
    $errores = array();

    $consulta = "DELETE FROM `comentarios` WHERE `idVisita` = $idVisita";

    $resultado = mysqli_query(conectar($nombreDb), $consulta);

    if ($resultado) {
        $confirmar += ["Borrar Comentario" => "El comentario se ha eliminado con éxito."];
        $_SESSION['Confirmar'] = $confirmar;
        header('location: libro_visitas.php');
    } else {
        echo "Error: " . $consulta . "<br>";
        $errores += ["Borrar Comentario" => "No se ha podido eliminar el comentario."];
        $_SESSION['errores'] = $errores;
        header('location: libro_visitas.php');
    }
}

header('location: libro_visitas.php');

?>
