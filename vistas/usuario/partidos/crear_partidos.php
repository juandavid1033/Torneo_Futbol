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
} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

// Procesar el formulario al enviarlo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["equipo_local"]) &&
        isset($_POST["equipo_visitante"]) &&
        isset($_POST["fecha"]) &&
        isset($_POST["torneo"])
    ) {
        $equipo_local = $_POST["equipo_local"];
        $equipo_visitante = $_POST["equipo_visitante"];
        $fecha = date('Y-m-d', strtotime($_POST["fecha"])); // Convertir la fecha al formato 'Y-m-d'
        $torneo = $_POST["torneo"];

        // Insertar el partido en la base de datos
        $sql = "INSERT INTO partidos (equipo_local, equipo_visitante, fecha, id_torneos) VALUES (:equipo_local, :equipo_visitante, :fecha, :torneo)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":equipo_local", $equipo_local);
        $stmt->bindParam(":equipo_visitante", $equipo_visitante);
        $stmt->bindParam(":fecha", $fecha);
        $stmt->bindParam(":torneo", $torneo);

        try {
            $stmt->execute();
            header("Location: index_partidos.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al crear el partido: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Partido</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Botón para regresar a la página anterior -->
    <div class="container mt-4">
        <a href="../index.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Crear Partido</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="equipo_local" class="form-label">Equipo Local</label>
                <select class="form-select" name="equipo_local" id="equipo_local" required>
                    <option value="">Selecciona un equipo</option>
                    <?php
                    foreach ($equipos as $equipo) {
                        echo "<option value='" . $equipo['id_equipos'] . "'>" . $equipo['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="equipo_visitante" class="form-label">Equipo Visitante</label>
                <select class="form-select" name="equipo_visitante" id="equipo_visitante" required>
                    <option value="">Selecciona un equipo</option>
                    <?php
                    foreach ($equipos as $equipo) {
                        echo "<option value='" . $equipo['id_equipos'] . "'>" . $equipo['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha</label>
                <input type="date" class="form-control" name="fecha" id="fecha" required>
            </div>
            <div class="mb-3">
                <label for="torneo" class="form-label">Torneo</label>
                <select class="form-select" name="torneo" id="torneo" required>
                    <option value="">Selecciona un torneo</option>
                    <?php
                    foreach ($torneos as $torneo) {
                        echo "<option value='" . $torneo['id_torneos'] . "'>" . $torneo['nombre'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
    <!-- Agregar referencia a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
