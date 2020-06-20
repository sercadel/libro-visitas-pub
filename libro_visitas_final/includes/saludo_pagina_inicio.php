<?php

// Iniciar la sesión.
if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION["conectado"])
    && $_SESSION["conectado"] == true
) {
    if (isset($_SESSION['Tipo Cuenta'])
        && $_SESSION['Tipo Cuenta'] == "usuario"
    ) {
        $nombreUsuario = $_SESSION["usuario"];
        echo "<div class=\"bienvenida-index\">
            <p>Hola " . $nombreUsuario . ".</p>
            <br>
            <p>Está en la página de bienvenida del libro de visitas.</p>
            <br>
            <p>Desde la barra de navegación puede acceder a leer las visitas registradas, 
            Añadir un comentario al Libro de visitas y Buscar los comentarios de un usuario determinado.</p>
            <br>
        </div>";
        
    }

    if (isset($_SESSION['Tipo Cuenta'])
        && $_SESSION['Tipo Cuenta'] == "administrador"
    ) {
        $nombreUsuario = $_SESSION["usuario"];
        echo "<div class=\"bienvenida-index\">
                <p>Hola " . $nombreUsuario . ".</p>
                <br>
                <p>Está en la página de bienvenida del libro de visitas.</p>
                <br>
                <p>Desde la barra de navegación puede acceder a leer las visitas registradas, 
                Añadir un comentario al Libro de visitas y Buscar los comentarios de un usuario determinado.</p>
                <br>
                <p>Además como usuario de nivel Administrador se te permite borrar los comentarios.
                <br>
            </div>";
    }
} else {
    $nombreUsuario = "Anónimo";
    echo "<div class=\"bienvenida-index\">
        <p>Hola.</p>
            <br>
            <p>Está en la página de bienvenida del libro de visitas.</p>
            <br>
            <p>Desde la barra de navegación puede acceder a leer las visitas registradas.</p>
            <br>
            <p>Para poder añadir un comentario debe antes iniciar sesión,
            puede hacerlo desde la barra de navegación pulsando en Acceso.</p>
            <br>
            <p>También puede hacerlo desde el  siguiente enlace <a href=\"acceso.php\">Iniciar sesión</a></p>
            <br>
            <p>Si no tiene una cuenta, puede crearla pulsando en el siguiente enlace <a href=\"registro.php\">Crear una cuenta</a></p>
        </div>";
}


?>