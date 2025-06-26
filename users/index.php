<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Profesional - Sistema de Gestión</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <style>
        :root {
            --primary-color: #6366f1;
            --secondary-color: #8b5cf6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --dark-color: #1f2937;
            --light-color: #f8fafc;
            --gradient-primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --gradient-success: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            --gradient-warning: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --gradient-info: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: var(--dark-color);
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-xl);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo {
            width: 40px;
            height: 40px;
            background: var(--gradient-primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 0.875rem 1rem;
            color: #64748b;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
            transform: translateX(4px);
        }

        .nav-link.active {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .nav-icon {
            font-size: 1.25rem;
            width: 24px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .main-content.expanded {
            margin-left: 80px;
        }

        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem 2rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .welcome-section h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .welcome-section p {
            color: #64748b;
            font-size: 0.95rem;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 1rem;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-profile:hover {
            background: rgba(99, 102, 241, 0.2);
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--gradient-primary);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .stat-card.success::before {
            background: var(--gradient-success);
        }

        .stat-card.warning::before {
            background: var(--gradient-warning);
        }

        .stat-card.info::before {
            background: var(--gradient-info);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stat-icon.primary {
            background: var(--gradient-primary);
        }

        .stat-icon.success {
            background: var(--gradient-success);
        }

        .stat-icon.warning {
            background: var(--gradient-warning);
        }

        .stat-icon.info {
            background: var(--gradient-info);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            color: #64748b;
            font-weight: 500;
            font-size: 0.875rem;
        }

        /* Chart Cards */
        .chart-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .chart-header {
            display: flex;
            align-items: center;
            justify-content: between;
            margin-bottom: 2rem;
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .chart-subtitle {
            color: #64748b;
            font-size: 0.875rem;
        }

        /* Activity Feed */
        .activity-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            height: fit-content;
        }

        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
            color: white;
            flex-shrink: 0;
        }

        .activity-content h6 {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.25rem;
        }

        .activity-content p {
            color: #64748b;
            font-size: 0.8rem;
            margin: 0;
        }

        /* Progress Bars */
        .progress-modern {
            height: 8px;
            border-radius: 50px;
            background: rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .progress-bar-modern {
            height: 100%;
            border-radius: 50px;
            background: var(--gradient-primary);
            transition: width 0.6s ease;
        }

        .progress-bar-modern.success {
            background: var(--gradient-success);
        }

        .progress-bar-modern.warning {
            background: var(--gradient-warning);
        }

        /* Buttons */
        .btn-modern {
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-modern {
            background: var(--gradient-primary);
            color: white;
            box-shadow: var(--shadow-md);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 1rem;
            }

            .header {
                padding: 1rem;
            }
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark-color);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .sidebar-toggle:hover {
            background: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo">SG</div>
            <div class="d-flex flex-column">
                <h6 class="mb-0 fw-bold">Sistema de Gestión</h6>
                <small class="text-muted">Panel de Control</small>
            </div>
        </div>
        
        <nav class="sidebar-nav">
            <div class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-folder-plus"></i>
                    <span>Entradas</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-folder-minus"></i>
                    <span>Salidas</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-file-earmark-text"></i>
                    <span>Decretos</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon bi bi-graph-up"></i>
                    <span>Reportes</span>
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="d-flex align-items-center gap-3">
                    <button class="sidebar-toggle d-md-none" onclick="toggleSidebar()">
                        <i class="bi bi-list"></i>
                    </button>
                    <div class="welcome-section">
                        <h1>Buenos días, <span class="text-primary">Usuario</span></h1>
                        <p>Bienvenido de vuelta a tu panel de control</p>
                    </div>
                </div>
                
                <div class="header-actions">
                    <div class="user-profile">
                        <div class="avatar">U</div>
                        <div class="d-none d-md-block">
                            <div class="fw-semibold">Usuario Admin</div>
                            <small class="text-muted">Administrador</small>
                        </div>
                    </div>
                    <button class="btn btn-primary-modern">
                        <i class="bi bi-box-arrow-right"></i>
                        Cerrar Sesión
                    </button>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="container-fluid p-4">
            <!-- Stats Cards -->
            <div class="stats-grid fade-in-up">
                <div class="stat-card">
                    <div class="stat-icon primary">
                        <i class="bi bi-folder-plus"></i>
                    </div>
                    <div class="stat-value" id="entradas">45</div>
                    <div class="stat-label">Entradas</div>
                </div>
                
                <div class="stat-card success">
                    <div class="stat-icon success">
                        <i class="bi bi-folder-minus"></i>
                    </div>
                    <div class="stat-value" id="salidas">32</div>
                    <div class="stat-label">Salidas</div>
                </div>
                
                <div class="stat-card warning">
                    <div class="stat-icon warning">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div class="stat-value" id="decretos">18</div>
                    <div class="stat-label">Decretos</div>
                </div>
                
                <div class="stat-card info">
                    <div class="stat-icon info">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                    <div class="stat-value" id="fecha">26/06</div>
                    <div class="stat-label">Fecha Actual</div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="chart-card fade-in-up">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">📈 Estadísticas Anuales</h3>
                                <p class="chart-subtitle">Comparativa de entradas y salidas por mes</p>
                            </div>
                        </div>
                        <div style="height: 400px;">
                            <canvas id="mainChart"></canvas>
                        </div>
                    </div>

                    <!-- Progress Table -->
                    <div class="chart-card fade-in-up">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">👤 Progreso de Usuario</h3>
                                <p class="chart-subtitle">Estadísticas detalladas de rendimiento</p>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Usuario</th>
                                        <th>Departamento</th>
                                        <th>Entradas</th>
                                        <th>Salidas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar">U</div>
                                                <div>
                                                    <div class="fw-semibold">Usuario Principal</div>
                                                    <small class="text-muted">Administrador</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">Administración</span>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <small class="text-success fw-semibold">78%</small>
                                                <small class="text-muted float-end">45/58</small>
                                            </div>
                                            <div class="progress-modern">
                                                <div class="progress-bar-modern success" style="width: 78%"></div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <small class="text-warning fw-semibold">65%</small>
                                                <small class="text-muted float-end">32/49</small>
                                            </div>
                                            <div class="progress-modern">
                                                <div class="progress-bar-modern warning" style="width: 65%"></div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Pie Chart -->
                    <div class="chart-card fade-in-up">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">🧮 Distribución</h3>
                                <p class="chart-subtitle">Entradas vs Salidas</p>
                            </div>
                        </div>
                        <div style="height: 250px;">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="activity-card fade-in-up">
                        <div class="chart-header">
                            <div>
                                <h3 class="chart-title">📋 Actividad Reciente</h3>
                                <p class="chart-subtitle">Últimos registros</p>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: var(--gradient-success);">
                                <i class="bi bi-plus"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Nueva Entrada</h6>
                                <p>Documento registrado - Oficio 2024-001</p>
                                <small class="text-muted">Hace 15 minutos</small>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: var(--gradient-warning);">
                                <i class="bi bi-minus"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Nueva Salida</h6>
                                <p>Documento procesado - Memo 2024-089</p>
                                <small class="text-muted">Hace 1 hora</small>
                            </div>
                        </div>
                        
                        <div class="activity-item">
                            <div class="activity-icon" style="background: var(--gradient-info);">
                                <i class="bi bi-file-earmark"></i>
                            </div>
                            <div class="activity-content">
                                <h6>Decreto Generado</h6>
                                <p>Decreto 2024-045 creado</p>
                                <small class="text-muted">Hace 2 horas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('show');
        }

        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Main Chart
            const ctx = document.getElementById('mainChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                    datasets: [{
                        label: 'Entradas',
                        data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }, {
                        label: 'Salidas',
                        data: [8, 15, 12, 20, 18, 25, 22, 28, 26, 32, 30, 35],
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });

            // Pie Chart
            const pieCtx = document.getElementById('pieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Entradas', 'Salidas'],
                    datasets: [{
                        data: [45, 32],
                        backgroundColor: [
                            '#6366f1',
                            '#10b981'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    }
                }
            });

            // Update time
            function updateTime() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('es-ES', { 
                    hour: '2-digit', 
                    minute: '2-digit' 
                });
                const dateString = now.toLocaleDateString('es-ES', {
                    day: '2-digit',
                    month: '2-digit'
                });
                
                document.getElementById('fecha').textContent = dateString;
            }

            updateTime();
            setInterval(updateTime, 60000);

            // Add fade-in animation to elements
            const elements = document.querySelectorAll('.fade-in-up');
            elements.forEach((el, index) => {
                el.style.animationDelay = `${index * 0.1}s`;
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (window.innerWidth <= 768 && !sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>