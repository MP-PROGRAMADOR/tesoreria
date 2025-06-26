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
