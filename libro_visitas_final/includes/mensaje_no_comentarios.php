<?php

if (isset($_SESSION["conectado"])
    && $_SESSION["conectado"] == true
) {
    $enlace = "<p>Sea el primero en hacerlo pulsando en el siguiente enlace <a href=\"nueva_visita.php\">Nueva Visita</a></p>";
} else {
    $enlace = "<p>Para poder añadir un comentario debe antes iniciar sesión,</<p>
    <p>puede hacerlo desde la barra de navegación pulsando en Acceso.</<p>
    <br>
    <br>
    <p>También puede hacerlo desde el  siguiente enlace <a href=\"acceso.php\">Iniciar sesión</a></p>
    <br>
    <p>Si no tiene una cuenta, puede crearla pulsando en el siguiente enlace <a href=\"registro.php\">Crear una cuenta</a></p>";
}

echo "<div class=\"bienvenida-index\">
    <p>Aún no hay ningún comentario en el libro de visitas.</p>
    <br>
    $enlace
    <br>
</div>";

?>
