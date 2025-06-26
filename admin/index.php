<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tesorería General del Estado</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Tu CSS actual aquí */
        :root {
            --primary-color: #2c5aa0;
            --secondary-color: #34495e;
            --accent-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --dark-color: #2c3e50;
            --light-color: #ecf0f1;
            --sidebar-width: 280px;
            --sidebar-collapsed: 80px;
            --navbar-height: 70px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            height: var(--navbar-height);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            color: white !important;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .navbar-toggler {
            border: none;
            color: white;
            font-size: 1.5rem;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--navbar-height));
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            z-index: 1020;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed);
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            text-align: center;
        }

        .sidebar.collapsed .sidebar-header {
            padding: 20px 10px;
        }

        .logo-text {
            font-size: 0.9rem;
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }

        /* Menu Sections */
        .menu-section {
            margin: 20px 0;
        }

        .menu-title {
            padding: 10px 20px 5px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .menu-title {
            display: none;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: #495057;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 0;
            margin: 2px 10px;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px;
            margin: 2px 5px;
        }

        .nav-link:hover {
            background: linear-gradient(135deg, var(--accent-color), #5dade2);
            color: white;
            transform: translateX(5px);
            border-radius: 8px;
        }

        .sidebar.collapsed .nav-link:hover {
            transform: none;
        }

        .nav-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border-radius: 8px;
        }

        .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
        }

        .nav-link span {
            transition: all 0.3s ease;
        }

        .sidebar.collapsed .nav-link span {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--navbar-height);
            padding: 30px;
            transition: all 0.3s ease;
            min-height: calc(100vh - var(--navbar-height));
        }

        .main-content.expanded {
            margin-left: var(--sidebar-collapsed);
        }

        /* Stats Cards */
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            border: none;
            overflow: hidden;
            position: relative;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 15px;
        }

        .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Recent Activity */
        .activity-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .activity-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 20px;
            font-weight: 600;
        }

        .activity-item {
            padding: 15px 20px;
            border-bottom: 1px solid #f8f9fa;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: #f8f9fa;
        }

        .activity-item:last-child {
            border-bottom: none;
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
            
            .main-content.expanded {
                margin-left: 0;
            }
        }

        /* Profile dropdown */
        .profile-dropdown {
            position: relative;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255,255,255,0.3);
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg) }
        }

        /* Custom scrollbar for main content */
        .main-content::-webkit-scrollbar {
            width: 8px;
        }

        .main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 4px;
        }

        /* Estilos específicos para las tablas de datos */
        .data-table-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 25px;
            margin-top: 20px;
            overflow-x: auto; /* Para tablas grandes */
        }
        .data-table-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table-container th, .data-table-container td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        .data-table-container th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 600;
        }
        .data-table-container tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .data-table-container tr:hover {
            background-color: #f1f1f1;
        }
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .pagination-controls button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .pagination-controls button:hover:not(:disabled) {
            background-color: var(--accent-color);
        }
        .pagination-controls button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }
        .search-input {
            width: 250px;
            padding: 8px 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <button class="btn text-white me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="#">
                <i class="fas fa-university me-2"></i>
                Tesorería General del Estado
            </a>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown profile-dropdown">
                    <button class="btn dropdown-toggle text-white d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='40' height='40' viewBox='0 0 40 40'%3E%3Ccircle cx='20' cy='20' r='20' fill='%23007bff'/%3E%3Ctext x='20' y='26' text-anchor='middle' fill='white' font-size='16' font-weight='bold'%3EAdmin%3C/text%3E%3C/svg%3E" 
                            class="profile-img me-2" alt="Avatar">
                        <span id="userNameDisplay">Administrador</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Perfil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Configuración</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="logo-text">Sistema de Gestión Documental</div>
        </div>

        <div class="menu-section">
            <div class="menu-title">Panel Principal</div>
            <a href="#" class="nav-link active" data-section="dashboard">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Gestión Documental</div>
            <a href="#" class="nav-link" data-section="entradas">
                <i class="fas fa-inbox"></i>
                <span>Documentos de Entrada</span>
            </a>
            <a href="#" class="nav-link" data-section="salidas">
                <i class="fas fa-paper-plane"></i>
                <span>Documentos de Salida</span>
            </a>
            <a href="#" class="nav-link" data-section="decretos">
                <i class="fas fa-scroll"></i>
                <span>Decretos</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Gestión Financiera</div>
            <a href="#" class="nav-link" data-section="pagos">
                <i class="fas fa-credit-card"></i>
                <span>Pagos</span>
            </a>
            <a href="#" class="nav-link" data-section="bancos">
                <i class="fas fa-university"></i>
                <span>Bancos</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Organización</div>
            <a href="#" class="nav-link" data-section="instituciones">
                <i class="fas fa-building"></i>
                <span>Instituciones</span>
            </a>
            <a href="#" class="nav-link" data-section="departamentos">
                <i class="fas fa-sitemap"></i>
                <span>Departamentos</span>
            </a>
            <a href="#" class="nav-link" data-section="miembros">
                <i class="fas fa-users"></i>
                <span>Miembros</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Administración</div>
            <a href="#" class="nav-link" data-section="usuarios">
                <i class="fas fa-user-cog"></i>
                <span>Usuarios</span>
            </a>
            <a href="#" class="nav-link" data-section="referencias">
                <i class="fas fa-tags"></i>
                <span>Referencias</span>
            </a>
        </div>

        <div class="menu-section">
            <div class="menu-title">Reportes</div>
            <a href="#" class="nav-link" data-section="reportes">
                <i class="fas fa-chart-bar"></i>
                <span>Estadísticas</span>
            </a>
            <a href="#" class="nav-link" data-section="auditoria">
                <i class="fas fa-clipboard-list"></i>
                <span>Auditoría</span>
            </a>
        </div>
    </nav>

    <main class="main-content" id="mainContent">
        <div id="contentArea">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    <p class="text-muted">Panel de control general del sistema</p>
                </div>
                <div class="text-end">
                    <small class="text-muted">Última actualización</small><br>
                    <span id="lastUpdate" class="fw-bold">Cargando...</span>
                </div>
            </div>

            <div class="row mb-4" id="statsCards">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stats-number" id="totalEntradas">
                                    <div class="loading"></div>
                                </div>
                                <div class="stats-label">Documentos de Entrada</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stats-number" id="totalSalidas">
                                    <div class="loading"></div>
                                </div>
                                <div class="stats-label">Documentos de Salida</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stats-number" id="totalPagos">
                                    <div class="loading"></div>
                                </div>
                                <div class="stats-label">Pagos Registrados</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="d-flex align-items-center">
                            <div class="stats-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="ms-3">
                                <div class="stats-number" id="totalUsuarios">
                                    <div class="loading"></div>
                                </div>
                                <div class="stats-label">Usuarios Activos</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="activity-card">
                        <div class="activity-header">
                            <i class="fas fa-clock me-2"></i>
                            Actividad Reciente
                        </div>
                        <div id="recentActivity">
                            <div class="text-center p-4">
                                <div class="loading"></div>
                                <p class="mt-2 text-muted">Cargando actividades...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="activity-card">
                        <div class="activity-header">
                            <i class="fas fa-chart-pie me-2"></i>
                            Resumen por Tipo
                        </div>
                        <div class="p-3" id="documentTypes">
                            <div class="text-center p-4">
                                <div class="loading"></div>
                                <p class="mt-2 text-muted">Cargando datos...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    <script src="../app/admin.js"></script> </body>
</html>