<style>
    .container {
        max-width: 1400px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        overflow: hidden;
    }

    .header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="20" cy="90" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        animation: float 20s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0px) rotate(0deg);
        }

        33% {
            transform: translateY(-10px) rotate(1deg);
        }

        66% {
            transform: translateY(5px) rotate(-1deg);
        }
    }

    .header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .header p {
        font-size: 1.1rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .main-content {
        padding: 30px;
    }

    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .search-box {
        position: relative;
        flex: 1;
        min-width: 300px;
    }

    .search-box input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 50px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }

    .search-box input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .search-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        opacity: 0.5;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 50px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-small {
        padding: 8px 16px;
        font-size: 12px;
        min-width: 40px;
        justify-content: center;
    }

    .btn-success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
        color: white;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .btn-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }

    .btn-success:hover,
    .btn-warning:hover,
    .btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .table-container {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table th {
        padding: 20px 15px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table td {
        padding: 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: translateX(5px);
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 30px;
    }

    .pagination button {
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        background: white;
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .pagination button:hover:not(:disabled) {
        border-color: #667eea;
        background: #667eea;
        color: white;
    }

    .pagination button.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-color: transparent;
    }

    .pagination button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .pagination-info {
        margin: 0 20px;
        font-size: 14px;
        color: #666;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    .modal-content {
        background: white;
        padding: 0;
        border-radius: 20px;
        width: 90%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        animation: slideIn 0.3s ease;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 20px 20px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        margin: 0;
    }

    .close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 5px;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .close:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .modal-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #333;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 100px;
    }

    .radio-group {
        display: flex;
        gap: 20px;
        margin-top: 10px;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .radio-item input[type="radio"] {
        width: auto;
    }

    .modal-footer {
        padding: 20px 30px;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: flex-end;
        gap: 15px;
    }

    .btn-secondary {
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #e9ecef;
    }

    .btn-secondary:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }

    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .stat-label {
        color: #666;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-data svg {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    @media (max-width: 768px) {
        .controls {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            min-width: 100%;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            min-width: 800px;
        }

        .modal-content {
            width: 95%;
            margin: 20px;
        }

        .actions {
            flex-direction: column;
        }

        .header h1 {
            font-size: 2rem;
        }
    }

    /* SVG Icons */
    .icon {
        width: 16px;
        height: 16px;
        fill: currentColor;
    }
</style>
<div class="container-fluid p-4">

    <div class="header">
        <h1>Sistema de Gestión de Entradas</h1>
        <p>Administra y controla todos los documentos de entrada de manera eficiente</p>
    </div>

    <div class="main-content">
        <!-- Estadísticas -->
        <div class="stats">
            <div class="stat-card">
                <div class="stat-number" id="totalEntries">0</div>
                <div class="stat-label">Total Entradas</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="todayEntries">0</div>
                <div class="stat-label">Hoy</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="monthEntries">0</div>
                <div class="stat-label">Este Mes</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" id="nextRegister">ER-2024-001</div>
                <div class="stat-label">Próximo Registro</div>
            </div>
        </div>

        <!-- Controles -->
        <div class="controls">
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Buscar por número, descripción, referencia...">
                <svg class="search-icon" viewBox="0 0 24 24">
                    <path
                        d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                </svg>
            </div>
            <button class="btn btn-primary" onclick="openModal('registerModal')">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
                Nueva Entrada
            </button>
        </div>

        <!-- Tabla -->
        <div class="table-container">
            <table class="table" id="entriesTable">
                <thead>
                    <tr>
                        <th>Nº Registro</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Referencia</th>
                        <th>Fecha Firma</th>
                        <th>Importe</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <!-- Los datos se cargarán dinámicamente -->
                </tbody>
            </table>
            <div id="noData" class="no-data" style="display: none;">
                <svg viewBox="0 0 24 24">
                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
                </svg>
                <h3>No hay datos disponibles</h3>
                <p>No se encontraron entradas que coincidan con tu búsqueda</p>
            </div>
        </div>

        <!-- Paginación -->
        <div class="pagination">
            <button onclick="changePage('prev')" id="prevBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                </svg>
            </button>
            <div id="pageNumbers"></div>
            <button onclick="changePage('next')" id="nextBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </button>
            <div class="pagination-info" id="paginationInfo"></div>
        </div>
    </div>

</div>
<!-- Modal para Registrar -->
<div id="registerModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nueva Entrada</h2>
            <button class="close" onclick="closeModal('registerModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="registerForm">
                <div class="form-group">
                    <label for="tipoDoc">Tipo de Documento</label>
                    <input type="text" id="tipoDoc" name="tipoDoc" placeholder="Ejemplo: Carta, Solicitud, etc.">
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea id="descripcion" name="descripcion" placeholder="Descripción del documento"></textarea>
                </div>
                <div class="form-group">
                    <label for="palabrasClaves">Palabras Claves</label>
                    <input type="text" id="palabrasClaves" name="palabrasClaves"
                        placeholder="Palabras clave separadas por comas">
                </div>
                <div class="form-group">
                    <label for="fechaFirma">Fecha de Firma</label>
                    <input type="date" id="fechaFirma" name="fechaFirma">
                </div>
                <div class="form-group">
                    <label for="importe">Importe</label>
                    <input type="text" id="importe" name="importe" placeholder="Ejemplo: 1.000.000">
                </div>
                <div class="form-group">
                    <label for="referencia">Referencia</label>
                    <select id="referencia" name="referencia">
                        <option value="">Seleccione una referencia...</option>
                        <option value="1">REF-001 / Ministerio de Hacienda</option>
                        <option value="2">REF-002 / Tesorería General</option>
                        <option value="3">REF-003 / Contraloría</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="archivo">Archivo PDF</label>
                    <input type="file" id="archivo" name="archivo" accept=".pdf">
                </div>
                <div class="form-group">
                    <label>Procede de:</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="personaFisica" name="procede" value="pf">
                            <label for="personaFisica">Persona Física</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="personaJuridica" name="procede" value="pj">
                            <label for="personaJuridica">Persona Jurídica</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="campoPersonaFisica" style="display: none;">
                    <label for="nombrePersona">Nombre Completo</label>
                    <input type="text" id="nombrePersona" name="nombrePersona"
                        placeholder="Nombre completo de la persona">
                </div>
                <div class="form-group" id="campoInstitucion" style="display: none;">
                    <label for="institucion">Institución</label>
                    <select id="institucion" name="institucion">
                        <option value="">Seleccione una institución...</option>
                        <option value="MIN-001">Ministerio de Hacienda / Dirección General</option>
                        <option value="MIN-002">Ministerio de Educación / Recursos Humanos</option>
                        <option value="GOB-001">Gobernación / Secretaría General</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('registerModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="saveEntry()">Guardar</button>
        </div>
    </div>
</div>

<!-- Modal para Editar -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Entrada</h2>
            <button class="close" onclick="closeModal('editModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editForm">
                <input type="hidden" id="editId" name="editId">
                <div class="form-group">
                    <label for="editTipoDoc">Tipo de Documento</label>
                    <input type="text" id="editTipoDoc" name="editTipoDoc">
                </div>
                <div class="form-group">
                    <label for="editDescripcion">Descripción</label>
                    <textarea id="editDescripcion" name="editDescripcion"></textarea>
                </div>
                <div class="form-group">
                    <label for="editPalabrasClaves">Palabras Claves</label>
                    <input type="text" id="editPalabrasClaves" name="editPalabrasClaves">
                </div>
                <div class="form-group">
                    <label for="editFechaFirma">Fecha de Firma</label>
                    <input type="date" id="editFechaFirma" name="editFechaFirma">
                </div>
                <div class="form-group">
                    <label for="editImporte">Importe</label>
                    <input type="text" id="editImporte" name="editImporte">
                </div>
                <div class="form-group">
                    <label for="editReferencia">Referencia</label>
                    <select id="editReferencia" name="editReferencia">
                        <option value="">Seleccione una referencia...</option>
                        <option value="1">REF-001 / Ministerio de Hacienda</option>
                        <option value="2">REF-002 / Tesorería General</option>
                        <option value="3">REF-003 / Contraloría</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="updateEntry()">Actualizar</button>
        </div>
    </div>
</div>

<script>
    // Datos de ejemplo
    let entries = [
        {
            id: 1,
            numRegistro: 'ER-2024-001',
            fechaRegistro: '2024-01-15',
            tipoDoc: 'Solicitud',
            descripcion: 'Solicitud de presupuesto para proyecto de infraestructura',
            referencia: 'REF-001 / Ministerio de Hacienda',
            fechaFirma: '2024-01-14',
            importe: '5.000.000',
            archivo: 'solicitud_001.pdf'
        },
        {
            id: 2,
            numRegistro: 'ER-2024-002',
            fechaRegistro: '2024-01-16',
            tipoDoc: 'Carta',
            descripcion: 'Carta de presentación de nuevo director',
            referencia: 'REF-002 / Tesorería General',
            fechaFirma: '2024-01-15',
            importe: '0',
            archivo: 'carta_002.pdf'
        },
        {
            id: 3,
            numRegistro: 'ER-2024-003',
            fechaRegistro: '2024-01-17',
            tipoDoc: 'Informe',
            descripcion: 'Informe trimestral de actividades y resultados',
            referencia: 'REF-003 / Contraloría',
            fechaFirma: '2024-01-16',
            importe: '2.500.000',
            archivo: 'informe_003.pdf'
        }
    ];

    let filteredEntries = [...entries];
    let currentPage = 1;
    const itemsPerPage = 10;

    // Inicializar la aplicación
    document.addEventListener('DOMContentLoaded', function () {
        setupEventListeners();
        updateStats();
        renderTable();
        renderPagination();
    });

    function setupEventListeners() {
        // Búsqueda en tiempo real
        document.getElementById('searchInput').addEventListener('input', function () {
            currentPage = 1;
            filterEntries();
        });

        // Radio buttons para mostrar/ocultar campos
        document.querySelectorAll('input[name="procede"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const personaFisica = document.getElementById('campoPersonaFisica');
                const institucion = document.getElementById('campoInstitucion');

                if (this.value === 'pf') {
                    personaFisica.style.display = 'block';
                    institucion.style.display = 'none';
                } else if (this.value === 'pj') {
                    personaFisica.style.display = 'none';
                    institucion.style.display = 'block';
                }
            });
        });

        // Cerrar modal al hacer clic fuera
        window.addEventListener('click', function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        });
    }

    function updateStats() {
        const today = new Date().toISOString().split('T')[0];
        const currentMonth = new Date().getMonth();
        const currentYear = new Date().getFullYear();

        const todayEntries = entries.filter(entry => entry.fechaRegistro === today).length;
        const monthEntries = entries.filter(entry => {
            const entryDate = new Date(entry.fechaRegistro);
            return entryDate.getMonth() === currentMonth && entryDate.getFullYear() === currentYear;
        }).length;

        document.getElementById('totalEntries').textContent = entries.length;
        document.getElementById('todayEntries').textContent = todayEntries;
        document.getElementById('monthEntries').textContent = monthEntries;

        // Generar próximo número de registro
        const nextNumber = entries.length + 1;
        const nextRegister = `ER-${currentYear}-${nextNumber.toString().padStart(3, '0')}`;
        document.getElementById('nextRegister').textContent = nextRegister;
    }

    function filterEntries() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();

        if (searchTerm === '') {
            filteredEntries = [...entries];
        } else {
            filteredEntries = entries.filter(entry =>
                entry.numRegistro.toLowerCase().includes(searchTerm) ||
                entry.tipoDoc.toLowerCase().includes(searchTerm) ||
                entry.descripcion.toLowerCase().includes(searchTerm) ||
                entry.referencia.toLowerCase().includes(searchTerm)
            );
        }

        renderTable();
        renderPagination();
    }

    function renderTable() {
        const tbody = document.getElementById('tableBody');
        const noData = document.getElementById('noData');

        if (filteredEntries.length === 0) {
            tbody.innerHTML = '';
            noData.style.display = 'block';
            return;
        }

        noData.style.display = 'none';

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const currentEntries = filteredEntries.slice(startIndex, endIndex);

        tbody.innerHTML = currentEntries.map(entry => `
                <tr>
                    <td><strong>${entry.numRegistro}</strong></td>
                    <td>${formatDate(entry.fechaRegistro)}</td>
                    <td><span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">${entry.tipoDoc}</span></td>
                    <td>${entry.descripcion}</td>
                    <td>${entry.referencia}</td>
                    <td>${formatDate(entry.fechaFirma)}</td>
                    <td><strong>${formatCurrency(entry.importe)}</strong></td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-small btn-info" onclick="viewEntry(${entry.id})" title="Ver detalles">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12A3,3 0 0,0 12,9M12,17A5,5 0 0,1 7,12A5,5 0 0,1 12,7A5,5 0 0,1 17,12A5,5 0 0,1 12,17M12,4.5C7,4.5 2.73,7.61 1,12C2.73,16.39 7,19.5 12,19.5C17,19.5 21.27,16.39 23,12C21.27,7.61 17,4.5 12,4.5Z"/>
                                </svg>
                            </button>
                            <button class="btn btn-small btn-warning" onclick="editEntry(${entry.id})" title="Editar">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z"/>
                                </svg>
                            </button>
                            <button class="btn btn-small btn-success" onclick="downloadFile('${entry.archivo}')" title="Descargar PDF">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
    }

    function renderPagination() {
        const totalPages = Math.ceil(filteredEntries.length / itemsPerPage);
        const pageNumbers = document.getElementById('pageNumbers');
        const paginationInfo = document.getElementById('paginationInfo');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        // Actualizar botones prev/next
        prevBtn.disabled = currentPage === 1;
        nextBtn.disabled = currentPage === totalPages || totalPages === 0;

        // Generar números de página
        pageNumbers.innerHTML = '';
        if (totalPages > 0) {
            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 2 && i <= currentPage + 2)) {
                    const button = document.createElement('button');
                    button.textContent = i;
                    button.classList.toggle('active', i === currentPage);
                    button.onclick = () => goToPage(i);
                    pageNumbers.appendChild(button);
                } else if (i === currentPage - 3 || i === currentPage + 3) {
                    const span = document.createElement('span');
                    span.textContent = '...';
                    span.style.padding = '10px 5px';
                    pageNumbers.appendChild(span);
                }
            }
        }

        // Información de paginación
        const startItem = (currentPage - 1) * itemsPerPage + 1;
        const endItem = Math.min(currentPage * itemsPerPage, filteredEntries.length);
        paginationInfo.textContent = `Mostrando ${startItem}-${endItem} de ${filteredEntries.length} entradas`;
    }

    function changePage(direction) {
        const totalPages = Math.ceil(filteredEntries.length / itemsPerPage);

        if (direction === 'prev' && currentPage > 1) {
            currentPage--;
        } else if (direction === 'next' && currentPage < totalPages) {
            currentPage++;
        }

        renderTable();
        renderPagination();
    }

    function goToPage(page) {
        currentPage = page;
        renderTable();
        renderPagination();
    }

    function formatDate(dateString) {
        if (!dateString) return '-';
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    }

    function formatCurrency(amount) {
        if (!amount || amount === '0') return '-';
        return new Intl.NumberFormat('es-ES', {
            style: 'currency',
            currency: 'EUR',
            minimumFractionDigits: 0
        }).format(parseFloat(amount));
    }

    // Funciones de Modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('show');

        if (modalId === 'registerModal') {
            // Limpiar formulario
            document.getElementById('registerForm').reset();
            document.getElementById('campoPersonaFisica').style.display = 'none';
            document.getElementById('campoInstitucion').style.display = 'none';
        }
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('show');
    }

    // Funciones CRUD
    function saveEntry() {
        const form = document.getElementById('registerForm');
        const formData = new FormData(form);

        // Validaciones básicas
        if (!formData.get('tipoDoc') || !formData.get('descripcion')) {
            alert('Por favor completa los campos obligatorios');
            return;
        }

        // Generar nuevo ID y número de registro
        const newId = Math.max(...entries.map(e => e.id), 0) + 1;
        const currentYear = new Date().getFullYear();
        const nextNumber = entries.length + 1;
        const numRegistro = `ER-${currentYear}-${nextNumber.toString().padStart(3, '0')}`;

        // Crear nueva entrada
        const newEntry = {
            id: newId,
            numRegistro: numRegistro,
            fechaRegistro: new Date().toISOString().split('T')[0],
            tipoDoc: formData.get('tipoDoc'),
            descripcion: formData.get('descripcion'),
            referencia: getReferenceName(formData.get('referencia')),
            fechaFirma: formData.get('fechaFirma'),
            importe: formData.get('importe') || '0',
            archivo: formData.get('archivo')?.name || 'documento.pdf'
        };

        // Agregar a los datos
        entries.unshift(newEntry);
        filteredEntries = [...entries];

        // Actualizar interfaz
        updateStats();
        renderTable();
        renderPagination();
        closeModal('registerModal');

        // Mostrar mensaje de éxito
        showNotification('Entrada guardada exitosamente', 'success');
    }

    function editEntry(id) {
        const entry = entries.find(e => e.id === id);
        if (!entry) return;

        // Llenar formulario de edición
        document.getElementById('editId').value = entry.id;
        document.getElementById('editTipoDoc').value = entry.tipoDoc;
        document.getElementById('editDescripcion').value = entry.descripcion;
        document.getElementById('editFechaFirma').value = entry.fechaFirma;
        document.getElementById('editImporte').value = entry.importe;

        // Buscar referencia
        const refSelect = document.getElementById('editReferencia');
        for (let option of refSelect.options) {
            if (entry.referencia.includes(option.text.split(' / ')[0])) {
                option.selected = true;
                break;
            }
        }

        openModal('editModal');
    }

    function updateEntry() {
        const form = document.getElementById('editForm');
        const formData = new FormData(form);
        const id = parseInt(formData.get('editId'));

        // Encontrar y actualizar entrada
        const entryIndex = entries.findIndex(e => e.id === id);
        if (entryIndex === -1) return;

        entries[entryIndex] = {
            ...entries[entryIndex],
            tipoDoc: formData.get('editTipoDoc'),
            descripcion: formData.get('editDescripcion'),
            fechaFirma: formData.get('editFechaFirma'),
            importe: formData.get('editImporte'),
            referencia: getReferenceName(formData.get('editReferencia'))
        };

        // Actualizar datos filtrados
        filteredEntries = [...entries];

        // Actualizar interfaz
        renderTable();
        closeModal('editModal');

        showNotification('Entrada actualizada exitosamente', 'success');
    }

    function viewEntry(id) {
        const entry = entries.find(e => e.id === id);
        if (!entry) return;

        alert(`Detalles de la entrada:\n\nNúmero: ${entry.numRegistro}\nTipo: ${entry.tipoDoc}\nDescripción: ${entry.descripcion}\nReferencia: ${entry.referencia}\nImporte: ${formatCurrency(entry.importe)}`);
    }

    function downloadFile(filename) {
        // Simular descarga de archivo
        showNotification(`Descargando archivo: ${filename}`, 'info');
        // En una implementación real, aquí iría la lógica de descarga
    }

    // Funciones auxiliares
    function getReferenceName(refId) {
        const references = {
            '1': 'REF-001 / Ministerio de Hacienda',
            '2': 'REF-002 / Tesorería General',
            '3': 'REF-003 / Contraloría'
        };
        return references[refId] || '';
    }

    function showNotification(message, type = 'info') {
        // Crear elemento de notificación
        const notification = document.createElement('div');
        notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                padding: 15px 20px;
                border-radius: 10px;
                color: white;
                font-weight: 600;
                z-index: 9999;
                animation: slideInRight 0.3s ease;
                max-width: 300px;
            `;

        // Colores según tipo
        const colors = {
            success: 'linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%)',
            error: 'linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%)',
            info: 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
            warning: 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'
        };

        notification.style.background = colors[type];
        notification.textContent = message;

        document.body.appendChild(notification);

        // Remover después de 3 segundos
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }

    // Añadir estilos de animación para las notificaciones
    const style = document.createElement('style');
    style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
    document.head.appendChild(style);
</script>