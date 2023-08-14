    <?php

    // Verificamos si la sesión no ha sido iniciada o si faltan variables de sesión
    if (!isset($_SESSION['document']) || !isset($_SESSION['roles'])) {
        // Redireccionamos al inicio de sesión o página de login
        header("location: login.html");
        exit;
    }