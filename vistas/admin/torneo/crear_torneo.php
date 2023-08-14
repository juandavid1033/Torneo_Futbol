<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["fecha_inicio"]) && isset($_POST["fecha_fin"])) {
        $nombre = $_POST["nombre"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];

        // Insertar el torneo en la base de datos
        $sql = "INSERT INTO torneos (nombre, fecha_inicio, fecha_fin) VALUES (:nombre, :fecha_inicio, :fecha_fin)";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":fecha_inicio", $fecha_inicio);
        $stmt->bindParam(":fecha_fin", $fecha_fin);

        try {
            $stmt->execute();
            header("Location: index_torneo.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al crear el torneo: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Torneo</title>
    <link rel="stylesheet" href="../index.css">
    <!-- Agregar referencia a Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <a href="index_torneos.php" class="btn btn-danger mb-3">Atrás</a>
        <h1 class="mb-3">Crear Torneo</h1>
        <form method="post">
            <div class="form-group">
                <label for="nombre">Nombre del Torneo:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="fecha_inicio">Fecha de Inicio:</label>
                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
            </div>
            <div class="form-group">
                <label for="fecha_fin">Fecha de Fin:</label>
                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
            </div><br>
            <button type="submit" class="btn btn-success">Guardar Torneo</button>
        </form>
    </div>
    <!-- Agregar referencia a los scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr
