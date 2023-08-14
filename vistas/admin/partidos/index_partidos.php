<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

// Código para obtener la lista de equipos y torneos desde la base de datos
try {
    // Consulta SQL para obtener la lista de equipos
    $sqlEquipos = "SELECT id_equipos, nombre FROM equipos";
    $stmtEquipos = $conexion->query($sqlEquipos);
    $equipos = $stmtEquipos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obtener la lista de torneos
    $sqlTorneos = "SELECT id_torneos, nombre FROM torneos";
    $stmtTorneos = $conexion->query($sqlTorneos);
    $torneos = $stmtTorneos->fetchAll(PDO::FETCH_ASSOC);

    // Consulta SQL para obtener la lista de partidos con nombres de equipos y torneos
    $sqlPartidos = "SELECT el.nombre AS equipo_local, ev.nombre AS equipo_visitante, p.fecha, t.nombre AS nombre_torneo
                    FROM partidos AS p
                    INNER JOIN equipos AS el ON p.equipo_local = el.id_equipos
                    INNER JOIN equipos AS ev ON p.equipo_visitante = ev.id_equipos
                    INNER JOIN torneos AS t ON p.id_torneos = t.id_torneos";
    $stmtPartidos = $conexion->query($sqlPartidos);
    $partidos = $stmtPartidos->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Partidos</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Botón para regresar a la página anterior -->
    <div class="container mt-4">
        <a href="../index.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Partidos Registrados</h1>
        <a href="crear_partidos.php" class="btn btn-success mb-3">Agregar Partido</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr style="text-align: center;">
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Fecha</th>
                    <th>Torneo</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($partidos as $partido) {
                    echo "<tr>";
                    echo "<td style='text-align: center;'>" . $partido["equipo_local"] . "</td>";
                    echo "<td style='text-align: center;'>" . $partido["equipo_visitante"] . "</td>";
                    // Formatear la fecha en el formato dd-mm-yyyy
                    $fechaFormateada = date("d-m-Y", strtotime($partido["fecha"]));
                    echo "<td style='text-align: center;'>" . $fechaFormateada . "</td>";
                    echo "<td style='text-align: center;'>" . $partido["nombre_torneo"] . "</td>";
                    echo "</tr>";
                }

                if (empty($partidos)) {
                    echo "<tr><td colspan='4'>No se encontraron partidos registrados</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Agregar referencia a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
