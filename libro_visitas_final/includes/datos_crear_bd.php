<?php

$hashPasswordAdmin = '$2y$10$NMPwo6Ivu.yaIk/MKia5Senn7ERc0A0.rwDMkzOeUSW8GcL1HSFLK';

// Crear la base de datos si no existe
$construirDB = "CREATE DATABASE IF NOT EXISTS `$nombreDb` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci";

// Estructura de la tabla comentarios
$construirTablaComentarios = "CREATE TABLE IF NOT EXISTS `comentarios` ("
        . "`idVisita` int(11) NOT NULL AUTO_INCREMENT, "
        . "`idUsuario` int(11) NOT NULL, "
        . "`fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, "
        . "`comentario` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL, "
        . "PRIMARY KEY (`idVisita`), "
        . "KEY `idUsuario` (`idUsuario`)"
    . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci";

// Estructura de la tabla usuarios
$construirTablaUsuarios = "CREATE TABLE IF NOT EXISTS `usuarios` ("
        . "`idUsuario` int(11) NOT NULL AUTO_INCREMENT, "
        . "`usuario` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL, "
        . "`email` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL, "
        . "`contrasenna` varchar(254) COLLATE utf8mb4_spanish_ci NOT NULL, "
        . "`tipoCuenta` enum('administrador','usuario') COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'usuario', "
        . "PRIMARY KEY (`idUsuario`), "
        . "UNIQUE KEY `usuario` (`usuario`)"
    . ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci";

// Datos tabla usuarios
$ingresarDatosUsuarios = "INSERT INTO `usuarios` (`idUsuario`, `usuario`, `email`, `contrasenna`, `tipoCuenta`) "
    . "VALUES(1, 'admin', 'admin@iawe.es', '$hashPasswordAdmin', 'administrador')";

//  Establecer relación clave foránea
$establecerRelaciones = "ALTER TABLE `comentarios` "
        . "ADD CONSTRAINT `comentarios_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`idUsuario`)";

?>