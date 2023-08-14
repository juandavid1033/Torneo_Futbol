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
        <form method="post" class="form-container">
            <div class="form-group">
                <input placeholder="Documento de identidad" type="text" class="form-control" name="documento" required>
            </div>
            <button type="submit" value="recuperar" name="inicio" class="btn btn-primary btn-block">Recuperar</button>
        </form>
        <p class="mt-3">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
        <a style="text-decoration: underline;color: black;" href="index.html">Volver al inicio</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
require_once("bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();
session_start();

if (isset($_POST['inicio'])) {
    $documento = $_POST['documento'];

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE documento = ?");
    $consulta->execute([$documento]);
    $usuario = $consulta->fetch();

    if (!$usuario) {
        echo '<script>alert("El documento no existe en la base de datos");</script>';
        echo '<script>window.location="recuperar_contrasena.php"</script>';
        exit();
    }

    $_SESSION['document'] = $documento;
    header("Location: ingreso/cambio_contrasena.php");
    exit();
}
?>
