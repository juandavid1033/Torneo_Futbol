<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
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
        <h2 style="font-weight: 700;text-align: center;" class="mb-4">REGISTRO</h2>
        <form method="post" class="form-container">
            <div class="form-group">
                <input maxlength="11" placeholder="Documento de identidad" type="text" class="form-control" name="documento" required>
            </div>
            <div class="form-group">
                <input maxlength="25" placeholder="Nombre" type="text" class="form-control" name="nombre" required>
            </div>
            <div class="form-group">
                <input maxlength="50" placeholder="Email" type="text" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <input maxlength="16" placeholder="Contraseña" type="password" class="form-control" name="contra" required>
            </div>
            <br>
            <button type="submit" value="registrar" name="btn-registrar"
                class="btn btn-primary">Registrarme</button><br><br>
            <p>¿Ya tienes una cuenta? <a class="ingresar" href="login.html">Ingresar</a></p>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function mayuscula(e) {
            e.value = e.value.toUpperCase();
        }

        function minuscula(e) {
            e.value = e.value.toLowerCase();
        }

        function numeros(e) {
            e.value = e.value.replace(/[^0-9\.]/g, '');
        }

        function espacios(e) {
            e.value = e.value.replace(/ /g, '');
        }
    </script>
</body>

</html>

<?php
require_once("bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

if (isset($_POST["btn-registrar"])) {
    $documento = $_POST['documento'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $contra = $_POST['contra'];

    $consulta2 = $conexion->prepare("SELECT * FROM usuarios WHERE documento= ?");
    $consulta2->execute([$documento]);
    $consull = $consulta2->fetch();

    if ($consull) {
        echo '<script>alert("DOCUMENTO O USUARIO EXISTEN // CAMBIELOS //");</script>';
        echo '<script>window.location="registrousu.php"</script>';
    } else if ($documento == "" || $nombre == "" || $email == "" || $contra == "") {
        echo '<script>alert("EXISTEN DATOS VACIOS");</script>';
        echo '<script>window.location="registro.php"</script>';
    } else {
        $consulta3 = $conexion->prepare("INSERT INTO usuarios (documento, nombre, email, password, id_rol, id_estado) VALUES (?, ?, ?, ?, 2, 1)");
        $consulta3->execute([$documento, $nombre, $email, $contra]);
        echo '<script>alert("Registro exitoso, gracias");</script>';
        echo '<script>window.location="login.html"</script>';
    }
}
?>

