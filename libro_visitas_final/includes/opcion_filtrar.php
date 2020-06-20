<div class="menu-filtrar">
<h3>Ordenar por:</h3>
    <div class="menu-desplegable btn-desplegable">
        <button class="btn-desplegable">Fecha</button>
        <div class="menu-desplegable-contenido">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="buscar-nombre" value="<?php if (isset($nombre) && !empty($nombre)) { echo $nombre; } ?>">
                <input type="submit" name="fecha-asc" value="Ascendente">
                <input type="submit" name="fecha-desc" value="Descendente">
            </form>
        </div>
    </div>

    <div class="menu-desplegable btn-desplegable">
        <button class="btn-desplegable">Autor</button>
        <div class="menu-desplegable-contenido">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
                <input type="hidden" name="buscar-nombre" value="<?php if (isset($nombre) && !empty($nombre)) { echo $nombre; } ?>">
                <input type="submit" name="autor-asc" value="Ascendente">
                <input type="submit" name="autor-desc" value="Descendente">
            </form>
        </div>
    </div>
</div>