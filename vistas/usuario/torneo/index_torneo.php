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
    <title>Lista de Torneos</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Botón para regresar a la página anterior -->
    <div class="container mt-4">
        <a href="../index.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Torneos Registrados</h1>
        <a href="crear_torneo.php" class="btn btn-success mb-3">Agregar Torneo</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Consulta SQL usando PDO para obtener la lista de torneos
                    $sql = "SELECT nombre, fecha_inicio, fecha_fin FROM torneos";
                    $stmt = $conexion->query($sql);

                    // Si hay resultados, mostrar los torneos
                    if ($stmt->rowCount() > 0) {
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $row["nombre"] . "</td>";
                            echo "<td>" . $row["fecha_inicio"] . "</td>";
                            echo "<td>" . $row["fecha_fin"] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No se encontraron torneos registrados</td></tr>";
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
