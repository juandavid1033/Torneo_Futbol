<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["dorsal"]) && isset($_POST["id_equipo"]) && isset($_FILES["foto"]["name"])) {
        $nombre = $_POST["nombre"];
        $dorsal = $_POST["dorsal"];
        $id_equipo = $_POST["id_equipo"];
        $foto = $_FILES["foto"]["name"];
        $foto_tmp = $_FILES["foto"]["tmp_name"];

        // Validar los datos ingresados (puedes agregar más validaciones si es necesario)

        // Subir la imagen al servidor
        $upload_dir = "uploads/"; // Directorio donde se almacenarán las imágenes
        move_uploaded_file($foto_tmp, $upload_dir . $foto);

        // Insertar el jugador en la base de datos
        $sql = "INSERT INTO jugadores (nombre, dorsal, id_equipos, foto) VALUES (:nombre, :dorsal, :id_equipo, :foto)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":dorsal", $dorsal);
        $stmt->bindParam(":id_equipo", $id_equipo);
        $stmt->bindParam(":foto", $foto);

        try {
            $stmt->execute();
            header("Location: index_jugadores.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al crear el jugador: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Jugador</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="index_jugadores.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Crear Jugador</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="dorsal">Dorsal:</label>
                <input type="text" class="form-control" id="dorsal" name="dorsal" required>
            </div>
            <div class="form-group">
                <label for="id_equipo">Equipo:</label>
                <select class="form-control" id="id_equipo" name="id_equipo" required>
                    <?php
                    // Consulta SQL para obtener los equipos registrados
                    $sql_equipos = "SELECT id_equipos, nombre FROM equipos";
                    $stmt_equipos = $conexion->query($sql_equipos);

                    // Si hay equipos registrados, mostrar opciones en el select
                    if ($stmt_equipos->rowCount() > 0) {
                        while ($row_equipo = $stmt_equipos->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row_equipo["id_equipos"] . "'>" . $row_equipo["nombre"] . "</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="foto">Foto:</label>
                <input type="file" class="form-control" id="foto" name="foto" required>
            </div><br>
            <button type="submit" class="btn btn-success">Guardar Jugador</button>
        </form>
    </div>
    <!-- Agregar referencia a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
