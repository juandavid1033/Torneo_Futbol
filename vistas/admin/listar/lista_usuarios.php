<?php
require_once("../../../bd/conexion.php");
$bd = new Database();
$conexion = $bd->conectar();
session_start();

$sql = "SELECT u.*, r.rol, e.estado FROM usuarios u 
        INNER JOIN roles r ON u.id_rol = r.id_rol
        INNER JOIN estado e ON u.id_estado = e.id_estado";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    /* Estilos para la barra de navegación */
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
        <a href="../index.php">Atras</a>
    </div>

    <div class="container mt-4">
        <h1 class="mb-3">Lista de Usuarios</h1>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>Documento</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td>
                            <?= $usuario["documento"] ?>
                        </td>
                        <td>
                            <?= $usuario["nombre"] ?>
                        </td>
                        <td>
                            <?= $usuario["email"] ?>
                        </td>
                        <td>
                            <?= $usuario["rol"] ?>
                        </td>
                        <td>
                            <?= $usuario["estado"] ?>
                        </td>
                        <td>
                            <!-- Botón de editar que redirige a la página de edición -->
                            <a href="editar_usuario.php?documento=<?= $usuario['documento'] ?>"
                                class="btn btn-primary btn-sm">Editar</a>

                            <!-- Botón de eliminar que envía un formulario para borrar el usuario -->
                            <form action="eliminar_usuario.php" method="post" style="display: inline-block;">
                                <input type="hidden" name="documento" value="<?= $usuario['documento'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
