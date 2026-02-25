<?php

$host = "localhost";
$user = "miusuario";
$pass = "password_seguro";
$db   = "controlempresas";

$conexion = new mysqli($host, $user, $pass, $db);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

?>