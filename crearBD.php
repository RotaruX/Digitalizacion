<?php
// Conexión al servidor MySQL (sin seleccionar base de datos)
$conexion = new mysqli("localhost", "root", "");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Crear la base de datos
$sql = "CREATE DATABASE IF NOT EXISTS controlempresas DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
if ($conexion->query($sql) === TRUE) {
    echo "✅ Base de datos 'controlempresas' creada correctamente.<br>";
} else {
    die("❌ Error al crear la base de datos: " . $conexion->error);
}

// Seleccionar la base de datos
$conexion->select_db("controlempresas");

// ---- TABLA: trabajador ----
$sqlTrabajador = "CREATE TABLE IF NOT EXISTS `trabajador` (
    `id_trabajador` int(11) NOT NULL AUTO_INCREMENT,
    `nombre` varchar(100) NOT NULL,
    `usuario` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `rol` enum('trabajador','rrhh') NOT NULL DEFAULT 'trabajador',
    PRIMARY KEY (`id_trabajador`),
    UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conexion->query($sqlTrabajador) === TRUE) {
    echo "✅ Tabla 'trabajador' creada correctamente.<br>";
} else {
    die("❌ Error al crear tabla 'trabajador': " . $conexion->error);
}

// ---- TABLA: epi ----
$sqlEpi = "CREATE TABLE IF NOT EXISTS `epi` (
    `id_epi` int(11) NOT NULL AUTO_INCREMENT,
    `id_trabajador` int(11) NOT NULL,
    `nombre_epi` varchar(100) NOT NULL,
    `fecha_entrega` date NOT NULL,
    `fecha_caducidad` date NOT NULL,
    PRIMARY KEY (`id_epi`),
    KEY `id_trabajador` (`id_trabajador`),
    CONSTRAINT `epi_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conexion->query($sqlEpi) === TRUE) {
    echo "✅ Tabla 'epi' creada correctamente.<br>";
} else {
    die("❌ Error al crear tabla 'epi': " . $conexion->error);
}

// ---- TABLA: solicitud ----
$sqlSolicitud = "CREATE TABLE IF NOT EXISTS `solicitud` (
    `id_solicitud` int(11) NOT NULL AUTO_INCREMENT,
    `id_trabajador` int(11) NOT NULL,
    `id_epi` int(11) NOT NULL,
    `fecha_solicitud` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `estado` enum('pendiente','aprobada','rechazada') NOT NULL DEFAULT 'pendiente',
    PRIMARY KEY (`id_solicitud`),
    KEY `id_trabajador` (`id_trabajador`),
    KEY `id_epi` (`id_epi`),
    CONSTRAINT `solicitud_ibfk_1` FOREIGN KEY (`id_trabajador`) REFERENCES `trabajador` (`id_trabajador`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `solicitud_ibfk_2` FOREIGN KEY (`id_epi`) REFERENCES `epi` (`id_epi`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conexion->query($sqlSolicitud) === TRUE) {
    echo "✅ Tabla 'solicitud' creada correctamente.<br>";
} else {
    die("❌ Error al crear tabla 'solicitud': " . $conexion->error);
}

// ---- DATOS DE EJEMPLO ----

// Insertar trabajadores (solo si la tabla está vacía)
$check = $conexion->query("SELECT COUNT(*) as total FROM trabajador");
$row = $check->fetch_assoc();

if ($row['total'] == 0) {
    $conexion->query("INSERT INTO `trabajador` (`id_trabajador`, `nombre`, `usuario`, `password`, `rol`) VALUES
        (1, 'Álex Martínez', 'alex', '1234', 'trabajador'),
        (2, 'Juan López', 'juan', '1234', 'trabajador'),
        (3, 'María Ruiz', 'maria', '1234', 'rrhh')");
    echo "✅ Datos de trabajadores insertados.<br>";
} else {
    echo "ℹ️ La tabla 'trabajador' ya tiene datos, no se insertan duplicados.<br>";
}

// Insertar EPIs (solo si la tabla está vacía)
$check = $conexion->query("SELECT COUNT(*) as total FROM epi");
$row = $check->fetch_assoc();

if ($row['total'] == 0) {
    $conexion->query("INSERT INTO `epi` (`id_epi`, `id_trabajador`, `nombre_epi`, `fecha_entrega`, `fecha_caducidad`) VALUES
        (1, 1, 'Casco de seguridad', '2024-01-10', '2025-01-10'),
        (2, 1, 'Guantes anticorte', '2024-05-01', '2024-12-15'),
        (3, 2, 'Botas de seguridad', '2024-02-20', '2025-02-20')");
    echo "✅ Datos de EPIs insertados.<br>";
} else {
    echo "ℹ️ La tabla 'epi' ya tiene datos, no se insertan duplicados.<br>";
}

// Insertar solicitudes (solo si la tabla está vacía)
$check = $conexion->query("SELECT COUNT(*) as total FROM solicitud");
$row = $check->fetch_assoc();

if ($row['total'] == 0) {
    $conexion->query("INSERT INTO `solicitud` (`id_solicitud`, `id_trabajador`, `id_epi`, `fecha_solicitud`, `estado`) VALUES
        (1, 1, 2, '2026-01-07 14:23:18', 'pendiente'),
        (2, 1, 1, '2026-01-07 14:23:18', 'aprobada'),
        (3, 2, 3, '2026-01-07 14:23:18', 'rechazada')");
    echo "✅ Datos de solicitudes insertados.<br>";
} else {
    echo "ℹ️ La tabla 'solicitud' ya tiene datos, no se insertan duplicados.<br>";
}

echo "<br>🎉 <strong>¡Base de datos lista!</strong>";

$conexion->close();
?>
