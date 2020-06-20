        <nav class="navbar">
            <ul>
                <li><a class="menu" href='index.php'>Inicio</a></li>
                <li><a class="menu" href='libro_visitas.php'>Libro de visitas</a></li>
                <?php
                if (isset($_SESSION["conectado"])
                    && $_SESSION["conectado"] == true
                ) {
                    echo "<li><a class=\"menu\" href='nueva_visita.php'>Nueva visita</a></li>";
                }
                ?>

                <li><a class="menu" href='buscar_visitas.php'>Buscar visitas de usuario</a></li>
                
                <?php
                // Todavía no esta implementada
                /* if (isset($_SESSION["conectado"])
                    && $_SESSION['Tipo Cuenta'] == "administrador"
                ) {
                    echo "<li><a class=\"menu\" href='gestion.php'>Gestión</a></li>";
                } */

                if (!isset($_SESSION["conectado"])
                    || $_SESSION["conectado"] !== true
                ) {
                    echo "<li><a class=\"menu\" href='acceso.php'>Acceso</a></li>";
                } else {
                    echo "<li><a class=\"menu boton-salir\" href='salir.php'>Cerrar Sesión</a></li>";
                }
                ?>

            </ul>
        </nav>