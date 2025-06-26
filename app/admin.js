// Variables globales
let sidebarCollapsed = false;
let currentSection = 'dashboard';

// Paginación y búsqueda
const ITEMS_PER_PAGE = 10;
let currentPage = 1;
let currentSearchTerm = '';
let currentSortColumn = '';
let currentSortDirection = 'asc'; // 'asc' o 'desc'

// Mapeo de secciones a rutas de API y funciones de renderizado
const sectionConfig = {
    'dashboard': {
        api: null, // Dashboard carga múltiples APIs
        render: renderDashboardContent
    },
    'entradas': {
        label: 'Documentos de Entrada',
        api: 'entradas.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'NumRegistro', label: 'Nº Registro' },
            { key: 'FechaRegistro', label: 'Fecha Registro' },
            { key: 'TipoDoc', label: 'Tipo Documento' },
            { key: 'Descripcion', label: 'Descripción' },
            { key: 'NombreUsuario', label: 'Usuario' },
            { key: 'NombreReferencia', label: 'Referencia' },
            { key: 'Archivo', label: 'Archivo' } // Incluido para visualizar, pero la descarga es un botón
        ],
        formFields: [ // Campos para el formulario de CRUD
            { id: 'NumRegistro', label: 'Nº Registro', type: 'text', required: true, maxlen: 8 },
            { id: 'FechaRegistro', label: 'Fecha Registro', type: 'date', required: true },
            { id: 'TipoDoc', label: 'Tipo Documento', type: 'text', required: true, maxlen: 50 },
            // { id: 'Archivo', label: 'Archivo', type: 'file' }, // Para subida de archivos, más complejo
            { id: 'Descripcion', label: 'Descripción', type: 'textarea' },
            { id: 'PalabrasClaves', label: 'Palabras Clave', type: 'textarea' },
            { id: 'FechaFirma', label: 'Fecha Firma', type: 'date' },
            { id: 'Importe', label: 'Importe', type: 'text' }, // Podría ser 'number' o 'text' para formato específico
            { id: 'Referencia', label: 'Referencia', type: 'select', api: 'referencias.php', valueKey: 'Id', labelKey: 'Nombre' },
            { id: 'Usuario', label: 'Usuario', type: 'select', api: 'usuarios.php', valueKey: 'Id', labelKey: 'Nombre' }
        ]
    },
    'salidas': {
        label: 'Documentos de Salida',
        api: 'salidas.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'NumRegistro', label: 'Nº Registro' },
            { key: 'FechaRegistro', label: 'Fecha Registro' },
            { key: 'TipoDoc', label: 'Tipo Documento' },
            { key: 'Descripcion', label: 'Descripción' },
            { key: 'PalabrasClaves', label: 'Palabras Clave' },
            { key: 'FechaFirma', label: 'Fecha Firma' },
            { key: 'Importe', label: 'Importe' },
            { key: 'EntradaRelacionada', label: 'Doc. Entrada' }, // Campo 'Entrada' de la tabla 'salidas'
            { key: 'NombreReferencia', label: 'Referencia' }, // Viene de la tabla 'referencias'
            { key: 'NombreUsuario', label: 'Usuario' }, // Viene de la tabla 'usuarios'
            { key: 'Archivo', label: 'Archivo' } // Incluido para visualizar
        ],
        formFields: [
            { id: 'NumRegistro', label: 'Nº Registro', type: 'text', required: true, maxlen: 8 },
            { id: 'FechaRegistro', label: 'Fecha Registro', type: 'date', required: true },
            { id: 'TipoDoc', label: 'Tipo Documento', type: 'text', required: true, maxlen: 50 },
            // { id: 'Archivo', label: 'Archivo', type: 'file' },
            { id: 'Descripcion', label: 'Descripción', type: 'textarea' },
            { id: 'PalabrasClaves', label: 'Palabras Clave', type: 'textarea' },
            { id: 'FechaFirma', label: 'Fecha Firma', type: 'date' },
            { id: 'Importe', label: 'Importe', type: 'text' },
            { id: 'Entrada', label: 'Doc. Entrada (ID)', type: 'number' }, // Asumiendo ID numérico
            { id: 'Referencia', label: 'Referencia', type: 'select', api: 'referencias.php', valueKey: 'Id', labelKey: 'Nombre' },
            { id: 'Usuario', label: 'Usuario', type: 'select', api: 'usuarios.php', valueKey: 'Id', labelKey: 'Nombre' }
        ]
    },
    'decretos': {
        label: 'Decretos',
        api: 'decretos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Descripcion', label: 'Descripción' },
            { key: 'Fecha', label: 'Fecha' },
            { key: 'Archivo', label: 'Archivo' },
            { key: 'DocEntrada', label: 'Doc. Entrada ID' }
        ],
        formFields: [
            { id: 'Descripcion', label: 'Descripción', type: 'textarea', required: true },
            { id: 'Fecha', label: 'Fecha', type: 'date', required: true },
            { id: 'Archivo', label: 'Archivo', type: 'text', maxlen: 15 },
            { id: 'DocEntrada', label: 'Doc. Entrada ID', type: 'number' }
        ]
    },
    'pagos': {
        label: 'Pagos',
        api: 'pagos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'NumRegistro', label: 'Nº Registro' },
            { key: 'Concepto', label: 'Concepto' },
            { key: 'Cantidad', label: 'Cantidad' },
            { key: 'FechaFirma', label: 'Fecha Firma' },
            { key: 'Beneficiario', label: 'Beneficiario' },
            { key: 'NombreBanco', label: 'Banco' }, // Nombre del banco
            { key: 'NombreUsuario', label: 'Usuario' } // Nombre del usuario
        ],
        formFields: [
            { id: 'NumRegistro', label: 'Nº Registro', type: 'text', required: true, maxlen: 10 },
            { id: 'Concepto', label: 'Concepto', type: 'text', required: true, maxlen: 255 },
            { id: 'Descripcion', label: 'Descripción', type: 'textarea', required: true },
            { id: 'FechaFirma', label: 'Fecha Firma', type: 'date', required: true },
            { id: 'Cantidad', label: 'Cantidad', type: 'number', step: '0.01', required: true },
            { id: 'Archivo', label: 'Archivo', type: 'text', maxlen: 255 }, // Manejo de archivos separado
            { id: 'Usuario', label: 'Usuario', type: 'select', api: 'usuarios.php', valueKey: 'Id', labelKey: 'Nombre' },
            { id: 'Beneficiario', label: 'Beneficiario', type: 'text', required: true, maxlen: 255 },
            { id: 'Banco', label: 'Banco', type: 'select', api: 'bancos.php', valueKey: 'Id', labelKey: 'Nombre' }
        ]
    },
    'bancos': {
        label: 'Bancos',
        api: 'bancos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre del Banco', type: 'text', required: true, maxlen: 255 }
        ]
    },
    'instituciones': {
        label: 'Instituciones',
        api: 'instituciones.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Nombre_Corto', label: 'Nombre Corto' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre de la Institución', type: 'text', required: true, maxlen: 100 },
            { id: 'Nombre_Corto', label: 'Nombre Corto', type: 'text', maxlen: 10 }
        ]
    },
    'departamentos': {
        label: 'Departamentos',
        api: 'departamentos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Telefono', label: 'Teléfono' },
            { key: 'Email', label: 'Email' },
            { key: 'NombreInstitucion', label: 'Institución' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre del Departamento', type: 'text', required: true, maxlen: 80 },
            { id: 'Telefono', label: 'Teléfono', type: 'text', maxlen: 15 },
            { id: 'Email', label: 'Email', type: 'email', maxlen: 100 },
            { id: 'Institucion', label: 'Institución', type: 'select', api: 'instituciones.php', valueKey: 'Id', labelKey: 'Nombre' }
        ]
    },
    'miembros': {
        label: 'Miembros',
        api: 'miembros.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'NombreDepartamento', label: 'Departamento' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre del Miembro', type: 'text', required: true, maxlen: 60 },
            { id: 'Dpto', label: 'Departamento', type: 'select', api: 'departamentos.php', valueKey: 'Id', labelKey: 'Nombre' }
        ]
    },
    'usuarios': {
        label: 'Usuarios',
        api: 'usuarios.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'NombreDepartamento', label: 'Departamento' },
            { key: 'Tipo_Usuario', label: 'Tipo Usuario' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre de Usuario', type: 'text', required: true, maxlen: 50 },
            { id: 'Pass', label: 'Contraseña', type: 'password', required: true, maxlen: 100, addOnly: true }, // addOnly para no mostrar en edición
            { id: 'Dpto', label: 'Departamento', type: 'select', api: 'departamentos.php', valueKey: 'Id', labelKey: 'Nombre' },
            { id: 'Tipo_Usuario', label: 'Tipo de Usuario', type: 'select', options: ['Administrador', 'Editor', 'Visualizador'], required: true, maxlen: 15 }
        ]
    },
    'referencias': {
        label: 'Referencias',
        api: 'referencias.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Codigo', label: 'Código' }
        ],
        formFields: [
            { id: 'Nombre', label: 'Nombre de la Referencia', type: 'text', required: true, maxlen: 100 },
            { id: 'Codigo', label: 'Código', type: 'text', required: true, maxlen: 10 }
        ]
    },
};


// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
    setupEventListeners();
    // Carga inicial del dashboard
    navigateToSection('dashboard');
    setupModals(); // Configurar los modales de Bootstrap
});

function initializeDashboard() {
    updateLastUpdateTime();
    const userName = 'Administrador TGE'; 
    document.getElementById('userNameDisplay').textContent = userName;
}

function setupEventListeners() {
    document.getElementById('sidebarToggle').addEventListener('click', toggleSidebar);
    
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const section = this.getAttribute('data-section');
            if (section) {
                // Reiniciar paginación y búsqueda al cambiar de sección
                currentPage = 1;
                currentSearchTerm = '';
                currentSortColumn = '';
                currentSortDirection = 'asc';
                navigateToSection(section);
            }
        });
    });

    window.addEventListener('resize', handleResize);
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    sidebarCollapsed = !sidebarCollapsed;
    
    if (window.innerWidth > 768) {
        sidebar.classList.toggle('collapsed', sidebarCollapsed);
        mainContent.classList.toggle('expanded', sidebarCollapsed);
    } else {
        sidebar.classList.toggle('show');
    }
}

function handleResize() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    
    if (window.innerWidth <= 768) {
        sidebar.classList.remove('collapsed');
        mainContent.classList.remove('expanded');
    } else {
        sidebar.classList.remove('show');
        sidebar.classList.toggle('collapsed', sidebarCollapsed);
        mainContent.classList.toggle('expanded', sidebarCollapsed);
    }
}

function updateLastUpdateTime() {
    const now = new Date();
    const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit' };
    document.getElementById('lastUpdate').textContent = now.toLocaleDateString('es-ES', options);
}

async function navigateToSection(section) {
    // Actualizar navegación activa
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    const activeLink = document.querySelector(`[data-section="${section}"]`);
    if (activeLink) activeLink.classList.add('active');
    
    currentSection = section;
    const contentArea = document.getElementById('contentArea');
    
    contentArea.innerHTML = `
        <div class="text-center p-5">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando ${sectionConfig[section]?.label || section}...</p>
        </div>
    `;

    if (sectionConfig[section]) {
        if (section === 'dashboard') {
            await renderDashboardContent();
        } else {
            // Se asume que renderTableSection o similar manejará la visualización de la tabla
            // y fetchDataAndRenderTable hará la llamada a la API para poblarla.
            await fetchDataAndRenderTable(section);
        }
    } else {
        contentArea.innerHTML = `<p class="alert alert-warning">Sección '${section}' no configurada o no encontrada.</p>`;
    }
}


// --- Funciones para el Dashboard ---

async function renderDashboardContent() {
    const contentArea = document.getElementById('contentArea');
    contentArea.innerHTML = `
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
    `;
    updateLastUpdateTime(); 
    await loadDashboardData();
}

async function loadDashboardData() {
    try {
        const [stats, activity, types] = await Promise.all([
            fetch('../api/dashboard_stats.php').then(r => r.json()),
            fetch('../api/recent_activity.php').then(r => r.json()),
            fetch('../api/document_types.php').then(r => r.json())
        ]);
        
        updateStatsCards(stats);
        updateRecentActivity(activity);
        updateDocumentTypes(types);
        
    } catch (error) {
        console.error('Error cargando datos del dashboard:', error);
        document.getElementById('totalEntradas').textContent = 'Error';
        document.getElementById('totalSalidas').textContent = 'Error';
        document.getElementById('totalPagos').textContent = 'Error';
        document.getElementById('totalUsuarios').textContent = 'Error';
        document.getElementById('recentActivity').innerHTML = `<p class="text-danger text-center p-3">Error al cargar actividad.</p>`;
        document.getElementById('documentTypes').innerHTML = `<p class="text-danger text-center p-3">Error al cargar tipos.</p>`;
    }
}

function updateStatsCards(stats) {
    document.getElementById('totalEntradas').textContent = stats.entradas.toLocaleString();
    document.getElementById('totalSalidas').textContent = stats.salidas.toLocaleString();
    document.getElementById('totalPagos').textContent = stats.pagos.toLocaleString();
    document.getElementById('totalUsuarios').textContent = stats.usuarios.toLocaleString();
}

function updateRecentActivity(activities) {
    const container = document.getElementById('recentActivity');
    if (!activities || activities.length === 0) {
        container.innerHTML = `<p class="text-muted text-center p-3">No hay actividad reciente.</p>`;
        return;
    }
    
    let html = '';
    activities.forEach(activity => {
        html += `
            <div class="activity-item">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <i class="${activity.icon} text-${activity.color}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-bold">${activity.descripcion}</div>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>${activity.usuario} • 
                            <i class="fas fa-clock me-1"></i>${activity.fecha}
                        </small>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function updateDocumentTypes(types) {
    const container = document.getElementById('documentTypes');
    if (!types || types.length === 0) {
        container.innerHTML = `<p class="text-muted text-center p-3">No hay tipos de documentos para mostrar.</p>`;
        return;
    }

    let html = '';
    types.forEach(type => {
        html += `
            <div class="mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="fw-bold">${type.tipo}</span>
                    <span>${type.cantidad} (${type.porcentaje}%)</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: ${type.porcentaje}%;" aria-valuenow="${type.porcentaje}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// --- Funciones para tablas de datos (CRUD) ---

async function fetchDataAndRenderTable(section) {
    const config = sectionConfig[section];
    if (!config || !config.api || !config.render) {
        console.error(`Configuración no encontrada para la sección: ${section}`);
        document.getElementById('contentArea').innerHTML = `<p class="alert alert-danger">Error: Configuración de sección inválida.</p>`;
        return;
    }

    const apiUrl = `../api/${config.api}?limit=${ITEMS_PER_PAGE}&offset=${(currentPage - 1) * ITEMS_PER_PAGE}&search=${encodeURIComponent(currentSearchTerm)}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();

        if (result.success && result.data) { // Asegúrate de que PHP devuelve 'success: true'
            config.render(config, result.data, result.total);
        } else {
            console.error('Datos no encontrados en la respuesta o éxito falso:', result);
            showMessage('error', `Error al cargar datos: ${result.message || 'Datos no disponibles.'}`);
            document.getElementById('contentArea').innerHTML = `<p class="alert alert-warning">No se pudieron cargar los datos para ${section}.</p>`;
        }
    } catch (error) {
        console.error(`Error al cargar datos de ${section}:`, error);
        showMessage('error', `Hubo un error de red o servidor al cargar ${section}.`);
        document.getElementById('contentArea').innerHTML = `<p class="alert alert-danger">Hubo un error al cargar los datos de ${section}. Inténtalo de nuevo más tarde.</p>`;
    }
}

function renderTableSection(config, data, total) {
    const contentArea = document.getElementById('contentArea');
    const sectionTitle = config.label || config.api.replace('.php', '').replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase());

    let tableHtml = `
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 mb-0 text-gray-800">${sectionTitle}</h1>
                <p class="text-muted">Gestión de ${sectionTitle.toLowerCase()}.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-success" id="addNewRecordBtn" data-bs-toggle="modal" data-bs-target="#crudModal" data-mode="add">
                    <i class="fas fa-plus-circle me-1"></i> Nuevo
                </button>
                <button class="btn btn-info" id="downloadPdfBtn">
                    <i class="fas fa-file-pdf me-1"></i> Descargar PDF
                </button>
                <div class="input-group" style="width: 300px;">
                    <input type="text" class="form-control search-input" id="searchInput" placeholder="Buscar en ${sectionTitle.toLowerCase()}..." value="${currentSearchTerm}">
                    <button class="btn btn-primary" id="searchButton"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>

        <div class="data-table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        ${config.columns.map(col => `<th data-column="${col.key}">${col.label}</th>`).join('')}
                        <th style="width: 120px;">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    ${data.length > 0 ? 
                        data.map(row => `
                            <tr>
                                ${config.columns.map(col => `<td>${row[col.key] !== undefined && row[col.key] !== null ? row[col.key] : ''}</td>`).join('')}
                                <td>
                                    <button class="btn btn-sm btn-warning edit-btn me-1" data-id="${row.Id}" data-bs-toggle="modal" data-bs-target="#crudModal" data-mode="edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="${row.Id}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        `).join('')
                        : `<tr><td colspan="${config.columns.length + 1}" class="text-center p-4">No hay datos disponibles.</td></tr>`
                    }
                </tbody>
            </table>
            <div class="pagination-controls">
                <button id="prevPage" ${currentPage === 1 ? 'disabled' : ''}><i class="fas fa-chevron-left me-2"></i>Anterior</button>
                <span>Página <span id="currentPageDisplay">${currentPage}</span> de <span id="totalPagesDisplay">${Math.ceil(total / ITEMS_PER_PAGE) || 1}</span> (Total: ${total})</span>
                <button id="nextPage" ${currentPage * ITEMS_PER_PAGE >= total ? 'disabled' : ''}>Siguiente<i class="fas fa-chevron-right ms-2"></i></button>
            </div>
        </div>
    `;
    contentArea.innerHTML = tableHtml;

    // Asignar eventos de paginación y búsqueda
    document.getElementById('prevPage').addEventListener('click', () => changePage(-1));
    document.getElementById('nextPage').addEventListener('click', () => changePage(1));
    document.getElementById('searchButton').addEventListener('click', performSearch);
    document.getElementById('searchInput').addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            performSearch();
        }
    });

    // Asignar eventos CRUD
    document.getElementById('addNewRecordBtn').addEventListener('click', () => {
        renderFormSection(config, 'add');
    });
    document.getElementById('downloadPdfBtn').addEventListener('click', () => {
        downloadPDF(currentSection, currentSearchTerm);
    });

    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            const id = e.currentTarget.dataset.id;
            await renderFormSection(config, 'edit', id);
        });
    });
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', (e) => {
            const id = e.currentTarget.dataset.id;
            showConfirmationDialog('¿Estás seguro de que quieres eliminar este registro?', () => deleteRecord(currentSection, id));
        });
    });
}

function changePage(direction) {
    const totalPages = parseInt(document.getElementById('totalPagesDisplay').textContent);
    const newPage = currentPage + direction;
    if (newPage >= 1 && newPage <= totalPages) {
        currentPage = newPage;
        fetchDataAndRenderTable(currentSection);
    }
}

function performSearch() {
    currentSearchTerm = document.getElementById('searchInput').value;
    currentPage = 1; // Resetear a la primera página al buscar
    fetchDataAndRenderTable(currentSection);
}

async function downloadPDF(section, searchTerm) {
    const config = sectionConfig[section];
    if (!config || !config.api) {
        showMessage('error', 'Configuración de sección inválida para PDF.');
        return;
    }
    const pdfUrl = `../api/${config.api}?download_pdf=true&search=${encodeURIComponent(searchTerm)}`;
    window.open(pdfUrl, '_blank'); // Abre el PDF en una nueva pestaña
    showMessage('success', 'Generando y descargando PDF...');
}

// --- Modales y Mensajes de Usuario ---
let crudModal;
let confirmModal;
let toastContainer;

function setupModals() {
    // Modal principal para CRUD (añadir/editar)
    const modalHtml = `
        <div class="modal fade" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="crudModalLabel"></h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="crudForm">
                            <!-- Campos del formulario se inyectarán aquí -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" form="crudForm" class="btn btn-primary" id="saveRecordBtn">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Acción</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="confirmModalBody">
                        ¿Estás seguro de que deseas realizar esta acción?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmActionBtn">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Container for messages -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
            <div id="liveToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body" id="toastMessage"></div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', modalHtml);

    crudModal = new bootstrap.Modal(document.getElementById('crudModal'));
    confirmModal = new bootstrap.Modal(document.getElementById('confirmModal'));
    toastContainer = document.getElementById('liveToast');
}

function showMessage(type, message) {
    const toast = new bootstrap.Toast(toastContainer);
    const toastBody = document.getElementById('toastMessage');

    toastBody.textContent = message;
    toastContainer.className = `toast align-items-center text-white border-0 ${type === 'success' ? 'bg-success' : 'bg-danger'}`;
    toast.show();
}

let confirmCallback = null;
function showConfirmationDialog(message, callback) {
    document.getElementById('confirmModalBody').textContent = message;
    confirmCallback = callback;
    document.getElementById('confirmActionBtn').onclick = () => {
        confirmModal.hide();
        if (confirmCallback) {
            confirmCallback();
        }
    };
    confirmModal.show();
}

// --- Funciones de Formulario (Crear/Editar) ---

async function renderFormSection(config, mode, recordId = null) {
    const modalTitle = document.getElementById('crudModalLabel');
    const crudForm = document.getElementById('crudForm');
    let formData = {};

    modalTitle.textContent = mode === 'add' ? `Nuevo ${config.label.slice(0, -1)}` : `Editar ${config.label.slice(0, -1)}`;
    crudForm.innerHTML = ''; // Limpiar formulario previo

    // Obtener opciones para selects
    const selectOptionsPromises = config.formFields.filter(field => field.type === 'select' && field.api).map(async (field) => {
        const response = await fetch(`../api/${field.api}?limit=9999`); // Obtener todos los datos para selects
        if (!response.ok) throw new Error(`Error al cargar ${field.label}: ${response.status}`);
        const result = await response.json();
        return { id: field.id, data: result.data || [] };
    });
    const selectOptions = await Promise.all(selectOptionsPromises);
    const selectOptionsMap = new Map(selectOptions.map(item => [item.id, item.data]));

    // Si es modo edición, cargar datos del registro
    if (mode === 'edit' && recordId) {
        try {
            const response = await fetch(`../api/${config.api}?id=${recordId}`);
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const result = await response.json();
            if (result.success && result.data) {
                formData = result.data;
            } else {
                showMessage('error', `No se pudo cargar el registro para editar: ${result.message || ''}`);
                crudModal.hide();
                return;
            }
        } catch (error) {
            console.error('Error cargando registro para editar:', error);
            showMessage('error', 'Error al cargar el registro para editar.');
            crudModal.hide();
            return;
        }
    }

    // Generar campos del formulario
    config.formFields.forEach(field => {
        // Omitir el campo 'Pass' si es modo edición y tiene 'addOnly: true'
        if (mode === 'edit' && field.id === 'Pass' && field.addOnly) {
            return;
        }

        let inputHtml = '';
        const value = formData[field.id] !== undefined ? formData[field.id] : '';
        const requiredAttr = field.required ? 'required' : '';
        const maxlenAttr = field.maxlen ? `maxlength="${field.maxlen}"` : '';

        switch (field.type) {
            case 'text':
            case 'email':
            case 'password':
            case 'number':
            case 'date':
                inputHtml = `<input type="${field.type}" class="form-control" id="${field.id}" value="${value}" ${requiredAttr} ${maxlenAttr} ${field.step ? `step="${field.step}"` : ''}>`;
                break;
            case 'textarea':
                inputHtml = `<textarea class="form-control" id="${field.id}" rows="3" ${requiredAttr} ${maxlenAttr}>${value}</textarea>`;
                break;
            case 'select':
                let optionsHtml = '';
                const fieldOptions = field.options || selectOptionsMap.get(field.id) || [];
                optionsHtml += '<option value="">Seleccione...</option>'; // Opción por defecto
                fieldOptions.forEach(option => {
                    const optValue = field.valueKey ? option[field.valueKey] : option;
                    const optLabel = field.labelKey ? option[field.labelKey] : option;
                    const selectedAttr = (optValue == value) ? 'selected' : ''; // Comparación flexible para números/strings
                    optionsHtml += `<option value="${optValue}" ${selectedAttr}>${optLabel}</option>`;
                });
                inputHtml = `<select class="form-select" id="${field.id}" ${requiredAttr}>${optionsHtml}</select>`;
                break;
            case 'file':
                // Para subida de archivos, esto requeriría FormData y un endpoint PHP diferente.
                // Por ahora, es un placeholder o se maneja por separado.
                // inputHtml = `<input type="file" class="form-control" id="${field.id}" ${requiredAttr}>`;
                return; // Omitir si no se implementará ahora
            default:
                inputHtml = `<input type="text" class="form-control" id="${field.id}" value="${value}" ${requiredAttr} ${maxlenAttr}>`;
        }

        crudForm.innerHTML += `
            <div class="mb-3">
                <label for="${field.id}" class="form-label">${field.label}${field.required ? ' <span class="text-danger">*</span>' : ''}</label>
                ${inputHtml}
            </div>
        `;
    });

    crudForm.onsubmit = (e) => {
        e.preventDefault();
        saveRecord(config, mode, recordId);
    };

    crudModal.show();
}

async function saveRecord(config, mode, recordId = null) {
    const crudForm = document.getElementById('crudForm');
    const data = {};

    config.formFields.forEach(field => {
        const inputElement = crudForm.elements[field.id];
        if (inputElement) {
            if (field.type === 'file') {
                // Manejo de archivos: esto sería más complejo, quizás enviando un FormData
                // y el archivo en un endpoint separado, o si solo es el nombre del archivo.
                // Por ahora, lo ignoramos si es 'file' y no se ha implementado la subida.
                return; 
            }
             // Si es un campo de contraseña en modo edición y no se ha modificado, no lo enviamos.
            if (mode === 'edit' && field.id === 'Pass' && field.addOnly && inputElement.value === '') {
                return; // No enviar contraseña si está vacía en edición y es "solo para añadir"
            }
            data[field.id] = inputElement.value;
        }
    });

    let url = `../api/${config.api}`;
    let method = '';

    if (mode === 'add') {
        method = 'POST';
    } else if (mode === 'edit') {
        method = 'PUT';
        data.Id = recordId; // Asegúrate de enviar el ID para la actualización
    }

    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showMessage('success', result.message);
            crudModal.hide();
            fetchDataAndRenderTable(currentSection); // Recargar datos de la tabla
        } else {
            showMessage('error', `Error: ${result.message}`);
        }
    } catch (error) {
        console.error('Error al guardar registro:', error);
        showMessage('error', 'Error de comunicación con el servidor.');
    }
}

async function deleteRecord(section, id) {
    const config = sectionConfig[section];
    if (!config || !config.api) {
        showMessage('error', 'Configuración de sección inválida para eliminar.');
        return;
    }

    try {
        const response = await fetch(`../api/${config.api}?id=${id}`, {
            method: 'DELETE'
        });
        const result = await response.json();

        if (result.success) {
            showMessage('success', result.message);
            fetchDataAndRenderTable(currentSection); // Recargar datos de la tabla
        } else {
            showMessage('error', `Error al eliminar: ${result.message}`);
        }
    } catch (error) {
        console.error('Error al eliminar registro:', error);
        showMessage('error', 'Error de comunicación con el servidor al eliminar.');
    }
}
