<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["id_jugador"])) {
        $id_jugador = $_POST["id_jugador"];

        // Eliminar el jugador de la base de datos
        $sql = "DELETE FROM jugadores WHERE id_jugadores = :id_jugador";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":id_jugador", $id_jugador);

        try {
            $stmt->execute();
            header("Location: index_jugadores.php");
            exit();
        } catch (PDOException $e) {
            echo "Error al eliminar el jugador: " . $e->getMessage();
        }
    }
}
?>
