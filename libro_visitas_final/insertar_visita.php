<?php

include "biblioteca.php";
crearSesion();

$confirmar = array();
$errores = array();

if (isset($_POST['enviar'])) {
    if (!empty($_POST['comentario'])
    ) {
        $nombre = trim($_POST['nombre']);
        $comentario = trim($_POST['comentario']);

        if (strlen($comentario) <= 250) {

            if (insertarComentario($nombre, $comentario) == true) { 
                // Redirige a libro_visitas.php
                header('location: libro_visitas.php');
            } else {
                // Redirige a nueva_visita.php
                header('location: nueva_visita.php');
            }
        } else {
            $errores += ["Limite Caracteres" => "El campo comentario tiene que ser de 250 caracteres como máximo."];
            $_SESSION['errores'] = $errores;
            header('location: nueva_visita.php');
        }
    } else {
        $errores += ["Comentario Vacío" => "El campo Comentario es requerido"];
        $_SESSION['errores'] = $errores;
        header('location: nueva_visita.php');
    }
} else {
    header('location: index.php');
}
?>