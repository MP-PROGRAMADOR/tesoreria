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
    <title>Acceso Seguro - Tesorería General del Estado</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #1a365d;
            --secondary-color: #2d5a87;
            --accent-color: #3182ce;
            --success-color: #38a169;
            --warning-color: #ed8936;
            --danger-color: #e53e3e;
            --light-bg: #f7fafc;
            --white: #ffffff;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 50%, var(--accent-color) 100%);
            overflow: hidden;
        }

        /* Animated background particles */
        #particles-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        /* Main container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            position: relative;
        }

        /* Login card */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 0;
            width: 100%;
            max-width: 440px;
            box-shadow: var(--shadow-xl);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            position: relative;
        }

        .login-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            color: white;
            position: relative;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"><g fill="none" fill-rule="evenodd"><g fill="%23ffffff" fill-opacity="0.05"><circle cx="30" cy="30" r="1"/></g></svg>') repeat;
        }

        .brand-logo {
            position: relative;
            z-index: 2;
        }

        .brand-logo img {
            max-width: 120px;
            height: auto;
            margin-bottom: 1rem;
            /* Removido el filtro para mantener colores originales del logo */
        }

        .login-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 2;
        }

        .login-subtitle {
            font-size: 1rem;
            opacity: 0.9;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }

        .login-body {
            padding: 2.5rem 2rem;
        }

        /* Form styles */
        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--text-primary);
            background-color: var(--white);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        }

        .form-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 1.125rem;
            z-index: 3;
        }

        .btn-login {
            width: 100%;
            padding: 0.875rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border: none;
            border-radius: 12px;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        /* Alert styles */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            font-weight: 500;
            position: relative;
        }

        .alert-danger {
            background-color: rgba(229, 62, 62, 0.1);
            color: var(--danger-color);
            border-left: 4px solid var(--danger-color);
        }

        .alert-success {
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        /* Forgot password link */
        .forgot-password {
            display: block;
            text-align: center;
            color: var(--accent-color);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 1.5rem;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Footer */
        .login-footer {
            background-color: rgba(247, 250, 252, 0.8);
            padding: 1.5rem 2rem;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }

        .footer-text {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        /* Responsive design */
        @media (max-width: 480px) {
            .login-container {
                padding: 1rem;
            }
            
            .login-header {
                padding: 2rem 1.5rem 1.5rem;
            }
            
            .login-body {
                padding: 2rem 1.5rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
        }

        /* Loading animation */
        .loading {
            position: relative;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Security badge */
        .security-badge {
            display: inline-flex;
            align-items: center;
            background-color: rgba(56, 161, 105, 0.1);
            color: var(--success-color);
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 1rem;
        }

        .security-badge i {
            margin-right: 0.375rem;
        }
    </style>
</head>

<body>
    <!-- Animated background -->
    <div id="particles-background"></div>

    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <div class="brand-logo">
                    <img src="images/LOGO-GRANDE.png" alt="Tesorería General del Estado" />
                </div>
                <h1 class="login-title">Acceso Seguro</h1>
                <p class="login-subtitle">Sistema de Gestión Institucional</p>
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i>
                    Conexión Segura SSL
                </div>
            </div>

            <!-- Body -->
            <div class="login-body">
                <?php if (!empty($msg)) : ?>
                    <div id="message-box" class="alert alert-<?= $msg_type ?> alert-dismissible fade show" role="alert">
                        <i class="fas fa-<?= $msg_type === 'danger' ? 'exclamation-triangle' : 'check-circle' ?> me-2"></i>
                        <?= htmlspecialchars($msg) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" autocomplete="off" novalidate id="loginForm">
                    <div class="form-group">
                        <label for="nombre_usuario" class="form-label">
                            <i class="fas fa-user me-1"></i>
                            Nombre de Usuario
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-user form-icon"></i>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="nombre_usuario" 
                                name="nombre_usuario" 
                                placeholder="Ingrese su nombre de usuario"
                                value="<?= htmlspecialchars($_POST['nombre_usuario'] ?? '') ?>"
                                required 
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i>
                            Contraseña
                        </label>
                        <div class="position-relative">
                            <i class="fas fa-lock form-icon"></i>
                            <input 
                                type="password" 
                                class="form-control" 
                                id="password" 
                                name="password" 
                                placeholder="Ingrese su contraseña"
                                required 
                            />
                        </div>
                    </div>

                    <button type="submit" class="btn btn-login" id="loginBtn">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        INICIAR SESIÓN
                    </button>

                    <a href="#" class="forgot-password">
                        <i class="fas fa-question-circle me-1"></i>
                        ¿Olvidaste tu contraseña?
                    </a>
                </form>
            </div>

            <!-- Footer -->
            <div class="login-footer">
                <p class="footer-text mb-0">
                    <i class="fas fa-copyright me-1"></i>
                    <?= date('Y') ?> Tesorería General del Estado. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Particles.js for animated background -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

    <script>
        // Initialize particles background
        particlesJS('particles-background', {
            particles: {
                number: {
                    value: 80,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: '#ffffff'
                },
                shape: {
                    type: 'circle',
                    stroke: {
                        width: 0,
                        color: '#000000'
                    }
                },
                opacity: {
                    value: 0.1,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.1,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: false,
                    straight: false,
                    out_mode: 'out',
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: {
                        enable: true,
                        mode: 'repulse'
                    },
                    onclick: {
                        enable: true,
                        mode: 'push'
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 400,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 400,
                        size: 40,
                        duration: 2,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });

        // Form handling
        document.addEventListener('DOMContentLoaded', function() {
            const loginForm = document.getElementById('loginForm');
            const loginBtn = document.getElementById('loginBtn');
            const messageBox = document.getElementById('message-box');

            // Auto-hide alert messages
            if (messageBox) {
                setTimeout(() => {
                    const alert = bootstrap.Alert.getOrCreateInstance(messageBox);
                    alert.close();
                }, 5000);
            }

            // Form submission with loading state
            loginForm.addEventListener('submit', function(e) {
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
                loginBtn.innerHTML = '<span class="opacity-0">INICIAR SESIÓN</span>';
                
                // Re-enable if there's an error (form doesn't redirect)
                setTimeout(() => {
                    loginBtn.classList.remove('loading');
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>INICIAR SESIÓN';
                }, 3000);
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.querySelector('.form-icon').style.color = '#3182ce';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.querySelector('.form-icon').style.color = '#718096';
                });
            });

            // Auto-focus first input
            const firstInput = document.getElementById('nombre_usuario');
            if (firstInput && !firstInput.value) {
                firstInput.focus();
            }
        });

        // Security enhancement: Clear form data on page unload
        window.addEventListener('beforeunload', function() {
            document.getElementById('password').value = '';
        });
    </script>

</body>

</html>