<?php
session_start();

// Solo RRHH puede entrar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "rrhh") {
    header("Location: login.php");
    exit();
}

// Comprobar que llega el ID del trabajador
if (!isset($_GET['id'])) {
    header("Location: panel_rrhh.php");
    exit();
}

$id = $_GET['id'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "controlempresas");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Obtener datos del trabajador
$sqlTrab = "SELECT nombre FROM trabajador WHERE id_trabajador = ?";
$stmt = $conexion->prepare($sqlTrab);
$stmt->bind_param("i", $id);
$stmt->execute();
$trabajador = $stmt->get_result()->fetch_assoc();

// Obtener EPIs del trabajador
$sqlEpi = "SELECT * FROM epi WHERE id_trabajador = ?";
$stmt2 = $conexion->prepare($sqlEpi);
$stmt2->bind_param("i", $id);
$stmt2->execute();
$epis = $stmt2->get_result();

// Incluir header
include 'templates/header.php';
?>

<h2 class="titulo-panel">EPIs de <?php echo $trabajador['nombre']; ?></h2>

<!-- LEYENDA -->
<div class="leyenda">
    <h3>Leyenda de estado de EPIs</h3>
    <ul>
        <li><span class="cuadro correcto"></span> <strong>Correcto:</strong> El EPI está en buen estado.</li>
        <li><span class="cuadro pronto"></span> <strong>Próxima caducidad:</strong> Caduca en menos de 30 días.</li>
        <li><span class="cuadro caducado"></span> <strong>Caducado:</strong> Debe renovarse.</li>
    </ul>
</div>

<div class="tabla-container">
<table class="tabla-epis">
    <tr>
        <th>EPI</th>
        <th>Fecha de entrega</th>
        <th>Fecha de caducidad</th>
        <th>Acciones</th>
    </tr>

    <?php while ($fila = $epis->fetch_assoc()): ?>

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
            <td>
                <a href="modificar_epi.php?id=<?php echo $fila['id_epi']; ?>">
                    <button class="btn btn-modificar">Modificar</button>
                </a>

                <a href="borrar_epi.php?id=<?php echo $fila['id_epi']; ?>">
                    <button class="btn btn-borrar">Borrar</button>
                </a>
            </td>
        </tr>

    <?php endwhile; ?>

</table>
</div>

<!-- Botón añadir -->
<a href="anadir_epi.php?id_trabajador=<?php echo $id; ?>">
    <button class="btn btn-anadir">Añadir EPIs</button>
</a>

<?php
include 'templates/footer.php';
$conexion->close();
?>
