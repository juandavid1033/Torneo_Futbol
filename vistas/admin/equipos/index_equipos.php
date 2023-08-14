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
    <title>Lista de equipos</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Botón para regresar a la página anterior -->
    <div class="container mt-4">
        <a href="../index.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Equipos Registrados</h1>
        <a href="crear_equipos.php" class="btn btn-success mb-3">Crear Equipo</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr style="text-align: center;">
                    <th>Nombre</th>
                    <th>Foto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Consulta SQL usando PDO
                    $sql = "SELECT id_equipos, nombre, foto FROM equipos";
                    $stmt = $conexion->query($sql);

                    // Si hay resultados, mostrar los equipos
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td style='text-align: center;'>" . $row["nombre"] . "</td>";
                            // Mostrar la imagen usando la etiqueta <img>
                            echo "<td><img src='uploads/" . $row["foto"] . "' alt='" . $row["nombre"] . "' style='width: 100px; height: 100px; border-radius: 1rem; display: block; margin: 0 auto;'></td>";

                            // Agregar botón de eliminar con formulario
                            echo "<td style='text-align: center;'>";
                            echo "<form method='post' onsubmit='return confirm(\"¿Estás seguro de eliminar este equipo?\");' action='eliminar_equipo.php'>";
                            echo "<input type='hidden' name='id_equipo' value='" . $row["id_equipos"] . "'>";
                            echo "<button type='submit' class='btn btn-danger'>Eliminar</button>";
                            echo "</form>";
                            echo "</td>";

                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron equipos registrados</td></tr>";
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
