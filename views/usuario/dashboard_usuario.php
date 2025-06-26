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