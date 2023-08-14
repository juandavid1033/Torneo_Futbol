<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado el formulario
    if (isset($_POST["documento"])) {
        // Obtener el documento del usuario a eliminar
        $documento = $_POST["documento"];

        // Consulta SQL para eliminar al usuario por su documento
        $sql = "DELETE FROM usuarios WHERE documento = :documento";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":documento", $documento);

        if ($stmt->execute()) {
            // Redirigir a la página de lista de usuarios después de eliminar
            header("Location: lista_usuarios.php");
            exit();
        } else {
            // Mostrar un mensaje de error si no se pudo eliminar
            echo "Error al eliminar el usuario.";
        }
    } else {
        // Mostrar un mensaje de error si no se envió el documento
        echo "Documento del usuario no especificado.";
    }
}
?>
