<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function verificarAcceso($vista)
{
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?vista=login");
        exit;
    }

    $rol = $_SESSION['usuario']['tipo_usuario'];

    $permisos = [
        'administrador' => [
            'dashboard_administrador',
            'usuarios',
            'entradas',
            'salidas',
            'pagos',
            'decretos',
            'miembros',
            'referencias',
            'instituciones',
            'departamentos',
            'personas',
            'reportes'
        ],
        'usuario' => [
            'dashboard_usuario',
            'entradas',
            'salidas',
            'decretos',
            'pagos'
        ]
    ];

    $dashboards = [
        'administrador' => 'dashboard_administrador',
        'usuario' => 'dashboard_usuario'
    ];

    if (!preg_match('/^[a-zA-Z0-9_]+$/', $vista)) {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'La vista solicitada no es válida.'];
        header("Location: index.php?vista=" . ($dashboards[$rol] ?? 'login'));
        exit;
    }

    if (!isset($permisos[$rol]) || !in_array($vista, $permisos[$rol])) {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'No tienes permiso para acceder a esta vista.'];
        header("Location: index.php?vista=" . ($dashboards[$rol] ?? 'login'));
        exit;
    }
}



/**
 * Verifica el acceso del usuario autenticado, su rol y conexión a la base de datos.
 *
 * @param array $rolesPermitidos Lista de roles válidos (ej: ['admin', 'archivista'])
 * @param PDO $pdo Instancia de la conexión PDO
 */
function ValidarAcceso(array $rolesPermitidos, PDO $pdo)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (empty($_SESSION['usuario'])) {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'Debes iniciar sesión.'];
        header('Location: index.php?vista=login');
        exit;
    }

    $rolUsuario = $_SESSION['usuario']['tipo_usuario'];

    if (!in_array($rolUsuario, $rolesPermitidos)) {
        $_SESSION['alerta'] = ['tipo' => 'warning', 'mensaje' => 'Acceso denegado.'];
        header('Location: index.php?vista=login');
        exit;
    }

    if (!$pdo instanceof PDO) {
        $_SESSION['alerta'] = ['tipo' => 'danger', 'mensaje' => 'Error de conexión a la base de datos.'];
        header('Location: index.php?vista=login');
        exit;
    }
}

