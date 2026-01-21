<?php
session_start();

// Si no hay sesión, volver al login
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$id_trabajador = $_SESSION['id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "eiffage");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Consulta de EPIs del trabajador
$sql = "SELECT nombre_epi, fecha_entrega, fecha_caducidad 
        FROM epi 
        WHERE id_trabajador = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_trabajador);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis EPIs</title>
    <style>
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #333;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">EPIs asignados a <?php echo $_SESSION['usuario']; ?></h2>

<table>
    <tr>
        <th>EPI</th>
        <th>Fecha de entrega</th>
        <th>Fecha de caducidad</th>
    </tr>

    <?php while ($fila = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?php echo $fila['nombre_epi']; ?></td>
            <td><?php echo $fila['fecha_entrega']; ?></td>
            <td><?php echo $fila['fecha_caducidad']; ?></td>
        </tr>
    <?php endwhile; ?>

</table>

</body>
</html>

<?php
$conexion->close();
?>
