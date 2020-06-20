<?php

include "biblioteca.php";

if (isset($_POST['enviar'])) {
    if (!empty($_POST['nombre'])
        && !empty($_POST['comentario'])
    ) {
        $nombre = trim($_POST['nombre']);
        $comentario = trim($_POST['comentario']);

        insertarComentario($nombre, $comentario);
        // Redirige a libro_visitas.php
        header('location: libro_visitas.php');
    } else {
        header('location: nueva_visita.php');
    }
}

?>