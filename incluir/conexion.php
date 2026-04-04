<?php
// Datos de conexión a la base de datos
$host = "localhost";
$usuario = "root"; // Cambia esto por tu nombre de usuario de MySQL, si es diferente
$password = "s0p0rt34460$"; // Cambia esto por tu contraseña de MySQL si tienes una
$base_de_datos = "comercio_electronico"; // Cambia esto por tu contraseña de MySQL si tienes una

// Crear la conexión
$conexion = new mysqli($host, $usuario, $password, $base_de_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
} else {
    echo "";
}

// Establecer el conjunto de caracteres a UTF-8
$conexion->set_charset("utf8");
