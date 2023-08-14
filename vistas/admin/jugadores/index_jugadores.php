<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de jugadores</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Botón para regresar a la página anterior -->
    <div class="container mt-4">
        <a href="../index.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Jugadores Registrados</h1>
        <a href="crear_jugadores.php" class="btn btn-success mb-3">Agregar Jugador</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr style="text-align: center;">
                    <th>Nombre</th>
                    <th>Dorsal</th>
                    <th>Equipo</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Consulta SQL usando PDO para obtener jugadores y sus equipos
                    $sql = "SELECT j.id_jugadores, j.nombre AS nombre_jugador, j.dorsal, j.foto, e.nombre AS nombre_equipo
                            FROM jugadores j
                            LEFT JOIN equipos e ON j.id_equipos = e.id_equipos";
                    $stmt = $conexion->query($sql);

                    // Si hay resultados, mostrar los jugadores
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td style='text-align: center;'>" . $row["nombre_jugador"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["dorsal"] . "</td>";
                            echo "<td style='text-align: center;'>" . $row["nombre_equipo"] . "</td>";
                            // Mostrar la imagen usando la etiqueta <img>
                            echo "<td><img src='uploads/" . $row["foto"] . "' alt='" . $row["nombre_jugador"] . "' style='width: 100px; height: 100px; border-radius: 1rem; display: block; margin: 0 auto;'></td>";

                            // Agregar botón de eliminar con formulario
                            echo "<td style='text-align: center;'>";
                            echo "<form method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar este jugador?\");' action='eliminar_jugador.php'>";
                            echo "<input type='hidden' name='id_jugador' value='" . $row["id_jugadores"] . "'>";
                            echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                            echo "</form>";
                            echo "</td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No se encontraron jugadores registrados</td></tr>";
                    }
                } catch (PDOException $e) {
                    echo "Error en la consulta: " . $e->getMessage();
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- Agregar referencia a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
