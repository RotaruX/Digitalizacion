<?php
session_start();

// Solo RRHH puede entrar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "rrhh") {
    header("Location: login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "controlempresas");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$sql = "SELECT id_trabajador, nombre, usuario FROM trabajador";
$resultado = $conexion->query($sql);

include 'templates/header.php';
?>

<h2 class="titulo-panel">Gestión de trabajadores</h2>

<div class="tabla-container">
    <table class="tabla-epis">
        <tr>
            <th>Nombre completo</th>
            <th>Usuario</th>
            <th>Acciones</th>
        </tr>

        <?php while ($fila = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['usuario']; ?></td>
                <td>
                    <a href="ver_trabajador.php?id=<?php echo $fila['id_trabajador']; ?>" class="btn btn-ver">
                        Ver EPIs
                    </a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<?php include 'templates/footer.php'; ?>