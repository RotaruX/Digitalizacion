<?php
session_start();

// Conexión a la base de datos
include 'conexion.php';

// Recoger datos del formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta
$sql = "SELECT * FROM trabajador WHERE usuario = ? AND password = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$resultado = $stmt->get_result();

// Comprobar si existe
if ($resultado->num_rows === 1) {

    $datos = $resultado->fetch_assoc();

    // Guardar sesión
    $_SESSION['id'] = $datos['id_trabajador'];
    $_SESSION['usuario'] = $datos['usuario'];
    $_SESSION['rol'] = $datos['rol'];

    // 👉 AÑADE ESTA LÍNEA
    $_SESSION['nombre_completo'] = $datos['nombre']; // nombre + apellidos en una sola columna

    // Redirigir según rol
    if ($datos['rol'] === "rrhh") {
        header("Location: panel_rrhh.php");
        exit();
    } else {
        header("Location: panel_trabajador.php");
        exit();
    }

} else {
    // Si no existe → volver al login
    header("Location: index.php?error=1");
    exit();
}

$conexion->close();
?>
