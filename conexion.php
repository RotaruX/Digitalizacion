<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "controlempresas");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
