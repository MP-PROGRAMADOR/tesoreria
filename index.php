<?php 
if (session_status() === PHP_SESSION_NONE) { 
    session_start();
}

require_once 'config/conexion.php';
require_once 'helpers/permisos.php';
require_once 'helpers/auth.php';

$publicas = ['login'];  // vistas públicas

$vista = $_GET['vista'] ?? 'dashboard_administrador';

if (in_array($vista, $publicas)) {
    // --- VISTA PÚBLICA ---
    include 'layout/headerLogin.php';
    include "{$vista}.php";
    include 'layout/footerLogin.php';

} else {
    // --- VISTA PRIVADA (requiere sesión y permisos) ---
    verificarAcceso($vista);

    $rol = $_SESSION['usuario']['tipo_usuario'] ?? '';

    if ($rol === 'administrador') {
        // Layout del administrador
        include 'layout/admin/header.php'; 
        include 'layout/admin/sidebar.php';
        include 'layout/admin/navbar.php';
        include "views/admin/{$vista}.php";
        include 'layout/admin/footer.php';

    } elseif ($rol === 'usuario') {
        // Layout del usuario
        include 'layout/usuario/header.php'; 
        include 'layout/usuario/sidebar.php';
        include 'layout/usuario/navbar.php';
        include "views/usuario/{$vista}.php";
        include 'layout/usuario/footer.php';

    } else {
        // Rol no permitido
        $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Tu rol no tiene acceso.'];
        header("Location: index.php?vista=login");
        exit;
    }
}
