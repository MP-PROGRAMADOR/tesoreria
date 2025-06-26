<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once('../config/conexion.php');
include_once('../helpers/auth.php');

// Verificar método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Método no permitido.'];
    header('Location: ../index.php?vista=login');
    exit;
}

// Capturar y limpiar los datos enviados desde el formulario
$usuario = isset($_POST['nombre_usuario']) ? trim($_POST['nombre_usuario']) : '';
$contrasena = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validaciones básicas
if (empty($usuario)) {
    $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'Se requiere el nombre de usuario.'];
    header('Location: ../index.php?vista=login');
    exit;
}

if (empty($contrasena)) {
    $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'Se requiere la contraseña.'];
    header('Location: ../index.php?vista=login');
    exit;
}

// Intentar iniciar sesión
if (login($pdo, $usuario, $contrasena)) {
    $rol = $_SESSION['usuario']['tipo_usuario'];

    // Redirección según el tipo de usuario
    $vistaDashboard = ($rol === 'administrador') ? 'dashboard_administrador' : 'dashboard_usuario';

    header("Location: ../index.php?vista={$vistaDashboard}");
    exit;
} else {
    // Login fallido, redirigir con mensaje
    header('Location: ../index.php?vista=login');
    exit;
}
