<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();

// Consulta para obtener las estadísticas de los partidos con nombres de equipos
$sql = "SELECT p.id_partido, e1.nombre AS equipo_local, e2.nombre AS equipo_visitante, p.fecha, es.tiros_esquina, es.faltas, es.goles, es.tarjetas
        FROM partidos p
        INNER JOIN estadisticas es ON p.id_partido = es.id_partido
        INNER JOIN equipos e1 ON p.equipo_local = e1.id_equipos
        INNER JOIN equipos e2 ON p.equipo_visitante = e2.id_equipos";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$estadisticas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadísticas de Partidos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    /* Estilos para la barra de navegación */
    .navbar {
        background-color: #000;
        padding: 20px;
        color: #fff;
    }

    .navbar a {
        color: #fff;
        text-decoration: none;
        padding: 10px;
    }

    .navbar a:hover {
        background-color: #333;
    }
</style>

<body>
    <div class="navbar">
        <a href="../index.php">Atras</a>
    </div>

    <div class="container mt-4">
        <h1 class="mb-3">Estadísticas de Partidos</h1>
        <!-- Agrega el botón de Crear Estadísticas -->
        <a href="crear_estadisticas.php" class="btn btn-primary">Crear Estadísticas</a><br><br>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Equipo Local</th>
                    <th>Equipo Visitante</th>
                    <th>Fecha</th>
                    <th>Tiros de Esquina</th>
                    <th>Faltas</th>
                    <th>Goles</th>
                    <th>Tarjetas</th>
                </tr>
            </thead>
            <tbody>
    <?php foreach ($estadisticas as $estadistica): ?>
        <tr>
            <td><?= $estadistica["equipo_local"] ?></td>
            <td><?= $estadistica["equipo_visitante"] ?></td>
            <td><?= $estadistica["fecha"] ?></td>
            <td><?= $estadistica["tiros_esquina"] ?></td>
            <td><?= $estadistica["faltas"] ?></td>
            <td><?= $estadistica["goles"] ?></td>
            <td><?= $estadistica["tarjetas"] ?></td>
        </tr>
    <?php endforeach; ?>
</tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
