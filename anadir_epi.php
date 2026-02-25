<?php
session_start();

// Solo RRHH puede entrar
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== "rrhh") {
    header("Location: login.php");
    exit();
}

// Comprobar que llega el ID del trabajador
if (!isset($_GET['id_trabajador'])) {
    header("Location: panel_rrhh.php");
    exit();
}

$id_trabajador = intval($_GET['id_trabajador']);

// Conexión BD
include 'conexion.php';

// Obtener nombre del trabajador
$sql = "SELECT nombre FROM trabajador WHERE id_trabajador = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_trabajador);
$stmt->execute();
$trabajador = $stmt->get_result()->fetch_assoc();

$mensaje = "";

// Procesar formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre_epi = trim($_POST["nombre_epi"]);
    $fecha_entrega = trim($_POST["fecha_entrega"]);
    $fecha_caducidad = trim($_POST["fecha_caducidad"]);

    if ($nombre_epi === "" || $fecha_entrega === "" || $fecha_caducidad === "") {
        $mensaje = "Rellena todos los campos";
    } else {

        $sqlInsert = "INSERT INTO epi (id_trabajador, nombre_epi, fecha_entrega, fecha_caducidad)
                      VALUES (?, ?, ?, ?)";

        $stmt2 = $conexion->prepare($sqlInsert);
        $stmt2->bind_param("isss", $id_trabajador, $nombre_epi, $fecha_entrega, $fecha_caducidad);

        if ($stmt2->execute()) {
            header("Location: ver_trabajador.php?id=" . $id_trabajador);
            exit();
        } else {
            $mensaje = "Error al añadir el EPI";
        }
    }
}

// Incluir header
include 'templates/header.php';
?>

<h2 class="titulo-panel">Añadir EPI a <?php echo $trabajador['nombre']; ?></h2>

<div class="form-container">
    <form action="" method="POST" class="form-epi">

        <label>Nombre del EPI:</label>
        <input type="text" name="nombre_epi" placeholder="Ej: Casco, Guantes…">

        <label>Fecha de entrega:</label>
        <input type="date" name="fecha_entrega">

        <label>Fecha de caducidad:</label>
        <input type="date" name="fecha_caducidad">

        <button type="submit" class="btn btn-anadir">Guardar EPI</button>

        <?php if ($mensaje !== ""): ?>
            <p class="error"><?php echo $mensaje; ?></p>
        <?php endif; ?>

    </form>
</div>

<?php
include 'templates/footer.php';
$conexion->close();
?>
