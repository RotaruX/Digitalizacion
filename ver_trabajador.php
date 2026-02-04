<?php
session_start();

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "rrhh") {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: panel_rrhh.php");
    exit();
}

$id = $_GET['id'];

$conexion = new mysqli("localhost", "root", "", "controlempresas");

$sqlTrab = "SELECT nombre FROM trabajador WHERE id_trabajador = ?";
$stmt = $conexion->prepare($sqlTrab);
$stmt->bind_param("i", $id);
$stmt->execute();
$trabajador = $stmt->get_result()->fetch_assoc();

$sqlEpi = "SELECT * FROM epi WHERE id_trabajador = ?";
$stmt2 = $conexion->prepare($sqlEpi);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$epis = $stmt2->get_result();

include 'templates/header.php';
?>

<h2 class="titulo-panel">EPIs de <?php echo $trabajador['nombre']; ?></h2>

<div class="tabla-container">
    <table class="tabla-epis">
        <tr>
            <th>EPI</th>
            <th>Fecha entrega</th>
            <th>Fecha caducidad</th>
            <th>Acciones</th>
        </tr>

        <?php while ($fila = $epis->fetch_assoc()): ?>
            <tr>
                <td><?php echo $fila['nombre_epi']; ?></td>
                <td><?php echo $fila['fecha_entrega']; ?></td>
                <td><?php echo $fila['fecha_caducidad']; ?></td>
                <td>
                    <a href="modificar_epi.php?id=<?php echo $fila['id_epi']; ?>" class="btn btn-modificar">Modificar</a>
                    <a href="borrar_epi.php?id=<?php echo $fila['id_epi']; ?>" class="btn btn-borrar">Borrar</a>

                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<a href="anadir_epi.php?id_trabajador=<?php echo $id; ?>" class="btn btn-anadir">
    Añadir EPI
</a>


<?php include 'templates/footer.php'; ?>