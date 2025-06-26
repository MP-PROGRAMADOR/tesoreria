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