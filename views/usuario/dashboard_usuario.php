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