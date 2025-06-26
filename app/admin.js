// assets/js/main.js

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
        api: 'entradas.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'NumRegistro', label: 'Nº Registro' },
            { key: 'FechaRegistro', label: 'Fecha Registro' },
            { key: 'TipoDoc', label: 'Tipo Documento' },
            { key: 'Descripcion', label: 'Descripción' },
            { key: 'UsuarioNombre', label: 'Usuario' },
            { key: 'ReferenciaNombre', label: 'Referencia' }
        ]
    },
    'salidas': {
        label: 'Documentos de Salida',
        api: 'salidas.php', // O 'carga_salidas.php' si prefieres ese nombre de archivo
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
            { key: 'Archivo', label: 'Archivo' }
            // Puedes añadir más columnas si las necesitas y las obtienes en la consulta SQL
        ]
    },
    'decretos': {
        api: 'decretos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Descripcion', label: 'Descripción' },
            { key: 'Fecha', label: 'Fecha' },
            { key: 'Archivo', label: 'Archivo' },
            { key: 'DocEntrada', label: 'Doc. Entrada ID' }
        ]
    },
    'pagos': {
        api: 'pagos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'NumRegistro', label: 'Nº Registro' },
            { key: 'Concepto', label: 'Concepto' },
            { key: 'Cantidad', label: 'Cantidad' },
            { key: 'FechaFirma', label: 'Fecha Firma' },
            { key: 'Beneficiario', label: 'Beneficiario' },
            { key: 'Banco', label: 'Banco ID' }, // Aquí quizás quieras mostrar el nombre del banco
            { key: 'Usuario', label: 'Usuario ID' } // Aquí quizás quieras mostrar el nombre del usuario
        ]
    },
    'bancos': {
        api: 'bancos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' }
        ]
    },
    'instituciones': {
        api: 'instituciones.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Nombre_Corto', label: 'Nombre Corto' }
        ]
    },
    'departamentos': {
        api: 'departamentos.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Telefono', label: 'Teléfono' },
            { key: 'Email', label: 'Email' },
            { key: 'Institucion', label: 'Institución ID' } // Nombre de institución
        ]
    },
    'miembros': {
        api: 'miembros.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Dpto', label: 'Departamento ID' } // Nombre del departamento
        ]
    },
    'usuarios': {
        api: 'usuarios.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Dpto', label: 'Departamento ID' }, // Nombre del departamento
            { key: 'Tipo_Usuario', label: 'Tipo Usuario' }
        ]
    },
    'referencias': {
        api: 'referencias.php',
        render: renderTableSection,
        columns: [
            { key: 'Id', label: 'ID' },
            { key: 'Nombre', label: 'Nombre' },
            { key: 'Codigo', label: 'Código' }
        ]
    },
    // Añade 'reportes' y 'auditoria' aquí si también quieres que carguen datos dinámicamente
};


// Inicialización
document.addEventListener('DOMContentLoaded', function() {
    initializeDashboard();
    setupEventListeners();
    // Carga inicial del dashboard
    navigateToSection('dashboard');
});

function initializeDashboard() {
    updateLastUpdateTime();
    // Obtener el nombre de usuario de PHP (si existe una sesión)
    // Esto es un placeholder. En una aplicación real, lo obtendrías del backend.
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
    document.querySelector(`[data-section="${section}"]`).classList.add('active');
    
    currentSection = section;
    const contentArea = document.getElementById('contentArea');
    
    // Mostrar un spinner de carga general mientras se carga la sección
    contentArea.innerHTML = `
        <div class="text-center p-5">
            <div class="loading-spinner spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <p class="mt-3 text-muted">Cargando ${sectionConfig[section].label || section}...</p>
        </div>
    `;

    // Cargar contenido según la sección
    if (sectionConfig[section]) {
        if (section === 'dashboard') {
            await renderDashboardContent();
        } else {
            // Renderiza la estructura básica de la tabla con spinner de carga
            sectionConfig[section].render(sectionConfig[section], [], 0); 
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
    updateLastUpdateTime(); // Vuelve a actualizar la hora después de inyectar el HTML
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

// --- Funciones para tablas de datos (Entradas, Salidas, etc.) ---

async function fetchDataAndRenderTable(section) {
    const config = sectionConfig[section];
    if (!config || !config.api || !config.render) {
        console.error(`Configuración no encontrada para la sección: ${section}`);
        document.getElementById('contentArea').innerHTML = `<p class="alert alert-danger">Error: Configuración de sección inválida.</p>`;
        return;
    }

    const apiUrl = `../api/${config.api}?limit=${ITEMS_PER_PAGE}&offset=${(currentPage - 1) * ITEMS_PER_PAGE}&search=${currentSearchTerm}`;

    try {
        const response = await fetch(apiUrl);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();

        if (result.data) {
            config.render(config, result.data, result.total);
        } else {
            console.error('Datos no encontrados en la respuesta:', result);
            document.getElementById('contentArea').innerHTML = `<p class="alert alert-warning">No se pudieron cargar los datos para ${section}.</p>`;
        }
    } catch (error) {
        console.error(`Error al cargar datos de ${section}:`, error);
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
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control search-input" id="searchInput" placeholder="Buscar en ${sectionTitle.toLowerCase()}..." value="${currentSearchTerm}">
                <button class="btn btn-primary" id="searchButton"><i class="fas fa-search"></i></button>
            </div>
        </div>

        <div class="data-table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        ${config.columns.map(col => `<th data-column="${col.key}">${col.label}</th>`).join('')}
                    </tr>
                </thead>
                <tbody id="tableBody">
                    ${data.length > 0 ? 
                        data.map(row => `
                            <tr>
                                ${config.columns.map(col => `<td>${row[col.key] !== undefined && row[col.key] !== null ? row[col.key] : ''}</td>`).join('')}
                            </tr>
                        `).join('')
                        : `<tr><td colspan="${config.columns.length}" class="text-center p-4">No hay datos disponibles.</td></tr>`
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

// Puedes añadir funciones para reportes y auditoría aquí si lo necesitas.
// Por ejemplo:
/*
function renderReportsSection() {
    document.getElementById('contentArea').innerHTML = `
        <h2>Reportes</h2>
        <p>Aquí se generarán los diferentes reportes del sistema.</p>
        `;
}

function renderAuditoriaSection() {
    document.getElementById('contentArea').innerHTML = `
        <h2>Auditoría</h2>
        <p>Aquí se mostrará el registro de auditoría.</p>
        `;
}
*/