<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'controlempresas';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
<?php
require_once("./templates/header.php");
?>

<main>
    <h2>Listado de EPIs</h2>

    <input type="text" id="buscador" placeholder="Buscar por nombre...">

    <select id="filtroTrabajador">
        <option value="">Todos los trabajadores</option>
        <?php
        $resFiltro = $conn->query("SELECT DISTINCT trabajador.nombre FROM epi JOIN trabajador ON epi.id_trabajador = trabajador.id_trabajador");
        while ($row = $resFiltro->fetch_assoc()) {
            echo "<option value='{$row['nombre']}'>{$row['nombre']}</option>";
        }
        ?>
    </select>

    <select id="filtroCaducidad">
        <option value="">Todas las fechas</option>
        <option value="caducados">Caducados</option>
        <option value="vigentes">Vigentes</option>
    </select>

    <table id="tablaEpis">
        <thead>
            <tr>
                <th>ID</th>
                <th>Trabajador</th>
                <th>Nombre</th>
                <th>Entrega</th>
                <th>Caducidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conn->query("
                SELECT epi.id_epi, trabajador.nombre AS nombre_trabajador, epi.nombre_epi, epi.fecha_entrega, epi.fecha_caducidad
                FROM epi
                JOIN trabajador ON epi.id_trabajador = trabajador.id_trabajador
                ORDER BY epi.id_epi DESC
            ");
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['id_epi']}</td>
                    <td>{$row['nombre_trabajador']}</td>
                    <td>{$row['nombre_epi']}</td>
                    <td>{$row['fecha_entrega']}</td>
                    <td>{$row['fecha_caducidad']}</td>
                    <td>
                        <button onclick='editar({$row['id_epi']})'>Editar</button>
                        <button onclick='eliminar({$row['id_epi']})'>Eliminar</button>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</main>
        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const buscador = document.getElementById("buscador");
            const filtroTrabajador = document.getElementById("filtroTrabajador");
            const filtroCaducidad = document.getElementById("filtroCaducidad");
            const tabla = document.getElementById("tablaEpis").getElementsByTagName("tbody")[0];

            function filtrar() {
                const texto = buscador.value.toLowerCase();
                const trabajador = filtroTrabajador.value;
                const caducidad = filtroCaducidad.value;
                const hoy = new Date().toISOString().split("T")[0];

                Array.from(tabla.rows).forEach(row => {
                    const nombre = row.cells[2].textContent.toLowerCase();
                    const nombreTrabajador = row.cells[1].textContent;
                    const fechaCad = row.cells[4].textContent;

                    const coincideNombre = nombre.includes(texto);
                    const coincideTrabajador = !trabajador || nombreTrabajador === trabajador;
                    const coincideCaducidad =
                        !caducidad ||
                        (caducidad === "caducados" && fechaCad < hoy) ||
                        (caducidad === "vigentes" && fechaCad >= hoy);

                    row.style.display = (coincideNombre && coincideTrabajador && coincideCaducidad) ? "" : "none";
                });
            }

            buscador.addEventListener("input", filtrar);
            filtroTrabajador.addEventListener("change", filtrar);
            filtroCaducidad.addEventListener("change", filtrar);
        });

        function editar(id) {
            alert("Editar EPI ID: " + id);
            // Redirigir o abrir modal
        }

        function eliminar(id) {
            if (confirm("¿Eliminar EPI ID " + id + "?")) {
                alert("Eliminado (simulado)");
                // Aquí podrías hacer fetch a un PHP que elimine el registro
            }
        }
    </script>
</body>
</html>
<?php
require_once("./templates/footer.php");
?>