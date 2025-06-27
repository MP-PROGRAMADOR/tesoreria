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

                <form method="POST" action="api/login.php" autocomplete="off" novalidate id="loginForm">
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
