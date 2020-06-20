<?php
/*//############################################
        Constantes y variables
//############################################*/
DEFINE('DB_HOST', "localhost");
DEFINE('DB_USER', "root");
DEFINE('DB_PASSWORD', "");
DEFINE('DB_NAME', "libro_visitas_sercadel");

/*//############################################
        Variables
//############################################*/
// Siempre dejarlo en false, muestra las variables de $_SESSION
$depurarSesion = false; // Cambiar a true únicamente para depuración
$nombreDb = DB_NAME;

/*//############################################
        Funciones
//############################################*/
// Crea una sesión o reanuda la actual
function crearSesion()
{
    if (!isset($_SESSION)) {
        session_start(); 
    }
}

// Función conectar a la BD
function conectar($nombreDb = "")
{
    $enlace = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, $nombreDb);
    // Comprueba la conexión
    if (mysqli_connect_errno()) {
        printf(
            "Fallo al conectarse a la base de datos: %s\n", mysqli_connect_error()
        );
        exit();
    } else {
        mysqli_set_charset($enlace, "utf8mb4");
        return $enlace;
    }
    mysqli_close($enlace);
}

// Comprueba si existe la base de datos antes de crearla
function existeBD($nombreDb)
{
    $consulta = "SELECT `SCHEMA_NAME` "
        . "FROM `INFORMATION_SCHEMA`.`SCHEMATA` "
        . "WHERE `SCHEMA_NAME` = \"$nombreDb\"";
    $resultado = mysqli_query(conectar(), $consulta);
    if (mysqli_num_rows($resultado) == 0) {
        // No existe la base de datos
        header('location: crear_db.php');
    }
}

// Borra una base de datos si existe
function borrarBD($nombreDb)
{
    $consulta = "DROP DATABASE IF EXISTS `$nombreDb`";
    $resultado = mysqli_query(conectar(), $consulta);
    if ($resultado) {
        return true;
    } else {
        // Error al eliminar la base de datos
        return false;
    }
}

// Convierte caracteres especiales en entidades HTML
function escape($cadena)
{
    return htmlspecialchars($cadena, ENT_QUOTES, 'UTF-8');
}

// escapa una cadena antes de ingresarla a la base de datos
function escapeSql($cadena)
{
    return mysqli_real_escape_string($cadena);
}

// Obtiene la fecha actual con el formato en números de Año-Mes-Día
function sqlDate()
{
    // 2019-05-01 (Formato DATE de MySQL)
    $hoy = date("Y-m-d");
    return $hoy;
}
 
// Obtiene la fecha actual con el formato en números
// de Año-Mes-Día Hora:Minutos:Segundos
function sqlDatetime()
{
    // 2019-05-01 17:16:18 (Formato DATETIME de MySQL)
    $hoy = date("Y-m-d H:i:s");
    return $hoy;
}

// Insertar un comentario en la base de datos
function insertarComentario($nombreUsuario, $comentario)
{
    $errores = array();
    $confirmar = array();
    $nombreDb = DB_NAME;
    $fecha = sqlDatetime();
    $idUsuario = $_SESSION["id"];

    $consulta = "INSERT INTO `comentarios` (`idVisita`, `idUsuario`, `fecha`, `comentario`) "
                . "VALUES(NULL, $idUsuario, '$fecha', \"$comentario\")";

    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
    if ($resultado) {
        $consulta = "SELECT * from `comentarios` "
        . " WHERE `fecha` = \"" . $fecha . "\" AND "
        . "`idUsuario` = \"" . $idUsuario . "\" AND "
        . "`comentario` = \"" . $comentario . "\"";
    
        $resultado = mysqli_query(conectar($nombreDb), $consulta);

        $confirmar += ["Enviar Comentario" => "El comentario se ha enviado con éxito."];
        $_SESSION['Confirmar'] = $confirmar;
        return true;
    } else {
        $errores += ["Enviar Comentario" => "No se ha podido añadir el comentario."];
        $_SESSION['errores'] = $errores;
    }
}

// Obtiene un hash con sal de una cadena
function obtenerHash($contrasenna)
{
    $hash = password_hash($contrasenna, PASSWORD_BCRYPT);
    return $hash;
}

// Comprueba si es valido una cadena con un hash con sal
function comprobarContrasenna($contrasenna, $hash)
{
    if (password_verify($contrasenna, $hash)) {
        // echo "¡La contraseña es válida!";
        return true;
    } else {
        // echo "La contraseña no es válida.";
        return false;
    }
}

// Crea la estructura de un mensaje de confirmación o éxito
function mensajeConfirmar($campo)
{
    if (!empty($_SESSION['Confirmar']["$campo"])) {
        echo "<span class=\"exito\">
            <img src=\"img/exito.png\" alt=\"Éxito\">
            &nbsp;&nbsp;"
            . $_SESSION['Confirmar']["$campo"]. "
        </span>";
    }
}

// Crea la estructura de un mensaje de error o fallo
function mensajeError($campo)
{
    if (!empty($_SESSION['errores']["$campo"])) {
        echo "<span class=\"error\">
            <img src=\"img/error.png\" alt=\"ERROR\">
            &nbsp;&nbsp;"
            . $_SESSION['errores']["$campo"]. "
        </span>";
    }
}

// Muestra los comentarios
function mostrarComentarios($nombreDb, $criterio = 'fecha', $orden = 'DESC')
{
    $errores = array();
     
    // Establece las opciones que aparecerán en función del tipo de cuenta
    if (isset($_SESSION['Tipo Cuenta'])
        && $_SESSION['Tipo Cuenta'] == "administrador"
    ) {
        // Opción borrar habilitada para usuarios con cuenta Administrador
        $botonBorrar = "<form action=\"confirmar_borrar.php\" method=\"post\">
        <input type=\"hidden\" name=\"comentario\" value=\"%s\">
        <input type=\"submit\" class=\"btn btn-secundario\" name=\"borrar\" value=\"Borrar\">
        </form>";
    } else {
        // Deshabilita la opción borrar para usuarios con cuenta Usuario
        $botonBorrar = "";
    }
    // Selecciona todos los comentarios almacenados
    $consulta = "SELECT * FROM `comentarios`, usuarios "
            . "WHERE `usuarios`.`idUsuario` = `comentarios`.`idUsuario` "
            . "ORDER by " . $criterio . " " . $orden;

    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    if (mysqli_num_rows($resultado) !== 0) {
        include "includes/opcion_filtrar.php";
        // Datos de salida de cada línea
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo sprintf(
                "<div>
                    <div class='bloque-comentario'>
                        <div class='autor'>
                            Autor: %s
                        </div>
                        <div class='titulo-fecha-arriba'>
                            <label>Fecha:</label>
                        </div>
                        <div class='titulo-fecha-abajo'>
                            %s
                        </div>
                        <br>
                        <div class='titulo-comentario'>
                            <label>Comentario:</label>
                        </div>
                        <div class='comentario'>
                            %s
                        </div>
                        <br>
                        $botonBorrar
                    </div>
                </div>",
                $fila['usuario'],
                $fila['fecha'],
                $fila['comentario'],
                $fila['idVisita']
            );
        }
    } else {
        // En caso de que no haya ningún comentario
        if (!empty($errores)) {
            $_SESSION['errores'] = $errores;
        }
        include "includes/mensaje_no_comentarios.php";
    }
}

// Muestra los comentarios de un usuario
function mostrarBuscarComentarios($nombreDb, $usuario, $criterio = 'fecha', $orden = 'DESC')
{
    $errores = array();

    // Establece las opciones que aparecerán en función del tipo de cuenta
    if (isset($_SESSION['Tipo Cuenta'])
        && $_SESSION['Tipo Cuenta'] == "administrador"
    ) {
        // Opción borrar habilitada para usuarios con cuenta Administrador
        $botonBorrar = "<form action=\"confirmar_borrar.php\" method=\"post\">
        <input type=\"hidden\" name=\"comentario\" value=\"%s\">
        <input type=\"submit\" class=\"btn btn-secundario btn-bloque btn-ancho\" name=\"borrar\" value=\"Borrar\">
        </form>";
    } else {
        // Deshabilita la opción borrar para usuarios con cuenta Usuario
         $botonBorrar = "";
    }
    // Obtener el Id del usuario
    $consulta = "SELECT `idUsuario`, `usuario` FROM `usuarios` "
            . "WHERE `usuario` = '$usuario'";

    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    if (mysqli_num_rows($resultado) == 1) {
        
        // Asignar el resultado a la variable $idUsuario
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $idUsuario = $fila['idUsuario'];
            $usuario = $fila['usuario'];
            
            // Selecciona todos los comentarios almacenados del usuario
            $consulta = "SELECT * FROM `comentarios`, usuarios "
                . "WHERE `usuarios`.`idUsuario` = $idUsuario "
                . "AND `usuarios`.`idUsuario` = `comentarios`.`idUsuario` "
                . "ORDER by " . $criterio . " " . $orden;

            $resultado = mysqli_query(conectar($nombreDb), $consulta);

            if (mysqli_num_rows($resultado) !== 0) {
                include "includes/opcion_filtrar_fecha.php";
                // Datos de salida de cada línea
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo sprintf(
                        "<div>
                            <div class='bloque-comentario'>                                
                                <div class='autor'>
                                    Autor: %s
                                </div>
                                <div class='titulo-fecha-arriba'>
                                    <label>Fecha:</label>
                                </div>
                                <div class='titulo-fecha-abajo'>
                                    %s
                                </div>
                                <br>
                                <div class='titulo-comentario'>
                                    <label>Comentario:</label>
                                </div>
                                <div class='comentario'>
                                    %s
                                </div>
                                <br>
                                $botonBorrar
                            </div>
                        </div>",
                        $fila['usuario'],
                        $fila['fecha'],
                        $fila['comentario'],
                        $fila['idVisita']
                    );
                }
            } else {
                // Si el usuario no tiene ningún mensaje almacenado
                $errores += ['Mensajes Usuario' => "No hay mensajes del usuario $usuario."];
                $_SESSION['errores'] = $errores;
            }
        }
    } else {
        // Si el usuario introducido no existe en la base de datos
        $errores += ["Mensajes Usuario" => "El usuario $usuario no existe."];
    }
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
    }
}

function mostrarVisitaABorrar($ideVisita)
{
    $nombreDb = DB_NAME;
    // Selecciona el comentario a borrar
    $consulta = "SELECT * FROM `comentarios` "
            . "WHERE  `idVisita` = $ideVisita";
    $consulta = "SELECT * FROM `comentarios`, usuarios "
            . "WHERE `usuarios`.`idUsuario` = `comentarios`.`idUsuario` "
            . "AND `idVisita` = $ideVisita";

    $resultado = mysqli_query(conectar($nombreDb), $consulta);
    if (mysqli_num_rows($resultado) !== 0) {
        // Datos de salida de cada línea
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo sprintf(
                "<div>
                    <div class='bloque-comentario'>
                        <div class='autor'>
                            Autor: %s
                        </div>
                        <div class='titulo-fecha-arriba'>
                            <label>Fecha:</label>
                        </div>
                        <div class='titulo-fecha-abajo'>
                            %s
                        </div>
                        <br>
                        <div class='titulo-comentario'>
                            <label>Comentario:</label>
                        </div>
                        <div class='comentario'>
                            %s
                        </div>
                        <br>
                    </div>
                </div>",
                $fila['usuario'],
                $fila['fecha'],
                $fila['comentario'],
                $fila['idVisita']
            );
        }
    } else {
        // En caso de que no haya ningún comentario
        include "includes/mensaje_no_comentarios.php";
    }
}

// Eliminar valores en variables de sesión
function unsetVariables()
{
    unset($_SESSION['Confirmar']);
    unset($_SESSION['errores']);
    unset($_SESSION['Busqueda']);
    unset($_SESSION['Mostrar Visitas']);
}


/*//############################################
        Funciones de depuración
//############################################*/
// Mostrar el contenido de $_SESSION si la variable $depurarSesion esta en true
function mostrarVariablesSesion()
{
    global $depurarSesion;
    if ($depurarSesion == true) {
        if (isset($_SESSION)) {
            echo "<br><pre>"
            . "################################################################\n"
            . "\t<font size=\"4\">Contenido de \$_SESSION:</font>\n"
            . "----------------------------------------------------------------\n";
            print_r($_SESSION);
            echo "################################################################
        </pre><br>";
        }
    }
}


/*//############################################
        Funciones de calculo
//############################################*/
// Funciones con IVA
function aplicarIva($baseImponible, $porcentaje = 21)
{ 
    $total = $baseImponible * $porcentaje / 100;
    return $total;
}

function precioSinIva($total, $porcentaje = 21)
{ 
    $baseImponible = $total / (1 + ($porcentaje / 100));
    return $baseImponible;
}


?>