<?php
// Verificar si la sesión ya está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


/**
 * Login específico para Internos.
 * Busca en la tabla `usuarios` usando un campo `usuario` y `password_hash`.
 */
function login($pdo, $usuario, $contrasena)
{
    $sql = "SELECT 
                Id,
                Nombre,
                Pass,
                Foto,
                Dpto,
                Tipo_Usuario
            FROM usuarios
            WHERE Nombre = ?
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($contrasena, $user['Pass'])) {
        $_SESSION['usuario'] = [
            'id' => $user['Id'],
            'nombre' => $user['Nombre'],
            'tipo_usuario' => strtolower($user['Tipo_Usuario']),
            'dpto' => $user['Dpto'],
            'foto' => $user['Foto'] ? base64_encode($user['Foto']) : null
        ];

        $_SESSION['alerta'] = [
            'tipo' => 'success',
            'mensaje' => 'Inicio de sesión exitoso.'
        ];

        return true;
    }

    $_SESSION['alerta'] = [
        'tipo' => 'danger',
        'mensaje' => 'Usuario o contraseña incorrectos.'
    ];

    return false;
}

/**
 * Destruccion del login.
 *    .
 */
function logout()
{
    session_unset();
    session_destroy();

    header('Location: index.php?vista=login');
    exit;
}


