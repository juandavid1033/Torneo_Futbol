<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_equipo"])) {
        $id_equipo = $_POST["id_equipo"];

        // Eliminar el equipo de la base de datos
        $sql = "DELETE FROM equipos WHERE id_equipos = :id_equipo";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id_equipo", $id_equipo);

        try {
            $stmt->execute();
            header("Location: index_equipos.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el equipo: " . $e->getMessage();
        }
    }
}
?>
