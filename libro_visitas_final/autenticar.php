<?php

include "biblioteca.php";
crearSesion();

$errores = array();

// Comprobar los datos del formulario
if (isset($_POST['acceder'])) {
    // Campo Nombre de Usuario
    if (isset($_POST['usuario']) && !empty($_POST['usuario'])) {
        $nombreUsuario = escape(trim($_POST['usuario']));
    } else {
        $errores += ['Nombre Usuario' => "El campo Nombre de usuario es requerido."];
    }

    // Campo Contraseña
    if ((isset($_POST['contrasenna1']) && !empty($_POST['contrasenna1']))
    ) {
        $contrasenna = trim($_POST['contrasenna1']);
    } else {
        $errores += ['Contraseña' => "El campo Contraseña es requerido."];
    }
    
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header('location: acceso.php');
    } else {

        // Si los campos se han completado correctamente,
        // comprueba que sea un usuario registrado en la BD
        if ((isset($nombreUsuario) && !empty($nombreUsuario))
            && (isset($contrasenna) && !empty($contrasenna))
        ) {
            $hash = obtenerHash($contrasenna);
            // BINARY Para que sea sensible a mayúsculas
            $consulta = "SELECT * FROM `usuarios` WHERE BINARY `usuario` = \"" . $nombreUsuario . "\"";
        
            $resultado = mysqli_query(conectar($nombreDb), $consulta);
    
            if (mysqli_num_rows($resultado) == 1) {
                $fila = mysqli_fetch_assoc($resultado);
                echo $consulta;
                echo "<br>";
                $hash = $fila['contrasenna'];
                echo $hash;
                echo "<br><br>";
            
                // Comprobar que la contraseña sea la almacenada en la BD
                if (comprobarContrasenna($contrasenna, $hash) == true) {
                    // echo "¡La contraseña es válida!";

                    // Si es correcto, inicia una sesión
                    if (!isset($_SESSION)) {
                        session_start();
                    }
                    // Guarda los datos de sesión
                    $_SESSION['Estado Conectado'] = true;
                    $_SESSION['Id Usuario'] = $fila['idUsuario'];
                    $_SESSION['Nombre Usuario'] = $fila['usuario'];
                    $_SESSION['Tipo Cuenta'] = $fila['tipoCuenta'];

                    // lleva al usuario a la página de bienvenida
                    header('location: index.php');
                } else {
                    $errores += ['Contraseña' => "La contraseña introducida no es correcta."];
                    $_SESSION['errores'] = $errores;
                    header('location: acceso.php');
                }
            } else {
                $errores += ['Nombre Usuario' => "El nombre de usuario introducido no existe o no es correcto."];
                $_SESSION['errores'] = $errores;
                header('location: acceso.php');
            }
        }
    }
} else {
    header('location: index.php');
}
?>