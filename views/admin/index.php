<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    // No ha iniciado sesión → redirigir a login
    header("Location: index.php?vista=login");
    exit;
}

// Ya está logueado → redirigir al dashboard correspondiente
$rol = $_SESSION['usuario']['tipo_usuario'] ?? '';

switch ($rol) {
    case 'administrador':
        header("Location: index.php?vista=dashboard_administrador");
        break;
    case 'usuario':
        header("Location: index.php?vista=dashboard_usuario");
        break;
    default:
        // Rol no reconocido → cerrar sesión y redirigir a login
        session_destroy();
        header("Location: index.php?vista=login");
        break;
}
exit;
