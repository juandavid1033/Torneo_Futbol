<?php
require_once("../bd/conexion.php");
$basedatos = new Database();
$conexion = $basedatos->conectar();

if (isset($_POST["documento"]) && isset($_POST["contrasena"])) {
    $documento = $_POST['documento'];
    $contra = $_POST['contrasena'];

    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE documento = ?");
    $consulta->execute([$documento]);
    $consul = $consulta->fetch();

    if ($consul && $contra == $consul['password']) {
        // Verificar el estado del usuario
        if ($consul['id_estado'] == 2) {
            // La cuenta está bloqueada
            echo '<script>alert("Tu cuenta está bloqueada. Por favor, contacta al administrador.");</script>';
            echo '<script>window.location="../login.html"</script>';
            exit();
        }

        // Ingreso exitoso, reiniciar contador de intentos fallidos
        $conexion->prepare("UPDATE usuarios SET intentos_fallidos = 0 WHERE documento = ?")->execute([$documento]);

        session_start();
        $_SESSION['document'] = $consul['documento'];
        $_SESSION['name'] = $consul['nombre'];
        $_SESSION['roles'] = $consul['id_rol']; // Asegúrate de que el campo de rol sea el correcto

        // Redireccionar al usuario según el rol
        if ($_SESSION['roles'] == 1) {
            header("Location: ../vistas/admin/index.php");
        } elseif ($_SESSION['roles'] == 2) {
            header("Location: ../vistas/usuario/index.php");
        } else {
            // Si el rol no es 1 ni 2, redirige a una página de error o al login
            header("Location: ../login.html");
        }
        exit();
    } else {
        // Ingreso fallido, incrementar contador de intentos fallidos
        $intentosFallidos = $consul['intentos_fallidos'] + 1;
        $conexion->prepare("UPDATE usuarios SET intentos_fallidos = ? WHERE documento = ?")->execute([$intentosFallidos, $documento]);

        // Verificar si se excedió el número máximo de intentos fallidos
        if ($intentosFallidos >= 3) {
            // Cambiar estado de la cuenta a 2 (inactivo)
            $conexion->prepare("UPDATE usuarios SET id_estado = 2 WHERE documento = ?")->execute([$documento]);

            echo '<script>alert("Has excedido el número máximo de intentos fallidos. Tu cuenta ha sido bloqueada. Por favor, contacta al administrador.");</script>';
            echo '<script>window.location="../login.html"</script>';
            exit();
        }

        echo '<script>alert("Documento o contraseña incorrectos. Por favor, inténtalo de nuevo.");</script>';
        echo '<script>window.location="../login.html"</script>';
    }
} else {
    // Si no se enviaron los datos del formulario, redirigir al login
    header("Location: ../login.html");
    exit();
}
?>
