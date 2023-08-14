<?php
require_once("../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

// Obtener la fecha actual en formato 'Y-m-d'
$fechaActual = date('Y-m-d');

// Consulta SQL usando PDO para obtener los próximos partidos después de la fecha actual
$sql = "SELECT el.nombre AS equipo_local, el.foto AS foto_local, ev.nombre AS equipo_visitante, ev.foto AS foto_visitante, p.fecha, t.nombre AS nombre_torneo
        FROM partidos AS p
        INNER JOIN equipos AS el ON p.equipo_local = el.id_equipos
        INNER JOIN equipos AS ev ON p.equipo_visitante = ev.id_equipos
        INNER JOIN torneos AS t ON p.id_torneos = t.id_torneos
        WHERE p.fecha > :fecha_actual
        ORDER BY p.fecha";
$stmt = $conexion->prepare($sql);
$stmt->bindParam(":fecha_actual", $fechaActual);
$stmt->execute();
$partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index de Usuario</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="index.css">
    <style>
        /* Estilos para hacer las imágenes más pequeñas */
        .card-img-top {
            max-height: 150px; /* Ajusta la altura máxima de las imágenes */
            object-fit: contain; /* Ajusta el modo de ajuste de la imagen */
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <a href="../../index.html">Cerrar Sesión</a>
        <a href="equipos/index_equipos.php">Equipos</a>
        <a href="partidos/index_partidos.php">Partidos</a>
        <a href="jugadores/index_jugadores.php">Jugadores</a>
        <a href="torneo/index_torneo.php">Torneo</a>
        <a href="estadisticas/index.php">Estadisticas</a>
    </div>

    <div class="content">
        <h2 style="font-weight: 700; text-align: center;">Próximos Partidos</h2><br>

        <div class="row">
            <?php foreach ($partidos as $partido) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <!-- Aquí se construye la ruta de la imagen utilizando la carpeta "uploads" dentro de la carpeta "equipos" -->
                        <?php
                        $rutaImagenLocal = 'equipos/uploads/' . $partido["foto_local"];
                        $rutaImagenVisitante = 'equipos/uploads/' . $partido["foto_visitante"];
                        ?>
                        <img src="<?php echo $rutaImagenLocal; ?>" class="card-img-top" alt="Equipo Local">
                        <img src="<?php echo $rutaImagenVisitante; ?>" class="card-img-top" alt="Equipo Visitante">
                        <div class="card-body">
                            <h5 class="card-title"><?= $partido["equipo_local"] ?> vs <?= $partido["equipo_visitante"] ?></h5>
                            <p class="card-text">Fecha: <?= date("d-m-Y", strtotime($partido["fecha"])) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
