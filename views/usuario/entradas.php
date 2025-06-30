<style>
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



    /* Íconos SVG */
    .icon {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        transition: transform 0.2s ease-in-out;
        color: white;
        /* color por defecto si el SVG respeta 'currentColor' */
        stroke: currentColor;
        /* asegurar que el trazo use el color heredado */
    }

    /* Animación en hover */
    button:hover .icon {
        transform: scale(1.2);
    }

    /* Botones por tipo (usa Bootstrap o defínelos así si son personalizados) */
    .btn-small {
        padding: 6px 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-info {
        background-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background-color: #138496;
    }

    .btn-warning {
        background-color: #ffc107;
        color: black;
    }

    .btn-warning:hover {
        background-color: #e0a800;
    }

    /* Tooltip */
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 75px;
        background-color: #000;
        color: #fff;
        text-align: center;
        font-size: 12px;
        padding: 5px 6px;
        border-radius: 4px;
        position: absolute;
        z-index: 1;
        bottom: 130%;
        left: 50%;
        margin-left: -37px;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }
</style>

<style>
    /* ... (Your existing CSS here) ... */
</style>


<div class="container-fluid p-4">
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

    <div class="table-container pb-3">
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
            </tbody>
        </table>
        <div id="noData" class="no-data" style="display: none;">
            <svg viewBox="0 0 24 24">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
            </svg>
            <h3>No hay datos disponibles</h3>
            <p>No se encontraron entradas que coincidan con tu búsqueda</p>
        </div>
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
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('registerModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="saveNewEntry()">Guardar</button>
        </div>
    </div>
</div>

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
                    </select>
                </div>
                <div class="form-group">
                    <label for="editArchivo">Archivo PDF Actual</label>
                    <span id="currentPdfName" style="margin-left: 10px;"></span>
                    <input type="file" id="editArchivo" name="editArchivo" accept=".pdf">
                    <small>Deja en blanco para mantener el archivo actual. Selecciona uno nuevo para
                        reemplazarlo.</small>
                </div>
                <div class="form-group">
                    <label>Procede de:</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="editPersonaFisica" name="editProcede" value="pf">
                            <label for="editPersonaFisica">Persona Física</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="editPersonaJuridica" name="editProcede" value="pj">
                            <label for="editPersonaJuridica">Persona Jurídica</label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="editCampoPersonaFisica" style="display: none;">
                    <label for="editNombrePersona">Nombre Completo</label>
                    <input type="text" id="editNombrePersona" name="editNombrePersona"
                        placeholder="Nombre completo de la persona">
                </div>
                <div class="form-group" id="editCampoInstitucion" style="display: none;">
                    <label for="editInstitucion">Institución</label>
                    <select id="editInstitucion" name="editInstitucion">
                        <option value="">Seleccione una institución...</option>
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
    // =======================================================
    // Configuración Global y Variables de Estado
    // =======================================================

    // URL base de tu API. ¡IMPORTANTE: CÁMBIALA A LA URL REAL DE TU BACKEND!
    const API_BASE_URL = 'api'; // Ejemplo: 'http://miservidor.com/api'

    // Almacena todas las entradas obtenidas de la API
    let allEntries = [];
    // Almacena las entradas filtradas para mostrar en la tabla
    let filteredEntries = [];
    // Almacena todas las referencias e instituciones para mapeo
    let allReferences = [];
    let allInstitutions = [];

    // Páginación
    let currentPage = 1;
    const itemsPerPage = 10;

    // =======================================================
    // Inicialización de la Aplicación
    // =======================================================

    // Se ejecuta una vez que el DOM está completamente cargado.
    document.addEventListener('DOMContentLoaded', async function () {
        // Configura los escuchadores de eventos para interacciones del usuario.
        setupEventListeners();
        // Carga los datos iniciales y rellena los dropdowns.
        await loadAllInitialData();
        // Renderiza la tabla y la paginación con los datos cargados.
        renderTable();
        renderPagination();
        // Actualiza las estadísticas de la cabecera.
        updateStats();


    });

    /**
     * Carga todos los datos iniciales necesarios para la aplicación: entradas, referencias e instituciones.
     */
    async function loadAllInitialData() {
        await Promise.all([
            fetchEntriesData(),
            fetchReferencesData(),
            fetchInstitutionsData()
        ]);
        populateDropdowns(); // Populate after data is loaded
    }

    // =======================================================
    // Gestión de Eventos (EventListeners)
    // =======================================================

    /**
     * Configura todos los escuchadores de eventos principales.
     */
    function setupEventListeners() {
        // Escucha el evento 'input' en el campo de búsqueda para filtrar en tiempo real.
        document.getElementById('searchInput').addEventListener('input', function () {
            currentPage = 1; // Reinicia la página a 1 en cada nueva búsqueda.
            filterEntries(); // Ejecuta la función de filtrado.
        });

        // Escucha los cambios en los radio buttons para mostrar/ocultar campos de "Procede de" en el modal de registro.
        document.querySelectorAll('input[name="procede"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const personaFisicaField = document.getElementById('campoPersonaFisica');
                const institucionField = document.getElementById('campoInstitucion');

                if (this.value === 'pf') {
                    personaFisicaField.style.display = 'block';
                    institucionField.style.display = 'none';
                    document.getElementById('institucion').value = ''; // Clear institution field
                } else if (this.value === 'pj') {
                    personaFisicaField.style.display = 'none';
                    institucionField.style.display = 'block';
                    document.getElementById('nombrePersona').value = ''; // Clear persona fisica field
                }
            });
        });

        // Escucha los cambios en los radio buttons para mostrar/ocultar campos de "Procede de" en el modal de edición.
        document.querySelectorAll('input[name="editProcede"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const personaFisicaEditField = document.getElementById('editCampoPersonaFisica');
                const institucionEditField = document.getElementById('editCampoInstitucion');

                if (this.value === 'pf') {
                    personaFisicaEditField.style.display = 'block';
                    institucionEditField.style.display = 'none';
                    document.getElementById('editInstitucion').value = ''; // Clear institution field
                } else if (this.value === 'pj') {
                    personaFisicaEditField.style.display = 'none';
                    institucionEditField.style.display = 'block';
                    document.getElementById('editNombrePersona').value = ''; // Clear persona fisica field
                }
            });
        });


        // Cierra cualquier modal al hacer clic fuera de su contenido.
        window.addEventListener('click', function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('show');
            }
        });

        // Asigna el evento submit para el formulario de registro
        const registerForm = document.getElementById('registerForm');
        if (registerForm) {
            registerForm.addEventListener('submit', async function (event) {
                event.preventDefault(); // Previene el envío por defecto del formulario
                await saveNewEntry();
            });
        }

        // Asigna el evento submit para el formulario de edición
        const editForm = document.getElementById('editForm');
        if (editForm) {
            editForm.addEventListener('submit', async function (event) {
                event.preventDefault(); // Previene el envío por defecto del formulario
                await updateExistingEntry();
            });
        }
    }

    // =======================================================
    // Carga de Datos (Funciones Fetch Específicas - 'obtener_name')
    // =======================================================

    /**
     * Carga todas las entradas desde el backend.
     */
    async function fetchEntriesData() {
        try {
            const response = await fetch(`${API_BASE_URL}/obtener_entradas.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json(); // Renamed to 'result' to avoid confusion

            if (result.success && Array.isArray(result.data)) {
                allEntries = result.data; // Correct: Assign the array from result.data
                filteredEntries = [...allEntries]; // Now this should work as allEntries is an array
            } else {
                console.warn('Backend did not return an array for entries:', result);
                allEntries = [];
                filteredEntries = [];
                showNotification(result.message || 'La respuesta de entradas no es válida.', 'warning');
            }
        } catch (error) {
            console.error('Error al cargar las entradas:', error);
            showNotification('Error al cargar los datos de entradas. Intenta de nuevo.', 'error');
            allEntries = [];
            filteredEntries = [];
        }
    }

    /**
     * Carga las referencias para los dropdowns desde el backend.
     */
    async function fetchReferencesData() {
        try {
            const response = await fetch(`${API_BASE_URL}/obtener_referencias.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();

            if (result.success && Array.isArray(result.data)) {
                allReferences = result.data; // Correct: Assign the array from result.data
            } else {
                console.warn('Backend did not return an array for references:', result);
                allReferences = [];
                showNotification(result.message || 'La respuesta de referencias no es válida.', 'warning');
            }
        } catch (error) {
            console.error('Error al cargar referencias:', error);
            showNotification('Error al cargar las referencias.', 'error');
            allReferences = [];
        }
    }

    /**
     * Carga las instituciones para los dropdowns desde el backend.
     */
    async function fetchInstitutionsData() {
        try {
            const response = await fetch(`${API_BASE_URL}/obtener_instituciones.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            });
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const result = await response.json();

            if (result.success && Array.isArray(result.data)) {
                allInstitutions = result.data; // Correct: Assign the array from result.data
            } else {
                console.warn('Backend did not return an array for institutions:', result);
                allInstitutions = [];
                showNotification(result.message || 'La respuesta de instituciones no es válida.', 'warning');
            }
        } catch (error) {
            console.error('Error al cargar instituciones:', error);
            showNotification('Error al cargar las instituciones.', 'error');
            allInstitutions = [];
        }
    }

    /**
     * Rellena los dropdowns (selects) de referencia e institución con los datos cargados.
     */
    function populateDropdowns() {
        const refSelectRegister = document.getElementById('referencia');
        const refSelectEdit = document.getElementById('editReferencia');
        const institutionSelectRegister = document.getElementById('institucion');
        const institutionSelectEdit = document.getElementById('editInstitucion'); // New edit institution dropdown

        // Clear existing options (except the first "Seleccione...")
        [refSelectRegister, refSelectEdit, institutionSelectRegister, institutionSelectEdit].forEach(selectElement => {
            if (selectElement) {
                while (selectElement.options.length > 1) selectElement.remove(1);
            }
        });

        allReferences.forEach(ref => {
            const option1 = new Option(ref.nombre, ref.id);
            const option2 = new Option(ref.nombre, ref.id);
            if (refSelectRegister) refSelectRegister.add(option1);
            if (refSelectEdit) refSelectEdit.add(option2);
        });

        allInstitutions.forEach(inst => {
            const option1 = new Option(inst.nombre, inst.id);
            const option2 = new Option(inst.nombre, inst.id);
            if (institutionSelectRegister) institutionSelectRegister.add(option1);
            if (institutionSelectEdit) institutionSelectEdit.add(option2);
        });
    }

    // =======================================================
    // Operaciones CRUD (Registro, Actualización)
    // =======================================================

    /**
     * Guarda una nueva entrada en el backend. (Función de registro - 'guardar_name')
     */


    async function saveNewEntry() {
        const form = document.getElementById('registerForm');
        const formData = new FormData(form);

        // Validación básica en el cliente (usar nombres correctos según HTML)
        const tipoDoc = formData.get('tipoDoc');
        const descripcion = formData.get('descripcion');
        const palabrasClaves = formData.get('palabrasClaves');

        if (!tipoDoc || !descripcion || !palabrasClaves) {
            showNotification('Por favor, completa los campos obligatorios.', 'warning');
            console.log({ tipoDoc, descripcion, palabrasClaves });
            return;
        }

        // Fecha de registro generada si no está
        if (!formData.get('fechaRegistro')) {
            const today = new Date().toISOString().split('T')[0];
            formData.append('FechaRegistro', today); // agregar con la clave que el backend espera
        }

        // Archivo: ya está dentro de formData si usas <input type="file" name="archivo">
        const fileInput = document.getElementById('archivo');
        if (fileInput && fileInput.files.length > 0) {
            formData.set('archivo', fileInput.files[0]);
        }

        try {
            const response = await fetch(`${API_BASE_URL}/guardar_entrada.php`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.success) {
                await fetchEntriesData();
                updateStats();
                renderTable();
                renderPagination();

                closeModal('registerModal');
                form.reset();
                showNotification(result.message, 'success');
            } else {
                if (Array.isArray(result.messages)) {
                    result.messages.forEach(msg => showNotification(msg, 'warning'));
                } else {
                    showNotification(result.message || 'Error inesperado al guardar.', 'warning');
                }
            }
        } catch (error) {
            console.error('Error al guardar la entrada:', error);
            showNotification(`Error inesperado: ${error.message}`, 'danger');
        }
    }



    /**
     * Opens the edit modal and preloads data for an existing entry.
     * @param {number} id - The ID of the entry to edit.
     */
    async function editEntry(id) {
        // Ensure dropdowns are populated before attempting to set their values
        await populateDropdowns(); // Re-populate just in case, or ensure it's done on load

        const entry = allEntries.find(e => e.Id == id); // Use '==' for type coercion if DB ID is string/number
        if (!entry) {
            showNotification('Entrada no encontrada para edición.', 'error');
            return;
        }

        // Fill the form fields with entry data
        document.getElementById('editId').value = entry.Id;
        document.getElementById('editTipoDoc').value = entry.TipoDoc || '';
        document.getElementById('editDescripcion').value = entry.Descripcion || '';
        document.getElementById('editPalabrasClaves').value = entry.PalabrasClaves || '';
        document.getElementById('editFechaFirma').value = entry.FechaFirma ? new Date(entry.FechaFirma).toISOString().split('T')[0] : '';
        document.getElementById('editImporte').value = entry.Importe || '';

        // Set the reference dropdown
        const editRefSelect = document.getElementById('editReferencia');
        if (editRefSelect) {
            editRefSelect.value = entry.Referencia || ''; // Match by value (ID)
        }

        // Handle "Procede de" radio buttons and fields for editing
        const editPersonaFisicaRadio = document.getElementById('editPersonaFisica');
        const editPersonaJuridicaRadio = document.getElementById('editPersonaJuridica');
        const editCampoPersonaFisica = document.getElementById('editCampoPersonaFisica');
        const editCampoInstitucion = document.getElementById('editCampoInstitucion');
        const editNombrePersona = document.getElementById('editNombrePersona');
        const editInstitucion = document.getElementById('editInstitucion');

        // Reset radio buttons and hide fields
        editPersonaFisicaRadio.checked = false;
        editPersonaJuridicaRadio.checked = false;
        editCampoPersonaFisica.style.display = 'none';
        editCampoInstitucion.style.display = 'none';
        editNombrePersona.value = '';
        editInstitucion.value = '';

        // Determine "procede de" based on available data from the entry
        if (entry.NombrePersona) {
            editPersonaFisicaRadio.checked = true;
            editCampoPersonaFisica.style.display = 'block';
            editNombrePersona.value = entry.NombrePersona;
        } else if (entry.InstitucionOrigen) {
            editPersonaJuridicaRadio.checked = true;
            editCampoInstitucion.style.display = 'block';
            // Find the institution ID based on its name to set the select value
            const matchedInstitution = allInstitutions.find(inst => inst.nombre === entry.InstitucionOrigen);
            if (matchedInstitution) {
                editInstitucion.value = matchedInstitution.id;
            }
        }
        // If neither, both fields remain hidden and no radio is checked (default state)

        openModal('editModal');
    }


    /**
     * Updates an existing entry in the backend.
     */
   async function updateEntry() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form); // Esto ya incluye el archivo si hay

    // Validación básica
    if (!formData.get('editTipoDoc') || !formData.get('editDescripcion')) {
        showNotification('Por favor, completa los campos obligatorios para la edición.', 'warning');
        return;
    }

    // Verificamos quién procede y limpiamos el que no se envía
    const selectedProcede = document.querySelector('input[name="editProcede"]:checked');
    if (selectedProcede) {
        formData.append('editProcede', selectedProcede.value);

        if (selectedProcede.value === 'pf') {
            formData.delete('editInstitucion');
        } else if (selectedProcede.value === 'pj') {
            formData.delete('editNombrePersona');
        }
    }

    try {
        const response = await fetch(`${API_BASE_URL}/actualizar_entrada.php`, {
            method: 'POST',
            body: formData // No usar headers aquí, FormData los gestiona automáticamente
        });

        const result = await response.json();

        if (result.success) {
            await fetchEntriesData(); // Si tienes esta función, actualiza los datos
            updateStats();
            renderTable();
            renderPagination();
            closeModal('editModal');
            showNotification(result.message, 'success');
        } else {
            const messages = Array.isArray(result.messages) ? result.messages.join('<br>') : result.message;
            showNotification(messages, 'error');
        }

    } catch (error) {
        console.error('Error al actualizar la entrada:', error);
        showNotification(`Error inesperado: ${error.message}`, 'error');
    }
}


    /**
     * Deletes an entry from the backend.
     * @param {number} id - The ID of the entry to delete.
     */
    async function deleteEntry(id) {
        if (!confirm('¿Estás seguro de que quieres eliminar esta entrada?')) {
            return;
        }

        try {
            const response = await fetch(`${API_BASE_URL}/eliminar_entrada.php`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ Id: id }) // Send ID in the body
            });

            const result = await response.json();

            if (result.success) {
                await fetchEntriesData(); // Reload data
                updateStats();
                renderTable();
                renderPagination();
                showNotification(result.message, 'success');
            } else {
                throw new Error(result.message || 'Error al eliminar la entrada.');
            }
        } catch (error) {
            console.error('Error al eliminar la entrada:', error);
            showNotification(`Error: ${error.message}`, 'error');
        }
    }


    // =======================================================
    // Funciones de Renderizado y Utilidad de UI
    // =======================================================

    /**
     * Renderiza la tabla de entradas basándose en `filteredEntries` y la paginación actual.
     */




    function renderTable() {
        const tableBody = document.getElementById('tableBody');
        const noData = document.getElementById('noData');
        tableBody.innerHTML = ''; // Limpiar la tabla antes de renderizar

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const entriesToDisplay = filteredEntries.slice(startIndex, endIndex);

        if (entriesToDisplay.length === 0) {
            noData.style.display = 'block'; // Show no data message
        } else {
            noData.style.display = 'none'; // Hide no data message
            entriesToDisplay.forEach(entry => {
                const row = tableBody.insertRow();
                row.innerHTML = `
                    <td>${entry.NumRegistro || 'N/A'}</td>
                    <td>${entry.FechaRegistro || 'N/A'}</td>
                    <td>${entry.TipoDoc || 'N/A'}</td>
                    <td>${entry.Descripcion || 'N/A'}</td>
                    <td>${getFormattedReference(entry.Referencia)}</td>
                    <td>${entry.FechaFirma || 'N/A'}</td>
                    <td>${entry.Importe || 'N/A'}</td>
                    
                    <td class="actions">
                        <button class="btn btn-info btn-small" onclick="editEntry(${entry.Id})">
                            <!-- ícono editar -->
                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 20h9" />
                                <path d="M16.5 3.5a2.121 2.121 0 1 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                            </svg>
                        </button> 
                        ${entry.Archivo
                                            ? `<a href="api/${entry.Archivo}" class="btn btn-success btn-small" target="_blank" download>
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3M12 4v8" />
                                        </svg>
                                    </a>`
                                            : ''
                                        }
                    </td>

                `;
            });
        }
    }




    /**
     * Actualiza la paginación visual y los botones de navegación.
     */
    function renderPagination() {
        const totalPages = Math.ceil(filteredEntries.length / itemsPerPage);
        const pageNumbersDiv = document.getElementById('pageNumbers');
        pageNumbersDiv.innerHTML = ''; // Clear existing page numbers

        // Render page number buttons
        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('btn-small');
            if (i === currentPage) {
                button.classList.add('active');
            }
            button.onclick = () => {
                currentPage = i;
                renderTable();
                renderPagination();
            };
            pageNumbersDiv.appendChild(button);
        }

        // Enable/disable Prev/Next buttons
        document.getElementById('prevBtn').disabled = currentPage === 1;
        document.getElementById('nextBtn').disabled = currentPage === totalPages;

        // Update pagination info text
        const startItem = Math.min((currentPage - 1) * itemsPerPage + 1, filteredEntries.length);
        const endItem = Math.min(currentPage * itemsPerPage, filteredEntries.length);
        document.getElementById('paginationInfo').textContent =
            `${startItem}-${endItem} de ${filteredEntries.length} entradas`;
    }

    /**
     * Cambia la página actual de la paginación.
     * @param {string} direction - 'prev' para ir a la página anterior, 'next' para la siguiente.
     */
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

    /**
     * Filtra las entradas basándose en el valor del campo de búsqueda.
     */
    function filterEntries() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        if (!searchTerm) {
            filteredEntries = [...allEntries];
        } else {
            filteredEntries = allEntries.filter(entry => {
                return (
                    (entry.NumRegistro && entry.NumRegistro.toLowerCase().includes(searchTerm)) ||
                    (entry.Descripcion && entry.Descripcion.toLowerCase().includes(searchTerm)) ||
                    (entry.Referencia && getReferenceNameById(entry.Referencia).toLowerCase().includes(searchTerm)) ||
                    (entry.TipoDoc && entry.TipoDoc.toLowerCase().includes(searchTerm)) ||
                    (entry.PalabrasClaves && entry.PalabrasClaves.toLowerCase().includes(searchTerm)) ||
                    (entry.NombrePersona && entry.NombrePersona.toLowerCase().includes(searchTerm)) ||
                    (entry.InstitucionOrigen && entry.InstitucionOrigen.toLowerCase().includes(searchTerm))
                );
            });
        }
        currentPage = 1; // Reset to first page after filtering
        renderTable();
        renderPagination();
        updateStats(); // Stats might change based on filtered results
    }

    /**
     * Actualiza los cuadros de estadísticas.
     */
    function updateStats() {
        document.getElementById('totalEntries').textContent = allEntries.length;

        const today = new Date().toISOString().split('T')[0];
        const todayCount = allEntries.filter(entry => entry.FechaRegistro === today).length;
        document.getElementById('todayEntries').textContent = todayCount;

        const currentMonth = new Date().toISOString().substring(0, 7); // YYYY-MM
        const monthCount = allEntries.filter(entry => entry.FechaRegistro && entry.FechaRegistro.startsWith(currentMonth)).length;
        document.getElementById('monthEntries').textContent = monthCount;

        // Assuming NumRegistro is sequential and you want the next available
        // This is a simplified client-side prediction; server-side generation is more robust.
        let maxNum = 0;
        allEntries.forEach(entry => {
            if (entry.NumRegistro) {
                const parts = entry.NumRegistro.split('-');
                if (parts.length === 3 && parts[0] === 'ER' && parts[1] === new Date().getFullYear().toString()) {
                    const num = parseInt(parts[2]);
                    if (!isNaN(num) && num > maxNum) {
                        maxNum = num;
                    }
                }
            }
        });
        const nextNum = maxNum + 1;
        document.getElementById('nextRegister').textContent = `ER-${new Date().getFullYear()}-${String(nextNum).padStart(3, '0')}`;
    }

    /**
     * Abre un modal específico.
     * @param {string} modalId - El ID del modal a abrir.
     */
    function openModal(modalId) {
        document.getElementById(modalId).classList.add('show');
    }

    /**
     * Cierra un modal específico y limpia los formularios dentro.
     * @param {string} modalId - El ID del modal a cerrar.
     */
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        if (modalId === 'registerModal') {
            document.getElementById('registerForm').reset();
            // Also reset "procede de" fields visibility
            document.getElementById('campoPersonaFisica').style.display = 'none';
            document.getElementById('campoInstitucion').style.display = 'none';
        } else if (modalId === 'editModal') {
            document.getElementById('editForm').reset();
            // Also reset "procede de" fields visibility for edit modal
            document.getElementById('editCampoPersonaFisica').style.display = 'none';
            document.getElementById('editCampoInstitucion').style.display = 'none';
        }
    }

    /**
     * Muestra una notificación temporal.
     * @param {string} message - El mensaje a mostrar.
     * @param {string} type - El tipo de notificación ('success', 'error', 'warning').
     */
    function showNotification(message, type) {
        // Implement your notification system here (e.g., using a div that appears and fades out)
        // For simplicity, using console.log for now.
        console.log(`Notification (${type}): ${message}`);
        alert(message); // A simple alert for demonstration
    }

    /**
     * Helper to get formatted reference name.
     * @param {number} refId - The ID of the reference.
     * @returns {string} Formatted reference name or 'N/A'.
     */
    function getFormattedReference(refId) {
        const ref = allReferences.find(r => r.id == refId);
        return ref ? `${ref.nombre}` : 'N/A';
    }

    /**
     * Helper to get reference name by ID.
     * Used for search filtering.
     * @param {number} refId - The ID of the reference.
     * @returns {string} Reference name or empty string if not found.
     */
    function getReferenceNameById(refId) {
        const ref = allReferences.find(r => r.id == refId);
        return ref ? ref.nombre : '';
    }

    /**
     * Helper to get institution name by ID.
     * @param {number} instId - The ID of the institution.
     * @returns {string} Institution name or empty string if not found.
     */
    function getInstitutionNameById(instId) {
        const inst = allInstitutions.find(i => i.id == instId);
        return inst ? inst.nombre : '';
    }
</script>