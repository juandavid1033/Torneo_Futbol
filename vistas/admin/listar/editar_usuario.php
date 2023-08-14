<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verificar si se ha enviado el formulario
    if (isset($_POST["documento"], $_POST["nombre"], $_POST["email"], $_POST["id_rol"], $_POST["id_estado"])) {
        // Obtener los datos del formulario
        $documento = $_POST["documento"];
        $nombre = $_POST["nombre"];
        $email = $_POST["email"];
        $id_rol = $_POST["id_rol"];
        $id_estado = $_POST["id_estado"];

        // Consulta SQL para actualizar los datos del usuario
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, id_rol = :id_rol, id_estado = :id_estado WHERE documento = :documento";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":id_rol", $id_rol);
        $stmt->bindParam(":id_estado", $id_estado);
        $stmt->bindParam(":documento", $documento);

        if ($stmt->execute()) {
            // Redirigir a la página de lista de usuarios después de actualizar
            header("Location: lista_usuarios.php");
            exit();
        } else {
            // Mostrar un mensaje de error si no se pudo actualizar
            echo "Error al actualizar los datos del usuario.";
        }
    } else {
        // Mostrar un mensaje de error si no se enviaron todos los datos del formulario
        echo "Datos del formulario incompletos.";
    }
} else {
    // Obtener el documento del usuario a editar desde la URL
    if (isset($_GET["documento"])) {
        $documento = $_GET["documento"];

        // Consulta SQL para obtener los datos del usuario a editar
        $sql = "SELECT * FROM usuarios WHERE documento = :documento";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(":documento", $documento);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            // Si el usuario no existe, redirigir a la página de lista de usuarios
            header("Location: lista_usuarios.php");
            exit();
        }
    } else {
        // Si no se recibió el documento del usuario, redirigir a la página de lista de usuarios
        header("Location: lista_usuarios.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    /* Estilos para el formulario de edición */
    .form-wrapper {
        max-width: 500px;
        margin: 0 auto;
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
    }
    .navbar {
        background-color: #000;
        padding: 20px;
        color: #fff;
    }

    .navbar a {
        color: #fff;
        text-decoration: none;
        padding: 10px;
    }

    .navbar a:hover {
        background-color: #333;
    }
</style>

<body>
<div class="navbar">
        <a href="lista_usuarios.php">Atras</a>
    </div>
    <div class="form-wrapper">
        <h1 class="mb-3">Editar Usuario</h1>
        <form action="editar_usuario.php" method="post">
            <input type="hidden" name="documento" value="<?= $usuario['documento'] ?>">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $usuario['nombre'] ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $usuario['email'] ?>" required>
            </div>
            <div class="form-group">
                <label for="id_rol">Rol:</label>
                <select class="form-control" id="id_rol" name="id_rol" required>
                    <!-- Aquí se obtienen los roles desde la base de datos y se generan las opciones -->
                    <?php
                    $sqlRoles = "SELECT * FROM roles";
                    $stmtRoles = $conexion->prepare($sqlRoles);
                    $stmtRoles->execute();
                    $roles = $stmtRoles->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($roles as $rol) {
                        $selected = ($usuario['id_rol'] == $rol['id_rol']) ? 'selected' : '';
                        echo "<option value='{$rol['id_rol']}' $selected>{$rol['rol']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_estado">Estado:</label>
                <select class="form-control" id="id_estado" name="id_estado" required>
                    <!-- Aquí se obtienen los estados desde la base de datos y se generan las opciones -->
                    <?php
                    $sqlEstados = "SELECT * FROM estado";
                    $stmtEstados = $conexion->prepare($sqlEstados);
                    $stmtEstados->execute();
                    $estados = $stmtEstados->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($estados as $estado) {
                        $selected = ($usuario['id_estado'] == $estado['id_estado']) ? 'selected' : '';
                        echo "<option value='{$estado['id_estado']}' $selected>{$estado['estado']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
