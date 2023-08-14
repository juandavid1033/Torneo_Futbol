<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (
        isset($_POST["id_partido"]) &&
        isset($_POST["tiros_esquina"]) &&
        isset($_POST["faltas"]) &&
        isset($_POST["goles"]) &&
        isset($_POST["tarjetas"])
    ) {
        // Obtener los datos del formulario
        $id_partido = $_POST["id_partido"];
        $tiros_esquina = $_POST["tiros_esquina"];
        $faltas = $_POST["faltas"];
        $goles = $_POST["goles"];
        $tarjetas = $_POST["tarjetas"];
        
        // Insertar las estadísticas en la base de datos
        $sql = "INSERT INTO estadisticas (id_partido, tiros_esquina, faltas, goles, tarjetas) VALUES (:id_partido, :tiros_esquina, :faltas, :goles, :tarjetas)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id_partido", $id_partido);
        $stmt->bindParam(":tiros_esquina", $tiros_esquina);
        $stmt->bindParam(":faltas", $faltas);
        $stmt->bindParam(":goles", $goles);
        $stmt->bindParam(":tarjetas", $tarjetas);

        if ($stmt->execute()) {
            echo "Estadísticas registradas exitosamente.";
        } else {
            echo "Error al registrar las estadísticas.";
        }
    } else {
        echo "Datos del formulario incompletos.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Estadísticas</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    /* Estilos para el formulario de creación de estadísticas */
    .form-wrapper {
        max-width: 500px;
        margin: 0 auto;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }
</style>

<body>
<a class="btn btn-danger" href="index.php" >Atras</a>
    <div class="form-wrapper">
        <h1 class="mb-3">Crear Estadísticas</h1>
        <form action="crear_estadisticas.php" method="post">
            <div class="form-group">
                <label for="id_partido">Partido:</label>
                <select class="form-control" id="id_partido" name="id_partido" required>
                    <?php
                    // Obtener la lista de partidos con nombres de equipos
                    $sqlPartidos = "SELECT p.id_partido, e1.nombre AS equipo_local, e2.nombre AS equipo_visitante 
                                    FROM partidos p 
                                    INNER JOIN equipos e1 ON p.equipo_local = e1.id_equipos 
                                    INNER JOIN equipos e2 ON p.equipo_visitante = e2.id_equipos";
                    $stmtPartidos = $conexion->prepare($sqlPartidos);
                    $stmtPartidos->execute();
                    $partidos = $stmtPartidos->fetchAll(PDO::FETCH_ASSOC);

                    // Mostrar los nombres de los equipos en el select
                    foreach ($partidos as $partido) {
                        echo "<option value='{$partido['id_partido']}'>{$partido['equipo_local']} vs. {$partido['equipo_visitante']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tiros_esquina">Tiros de Esquina:</label>
                <input type="number" class="form-control" id="tiros_esquina" name="tiros_esquina" required>
            </div>
            <div class="form-group">
                <label for="faltas">Faltas:</label>
                <input type="number" class="form-control" id="faltas" name="faltas" required>
            </div>
            <div class="form-group">
                <label for="goles">Goles:</label>
                <input type="number" class="form-control" id="goles" name="goles" required>
            </div>
            <div class="form-group">
                <label for="tarjetas">Tarjetas:</label>
                <input type="number" class="form-control" id="tarjetas" name="tarjetas" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrar Estadísticas</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
