<?php

include "biblioteca.php";
crearSesion();

$consulta = "SELECT `SCHEMA_NAME` "
            . "FROM `INFORMATION_SCHEMA`.`SCHEMATA` "
            . "WHERE `SCHEMA_NAME` = \"$nombreDb\"";

$resultado = mysqli_query(conectar(), $consulta);

if (mysqli_num_rows($resultado) == 1) {
    echo "<h2>Ya existe una base de datos con nombre $nombreDb</h2>
        <br><br>
        <a href=\"index.php\">Ir a Inicio</a> ";
} else {
    include "includes/datos_crear_bd.php";
    
    echo "<h2>La BD $nombreDb no existe</h2>
        ----------------------------------------------------
        <table>
        <tr><td>Creando la base de datos... </td>";
    
// Crear la base de datos
    $resultado = mysqli_query(conectar(), $construirDB);
    if ($resultado) {
        
// Crear la tabla Comentarios
        echo "<td> OK</td></tr>
        <tr><td>Creando la tabla Comentarios... </td>";
        $resultado = mysqli_query(conectar($nombreDb), $construirTablaComentarios);
        if ($resultado) {
            
// Crear la tabla Usuarios
            echo "<td> OK</td></tr>
            <tr><td>Creando la tabla Usuarios... </td>";
            $resultado = mysqli_query(conectar($nombreDb), $construirTablaUsuarios);
            if ($resultado) {
                
// Crear la cuenta admin
                echo "<td> OK</td></tr>
                <tr><td>Creando la cuenta admin... </td>";
                $resultado = mysqli_query(conectar($nombreDb), $ingresarDatosUsuarios);
                if ($resultado) {
                    
// Establecer las relaciones
                    echo "<td> OK</td></tr>
                    <tr><td>Estableciendo las relaciones... </td>";
                    $resultado = mysqli_query(conectar($nombreDb), $establecerRelaciones);
                    if ($resultado) {
                        echo "<td> OK</td></tr>
                        </table>
                        ----------------------------------------------------
                        <br><br>
                        <h2>¡Se ha creado con éxito la base de datos $nombreDb!</h2>
                        <a href=\"index.php\">Ir a Inicio</a> ";
                    } else {
                        
// ERROR Establecer las relaciones
                        echo "<td> ERROR</td></tr>
                        </table>
                        ----------------------------------------------------
                        <br><br>
                        ¡Error al establecer las relaciones!
                        <br>
                        ----------------------------------------------------
                        <table>
                        <tr><td>Desaciendo los cambios... </td>";
                        if (borrarBD($nombreDb) == true) {
                            echo "<td> OK</td></tr>";
                        } else {
                            echo "<td> ERROR</td></tr>";
                        }
                        echo "</table>
                        ----------------------------------------------------
                        <h2>No se ha podido crear la base de datos $nombreDb</h2>
                        <a href=\"index.php\">Ir a Inicio</a> ";
                    }
                } else {

// ERROR Crear la cuenta admin
                    echo "<td> ERROR</td></tr>
                    </table>
                    ----------------------------------------------------
                    <br><br>
                    ¡Error al crear la cuenta admin!
                    <br>
                    ----------------------------------------------------
                    <table>
                    <tr><td>Desaciendo los cambios... </td>";
                    if (borrarBD($nombreDb) == true) {
                        echo "<td> OK</td></tr>";
                    } else {
                        echo "<td> ERROR</td></tr>";
                    }
                    echo "</table>
                    ----------------------------------------------------
                    <h2>No se ha podido crear la base de datos $nombreDb</h2>
                    <a href=\"index.php\">Ir a Inicio</a> ";
                }
            } else {

// ERROR Crear la tabla Usuarios
                echo "<td> ERROR</td></tr>
                </table>
                ----------------------------------------------------
                <br><br>
                ¡Error al crear la tabla Usuarios!
                <br>
                ----------------------------------------------------
                <table>
                <tr><td>Desaciendo los cambios... </td>";
                if (borrarBD($nombreDb) == true) {
                    echo "<td> OK</td></tr>";
                } else {
                    echo "<td> ERROR</td></tr>";
                }
                echo "</table>
                ----------------------------------------------------
                <h2>No se ha podido crear la base de datos $nombreDb</h2>
                <a href=\"index.php\">Ir a Inicio</a> ";
            }
        } else {

// ERROR Crear la tabla Comentarios
            echo "<td> ERROR</td></tr>
            </table>
            ----------------------------------------------------
            <br><br>
            ¡Error al crear la tabla Comentarios!
            <br>
            ----------------------------------------------------
            <table>
            <tr><td>Desaciendo los cambios... </td>";
            if (borrarBD($nombreDb) == true) {
                echo "<td> OK</td></tr>";
            } else {
                echo "<td> ERROR</td></tr>";
            }
            echo "</table>
            ----------------------------------------------------
            <h2>No se ha podido crear la base de datos $nombreDb</h2>
            <a href=\"index.php\">Ir a Inicio</a> ";
        }
    } else {

// ERROR Crear la base de datos
        echo "<td> ERROR</td></tr>
        </table>
        ----------------------------------------------------
        <br><br>
        ¡Error al crear la base de datos $nombreDb!
        <br>
        ----------------------------------------------------
        <table>
        <tr><td>Desaciendo los cambios... </td>";
        if (borrarBD($nombreDb) == true) {
            echo "<td> OK</td></tr>";
        } else {
            echo "<td> ERROR</td></tr>";
        }
        echo "</table>
        ----------------------------------------------------
        <h2>No se ha podido crear la base de datos $nombreDb</h2>
        <a href=\"index.php\">Ir a Inicio</a> ";
    }
}
?>