<?php

// Variables
$nombreFichero = "visitas.txt";
$delimitador = ",|,";
$lineas = file($nombreFichero);
$indices = array("Fecha", "Nombre", "Comentario");


// Funciones

function insertarComentario($nombre, $comentario)
{
    global $nombreFichero, $delimitador;

    // abre el fichero en modo escritura al final del mismo
    $fichero = fopen($nombreFichero, "a");

    // Insertar los datos al fichero
    $texto = date('d-m-Y - H:i:s') . $delimitador
        . $nombre . $delimitador
        . $comentario . PHP_EOL;
    
    // escribir en el fichero
    fwrite($fichero, $texto);
    // cerrar el fichero
    fclose($fichero);
}


function obtenerComentarios()
{
    global $delimitador, $lineas, $indices;
    $comentarios = array();
    foreach ($lineas as $linea) {
        $valores = explode($delimitador, $linea);
        array_push($comentarios, array_combine($indices, $valores));
    }
    return $comentarios;
}

function mostrarComentarios()
{
    $numero = 1;
    foreach (obtenerComentarios() as $value) {
        echo "Visita Nº " . $numero . "<br>";
        foreach ($value as $key => $value) {
            echo $key . ": "
            . $value . "<br>";
        }
        echo "<br>";
        $numero++;
    }
}

?>