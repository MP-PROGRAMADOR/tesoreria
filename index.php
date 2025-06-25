<?php
session_start();
require 'conexion/conexion.php';

$msg = '';
$msg_type = 'danger'; // default tipo alerta: error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nombre_usuario) || empty($password)) {
        $msg = 'Por favor complete todos los campos.';
    } else {
        $stmt = $conn->prepare("SELECT Id, Nombre, Pass, Tipo_Usuario FROM usuarios WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['Pass'])) {
                $_SESSION['usuario'] = $usuario['Nombre'];
                $_SESSION['codigo'] = $usuario['Id'];
                $_SESSION['tipo'] = $usuario['Tipo_Usuario'];

                // Si quieres mostrar mensaje de éxito antes de redirigir:
                //$msg = "Bienvenido, $nombre_usuario";
                //$msg_type = 'success';

                if ($usuario['Tipo_Usuario'] === "ADMINISTRADOR") {
                    header("Location: admin/index.php");
                    exit;
                } elseif ($usuario['Tipo_Usuario'] === "USUARIO") {
                    header("Location: users/index.php");
                    exit;
                } else {
                    $msg = "Tipo de usuario no válido.";
                }
            } else {
                $msg = "Contraseña incorrecta.";
            }
        } else {
            $msg = "El usuario no existe.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<?php

require 'conexion/conexion.php';

$msg = '';
$msg_type = 'danger'; // default tipo alerta: error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_usuario = trim($_POST['nombre_usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($nombre_usuario) || empty($password)) {
        $msg = 'Por favor complete todos los campos.';
    } else {
        $stmt = $conn->prepare("SELECT Id, Nombre, Pass, Tipo_Usuario FROM usuarios WHERE Nombre = ?");
        $stmt->bind_param("s", $nombre_usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($password, $usuario['Pass'])) {
                $_SESSION['usuario'] = $usuario['Nombre'];
                $_SESSION['codigo'] = $usuario['Id'];
                $_SESSION['tipo'] = $usuario['Tipo_Usuario'];

                if ($usuario['Tipo_Usuario'] === "ADMINISTRADOR") {
                    header("Location: admin/index.php");
                    exit;
                } elseif ($usuario['Tipo_Usuario'] === "USUARIO") {
                    header("Location: users/index.php");
                    exit;
                } else {
                    $msg = "Tipo de usuario no válido.";
                }
            } else {
                $msg = "Contraseña incorrecta.";
            }
        } else {
            $msg = "El usuario no existe.";
        }
        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Tesorería General del Estado</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* Fullscreen canvas behind */
        #tsparticles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1; /* behind all */
            background: linear-gradient(135deg, #1e3c72, #2a5298); /* Azul institucional, elegante */
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2.5rem;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 400px;
            margin: auto;
            position: relative;
            top: 50%;
            transform: translateY(-50%);
        }

        .brand-logo img {
            display: block;
            margin: 0 auto 1rem auto;
            max-width: 150px;
        }

        .alert {
            font-weight: 600;
        }

        /* Botón con sombra y hover suave */
        .btn-primary {
            background-color: #264d73;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #1b3550;
        }
    </style>
</head>

<body>

    <!-- Canvas de partículas -->
    <div id="tsparticles"></div>

    <div class="login-card shadow-sm">
        <div class="brand-logo">
            <img src="images/LOGO-GRANDE.png" alt="logo" />
        </div>

        <h4 class="text-center mb-2">Hola! Bienvenid@</h4>
        <p class="text-center text-muted mb-4">Pon tus datos para continuar.</p>

        <?php if (!empty($msg)) : ?>
            <div id="message-box" class="alert alert-<?= $msg_type ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($msg) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="" autocomplete="off" novalidate>
            <div class="mb-3">
                <input type="text" class="form-control form-control-lg" id="nombre_usuario" name="nombre_usuario" placeholder="Nombre De Usuario" required />
            </div>
            <div class="mb-3">
                <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Tu Contraseña" required />
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg">ACCEDER</button>
            </div>

            <div class="text-center">
                <a href="#" class="text-decoration-none small text-primary">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- tsparticles - partículas animadas -->
    <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

    <script>
        // Configuración básica de partículas para fondo elegante
        tsParticles.load("tsparticles", {
            fpsLimit: 60,
            background: {
                color: {
                    value: "#1e3c72"
                }
            },
            particles: {
                number: {
                    value: 50,
                    density: {
                        enable: true,
                        area: 900
                    }
                },
                color: {
                    value: "#a3bffa"
                },
                shape: {
                    type: "circle"
                },
                opacity: {
                    value: 0.3,
                    random: false
                },
                size: {
                    value: 3,
                    random: { enable: true, minimumValue: 1 }
                },
                move: {
                    enable: true,
                    speed: 1,
                    direction: "none",
                    random: true,
                    straight: false,
                    outModes: "out"
                },
                links: {
                    enable: true,
                    distance: 120,
                    color: "#a3bffa",
                    opacity: 0.15,
                    width: 1
                }
            },
            detectRetina: true
        });

        // Desaparecer mensajes después de 5 segundos
        document.addEventListener('DOMContentLoaded', () => {
            const msgBox = document.getElementById('message-box');
            if (msgBox) {
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(msgBox);
                    alert.close();
                }, 5000);
            }
        });
    </script>

</body>

</html>
