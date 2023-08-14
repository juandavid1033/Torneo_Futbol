<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url(images/banner.jpg);
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="font-weight: 700;text-align: center;" class="mb-4">Recuperar Contraseña</h2>
        <form action="cambio_contrasena.php" method="POST" class="form-container">
            <div class="form-group">
                <input placeholder="Nueva contraseña" type="password" class="form-control" name="contra1" required>
            </div>
            <div class="form-group">
                <input placeholder="Confirmar nueva contraseña" type="password" class="form-control" name="contra2" required>
            </div>
            <button type="submit" value="cambiar" name="cambiar" class="btn btn-warning btn-block">Cambiar Contraseña</button>
        </form>
        <p class="mt-3">¿Recordaste tu contraseña? <a href="login.html">Ingresar aquí</a></p>
        <a style="text-decoration: underline;color: black;" href="index.html">Volver al inicio</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

<?php
require_once("../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();

if (isset($_POST['cambiar'])) {
    $contra = $_POST['contra1'];
    $contra2 = $_POST['contra2'];

    if ($contra != $contra2) {
        echo '<script>alert("Contraseñas no coinciden");</script>';
        echo '<script>window.location="cambio_contrasena.php"</script>';
    } else {
        $documento = $_SESSION['document'];

        $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE documento = ?");
        $consulta->execute([$documento]);
        $usuario = $consulta->fetch();

        if (!$usuario) {
            echo '<script>alert("El documento no existe en la base de datos");</script>';
            echo '<script>window.location="recuperar_contrasena.php"</script>';
            exit();
        }

        $consulta = $conexion->prepare("UPDATE usuarios SET password = ? WHERE documento = ?");
        $consulta->execute([$contra, $documento]);

        echo '<script>alert("Cambio de clave exitosa");</script>';
        echo '<script>window.location="../login.html"</script>';
    }
}
?>
