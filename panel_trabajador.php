<?php
session_start();

// Si no hay sesión, volver al login
if (!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$id_trabajador = $_SESSION['id'];

// Conexión a la base de datos
include 'conexion.php';

// Consulta de EPIs del trabajador
$sql = "SELECT nombre_epi, fecha_entrega, fecha_caducidad 
        FROM epi 
        WHERE id_trabajador = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_trabajador);
$stmt->execute();
$resultado = $stmt->get_result();

// Incluir header
include 'templates/header-trabajador.php';
?>
<main>
<h2 class="titulo-panel">
    EPIs asignados a <?php echo htmlspecialchars($_SESSION['nombre_completo']); ?>
</h2>

<!-- LEYENDA -->
<div class="leyenda">
    <h3>Leyenda de estado de EPIs</h3>
    <ul>
        <li><span class="cuadro correcto"></span> <strong>Correcto:</strong> El EPI está en buen estado.</li>
        <li><span class="cuadro pronto"></span> <strong>Próxima caducidad:</strong> Caduca en menos de 30 días.</li>
        <li><span class="cuadro caducado"></span> <strong>Caducado:</strong> Debes solicitar una renovación.</li>
    </ul>
</div>

<div class="tabla-container">
<table class="tabla-epis">
    <tr>
        <th>EPI</th>
        <th>Fecha de entrega</th>
        <th>Fecha de caducidad</th>
    </tr>

    <?php while ($fila = $resultado->fetch_assoc()): ?>
        <?php
            // Cálculo de caducidad
            $caduca = strtotime($fila['fecha_caducidad']);
            $hoy = time();
            $faltan = ($caduca - $hoy) / 86400;

            if ($faltan < 0) {
                $clase = "caducado";
            } elseif ($faltan <= 30) {
                $clase = "pronto";
            } else {
                $clase = "correcto";
            }
        ?>

        <tr class="<?php echo $clase; ?>">
            <td><?php echo $fila['nombre_epi']; ?></td>
            <td><?php echo $fila['fecha_entrega']; ?></td>
            <td><?php echo $fila['fecha_caducidad']; ?></td>
        </tr>
    <?php endwhile; ?>

</table>
</div>
    </main>
<?php
include 'templates/footer.php';
$conexion->close();
?>
