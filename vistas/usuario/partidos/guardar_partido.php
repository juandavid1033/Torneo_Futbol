<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["equipo_local"]) &&
        isset($_POST["equipo_visitante"]) &&
        isset($_POST["fecha"]) &&
        isset($_POST["torneo"])
    ) {
        $equipo_local = $_POST["equipo_local"];
        $equipo_visitante = $_POST["equipo_visitante"];
        $fecha = $_POST["fecha"]; // No es necesario convertir la fecha aquí
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
