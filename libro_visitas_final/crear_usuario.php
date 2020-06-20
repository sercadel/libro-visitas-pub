<?php

include "biblioteca.php";
crearSesion();

$confirmar = array();
$errores = array();

// Comprobar los datos del formulario
if (isset($_POST["registrar"])) {
    // Campo Nombre de Usuario
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"])) {
        $nombreUsuario = escape(trim($_POST["usuario"]));
    } else {
        $errores += ["Nombre Usuario" => "El campo Nombre de usuario es requerido."];
    }

    // Campo Contraseña
    if ((isset($_POST["contrasenna1"]) && !empty($_POST["contrasenna1"]))
        && (isset($_POST["contrasenna2"]) && !empty($_POST["contrasenna2"]))
    ) {
        if ($_POST["contrasenna1"] == $_POST["contrasenna2"]) {
            $contrasenna = trim($_POST["contrasenna1"]);
        } else {
            $errores += ["Contraseña" => "El campo Contraseña y Comprobar Contraseña no coincide."];
        }
    } else {
        $errores += ["Contraseña" => "El campo Contraseña y Comprobar Contraseña es requerido."];
    }
    
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header('location: registro.php');
    } else {

        // Si los campos se han completado correctamente,
        // se registra en la BD
        if ((isset($nombreUsuario) && !empty($nombreUsuario))
            && (isset($contrasenna) && !empty($contrasenna))
        ) {
            // Comprobar si el nombre de Usuario ya existe en la BD
            $consulta = "SELECT * FROM `usuarios` "
                . "WHERE `usuario` = \"$nombreUsuario\"";
            
            $resultado = mysqli_query(conectar($nombreDb), $consulta);

            if (mysqli_num_rows($resultado) == 0) {
                // obtener el hash de la contraseña
                $hash = obtenerHash($contrasenna);
                $email = strtolower($nombreUsuario) . "@iawe.es";

                $consulta = "INSERT INTO `usuarios` (`idUsuario`, `usuario`, `email`, `contrasenna`, `tipoCuenta`) "
                . "VALUES(NULL, \"$nombreUsuario\", \"$email\", \"$hash\", 'usuario')";
            
                $resultado = mysqli_query(conectar($nombreDb), $consulta);
        
                if ($resultado) {
                    // Inicia sesión con la cuenta creada
                    $consulta = "SELECT * FROM `usuarios` WHERE BINARY `usuario` = \"" . $nombreUsuario . "\"";

                    $resultado = mysqli_query(conectar($nombreDb), $consulta);
            
                    if (mysqli_num_rows($resultado) == 1) {
                        $fila = mysqli_fetch_assoc($resultado);
                        $hash = $fila["contrasenna"];
                        
                        // Comprobar que la contraseña sea la almacenada en la BD
                        if (comprobarContrasenna($contrasenna, $hash) == true) {
                            // echo "¡La contraseña es válida!";

                            // Si es correcto, inicia una sesión
                            if (!isset($_SESSION)) {
                                session_start();
                            }
                            // Guarda los datos de sesión
                            $_SESSION["conectado"] = true;
                            $_SESSION["id"] = $fila["idUsuario"];
                            $_SESSION["usuario"] = $fila["usuario"];
                            $_SESSION['Tipo Cuenta'] = $fila['tipoCuenta'];

                            $confirmar += ["Crear Usuario" => "La cuenta de usuario se ha creado con éxito."];
                            $_SESSION['Confirmar'] = $confirmar;
                            // lleva al usuario a la página de bienvenida
                            header('location: index.php');
                        } else {
                            $errores += ["Contraseña" => "No se ha podido comprobar la contraseña al crear la cuenta."];
                            $_SESSION['errores'] = $errores;
                            header('location: acceso.php');
                        }
                    } else {
                        $errores += ["Crear Usuario" => "No se ha podido comprobar el registro de usuario al crear la cuenta."];
                        $_SESSION['errores'] = $errores;
                        header('location: acceso.php');
                    }
                } else {
                    $errores += ["Crear Usuario" => "No se ha podido crear la cuenta de usuario."];
                    $_SESSION['errores'] = $errores;
                    header('location: registro.php');
                }
            } else {
                $errores += ["Crear Usuario" => "El nombre de usuario $nombreUsuario ya existe o no esta disponible."];
                $_SESSION['errores'] = $errores;
                header('location: registro.php');
            }
        } else {
            $errores += ["Crear Usuario" => "Error al asignar los valores a las variables."];
            $_SESSION['errores'] = $errores;
            header('location: registro.php');
        }
    }
} else {
    header('location: index.php');
}
?>