<style>
    /* Variables CSS para una gestión de colores más sencilla */
    :root {
        --primary-color: #3498db;
        /* Un azul profesional */
        --primary-dark-color: #2980b9;
        --secondary-color: #6c757d;
        /* Gris oscuro para texto secundario */
        --light-gray: #e9ecef;
        /* Fondo claro para tarjetas/elementos */
        --border-color: #ced4da;
        /* Color de borde estándar */
        --background-color: #f8f9fa;
        /* Fondo general de la página */
        --white: #ffffff;
        --black: #000000;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --info-color: #17a2b8;
    }




    /* Sección de estadísticas */
    .stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background-color: var(--white);
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: 1px solid var(--light-gray);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .stat-number {
        font-size: 2.8em;
        font-weight: bold;
        color: var(--primary-color);
        /* Color primario para números importantes */
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 0.95em;
        color: var(--secondary-color);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Controles (búsqueda y botón de añadir) */
    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
        /* Espacio entre elementos */
    }

    .search-box {
        position: relative;
        flex: 1;
        /* Permite que la caja de búsqueda crezca */
        min-width: 250px;
        /* Ancho mínimo para la caja de búsqueda */
    }

    .search-box input {
        width: 100%;
        padding: 12px 15px 12px 40px;
        /* Espacio para el icono */
        border: 1px solid var(--border-color);
        border-radius: 25px;
        /* Bordes más redondeados */
        font-size: 1em;
        transition: all 0.3s ease;
        background-color: var(--white);
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        /* Sombra al enfocar */
    }

    .search-box .search-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        fill: var(--secondary-color);
        /* Icono en gris */
        opacity: 0.7;
    }

    /* Botones */
    .btn {
        padding: 12px 25px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-size: 1em;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        text-transform: capitalize;
        /* Capitalizar la primera letra */
        letter-spacing: 0.2px;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: var(--white);
        box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark-color);
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(52, 152, 219, 0.4);
    }

    .btn-secondary {
        background-color: var(--light-gray);
        color: var(--secondary-color);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background-color: #dee2e6;
        color: #5a6268;
        transform: translateY(-1px);
    }

    .btn-small {
        padding: 8px 16px;
        font-size: 0.85em;
        border-radius: 20px;
    }

    /* Botones de acción específicos para la tabla */
    .btn-info {
        background-color: var(--info-color);
        color: var(--white);
    }

    .btn-info:hover {
        background-color: #117a8b;
    }

    .btn-warning {
        background-color: var(--warning-color);
        color: var(--black);
        /* Texto negro para mejor contraste con amarillo */
    }

    .btn-warning:hover {
        background-color: #d39e00;
    }

    .btn-success {
        background-color: var(--success-color);
        color: var(--white);
    }

    .btn-success:hover {
        background-color: #218838;
    }

    /* Tabla */
    .table-container {
        overflow-x: auto;
        /* Permite scroll horizontal en tablas grandes */
        background-color: var(--white);
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--light-gray);
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 800px;
        /* Asegura que la tabla tenga un ancho mínimo para el scroll */
    }

    .table th,
    .table td {
        padding: 15px;
        text-align: left;
        white-space: nowrap;
        /* Evita que el texto se rompa en varias líneas */
    }

    .table thead {
        background-color: var(--primary-color);
        color: var(--white);
    }

    .table th {
        font-weight: 600;
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid var(--primary-dark-color);
    }

    .table tbody tr {
        border-bottom: 1px solid #eee;
        transition: background-color 0.2s ease;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    /* Sin datos */
    .no-data {
        text-align: center;
        padding: 50px 20px;
        color: var(--secondary-color);
    }

    .no-data svg {
        width: 70px;
        height: 70px;
        fill: var(--border-color);
        /* Color suave para el icono */
        margin-bottom: 20px;
    }

    .no-data h3 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .no-data p {
        font-size: 1em;
    }

    /* Paginación */
    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
        margin-top: 25px;
    }

    .pagination button {
        background-color: var(--white);
        color: var(--primary-color);
        border: 1px solid var(--primary-color);
        padding: 8px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 40px;
        /* Asegura un tamaño mínimo para los botones */
    }

    .pagination button:hover:not(:disabled) {
        background-color: var(--primary-color);
        color: var(--white);
        box-shadow: 0 2px 8px rgba(52, 152, 219, 0.3);
    }

    .pagination button.active {
        background-color: var(--primary-color);
        color: var(--white);
        border-color: var(--primary-color);
    }

    .pagination button:disabled {
        background-color: var(--light-gray);
        color: var(--secondary-color);
        border-color: var(--border-color);
        cursor: not-allowed;
        opacity: 0.7;
    }

    .pagination-info {
        margin: 0 10px;
        font-size: 0.9em;
        color: var(--secondary-color);
    }

    /* Modal centrado */
    .modal {
        display: none;
        /* Oculto inicialmente */
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(3px);
        justify-content: center;
        align-items: center;
        z-index: 1000;

    }

    .modal-content {
        background: #fff;
        border-radius: 0.5rem;
        max-width: 700px;
        width: 90%;
        padding: 2rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.3);
        animation: fadeInUp 0.3s ease-out;

    }

    /* Cuando quieres mostrar el modal */
    .modal.show {
        display: flex;
    }


    /* Opcional: Estilo para el contenido del modal */

    /* Animación opcional */
    @keyframes slideFadeIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
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
        background-color: var(--primary-color);
        color: var(--white);
        padding: 20px 25px;
        border-radius: 10px 10px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.6em;
    }

    .close {
        color: var(--white);
        font-size: 30px;
        font-weight: bold;
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px 10px;
        border-radius: 5px;
        transition: background-color 0.2s ease;
    }

    .close:hover,
    .close:focus {
        background-color: rgba(255, 255, 255, 0.2);
        outline: none;
    }

    .modal-body {
        padding: 25px;
        flex-grow: 1;
        /* Permite que el cuerpo ocupe el espacio restante */
        overflow-y: auto;
        /* Scroll dentro del cuerpo del modal si es necesario */
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 20px 25px;
        border-top: 1px solid #eee;
        gap: 10px;
    }

    /* Formularios */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #444;
        font-size: 0.95em;
    }

    .form-group input[type="text"],
    .form-group input[type="date"],
    .form-group input[type="file"],
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        box-sizing: border-box;
        /* Incluye padding y border en el ancho */
        font-size: 1em;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="date"]:focus,
    .form-group input[type="file"]:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
    }

    .form-group textarea {
        resize: vertical;
        /* Solo permite redimensionar verticalmente */
        min-height: 90px;
    }

    .radio-group {
        display: flex;
        flex-wrap: wrap;
        /* Permite que los elementos se envuelvan */
        gap: 20px;
        /* Espacio entre los radio buttons */
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Íconos SVG */
    .icon {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        fill: currentColor;
        /* Asegura que el SVG use el color de texto del padre */
        transition: transform 0.2s ease-in-out;
    }

    /* Animación de iconos en botones al hacer hover */
    button:hover .icon {
        transform: scale(1.1);
    }

    /* Tooltip */
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 90px;
        /* Ancho ajustado para el texto */
        background-color: #333;
        color: var(--white);
        text-align: center;
        font-size: 12px;
        padding: 7px 8px;
        border-radius: 5px;
        position: absolute;
        z-index: 1001;
        /* Asegura que esté por encima del modal */
        bottom: 125%;
        /* Posiciona encima del elemento */
        left: 50%;
        transform: translateX(-50%);
        /* Centra el tooltip */
        opacity: 0;
        transition: opacity 0.3s ease, visibility 0.3s ease;
        pointer-events: none;
        /* No interfiere con clics */
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    /* Media Queries para Responsividad */
    @media (max-width: 768px) {

        .stats {
            grid-template-columns: 1fr 1fr;
            /* 2 columnas en pantallas medianas */
        }

        .controls {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .search-box {
            min-width: 100%;
        }

        .btn {
            width: 100%;
            /* Botones ocupan todo el ancho */
            justify-content: center;
            padding: 10px 20px;
        }

        .table th,
        .table td {
            padding: 12px 10px;
        }

        .modal-content {
            width: 98%;
            margin: 10px;
        }

        .modal-header h2 {
            font-size: 1.3em;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            flex-direction: column;
            /* Botones del footer apilados */
            padding: 15px 20px;
        }

        .modal-footer .btn {
            width: auto;
            /* Restaurar ancho automático para los botones del footer */
        }
    }

    @media (max-width: 480px) {
        .stats {
            grid-template-columns: 1fr;
            /* 1 columna en pantallas pequeñas */
        }

        .stat-card {
            padding: 20px;
        }

        .stat-number {
            font-size: 2.2em;
        }

        .search-box input {
            padding: 10px 12px 10px 35px;
        }

        .btn {
            font-size: 0.9em;
            padding: 10px 15px;
        }

        .table {
            min-width: 600px;
            /* Ajustar el mínimo ancho de la tabla si es necesario */
        }
    }
</style>



<div class="container-fluid p-4">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number" id="totalPagos">0</div>
            <div class="stat-label">Total Pagos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="todayPagos">0</div>
            <div class="stat-label">Pagos Hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="monthPagos">0</div>
            <div class="stat-label">Pagos Este Mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="nextRegisterPagos">N/A</div>
            <div class="stat-label">Próximo Pago</div>
        </div>
    </div>

    <div class="controls">
        <div class="search-box">
            <input type="text" id="pagoSearchInput" placeholder="Buscar por concepto, descripción o beneficiario...">
            <svg class="search-icon" viewBox="0 0 24 24">
                <path
                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
            </svg>
        </div>
        <button class="btn btn-primary" onclick="openModal('registerPagoModal')">
            <svg class="icon" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
            Nuevo Pago
        </button>
    </div>

    <div class="table-container pb-3">
        <table class="table" id="pagosTable">
            <thead>
                <tr>
                    <th>Num Registro</th>
                    <th>Concepto</th>
                    <th>Beneficiario</th>
                    <th>Banco</th>
                    <th>Cantidad</th>
                    <th>Fecha Firma</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="pagosTableBody">
            </tbody>
        </table>
        <div id="noPagosData" class="no-data" style="display: none;">
            <svg viewBox="0 0 24 24">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
            </svg>
            <h3>No hay datos disponibles</h3>
            <p>No se encontraron pagos que coincidan con tu búsqueda</p>
        </div>
        <div class="pagination">
            <button onclick="changePagoPage('prev')" id="prevPagoBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                </svg>
            </button>
            <div id="pagoPageNumbers"></div>
            <button onclick="changePagoPage('next')" id="nextPagoBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </button>
            <div class="pagination-info" id="pagoPaginationInfo"></div>
        </div>
    </div>
</div>

<div id="registerPagoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nuevo Pago</h2>
            <button class="close" onclick="closeModal('registerPagoModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="registerPagoForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="pagoConcepto">Concepto</label>
                    <input type="text" id="pagoConcepto" name="concepto" placeholder="Concepto del pago" required>
                </div>
                <div class="form-group">
                    <label for="pagoBeneficiario">Beneficiario</label>
                    <input type="text" id="pagoBeneficiario" name="beneficiario" placeholder="Nombre del beneficiario"
                        required>
                </div>
                <div class="form-group">
                    <label for="pagoBanco">Banco</label>
                    <select id="pagoBanco" name="banco" required>
                        <option value="">Seleccione un banco...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="pagoCantidad">Cantidad</label>
                    <input type="number" id="pagoCantidad" name="cantidad" step="0.01" min="0" placeholder="0.00"
                        required>
                </div>
                <div class="form-group">
                    <label for="pagoFechaFirma">Fecha de Firma</label>
                    <input type="date" id="pagoFechaFirma" name="fechaFirma" required>
                </div>
                <div class="form-group">
                    <label for="pagoDescripcion">Descripción</label>
                    <textarea id="pagoDescripcion" name="descripcion" class="ckeditor"
                        placeholder="Descripción detallada del pago"></textarea>
                </div>
                <div class="form-group">
                    <label for="pagoArchivo">Adjuntar Comprobante (PDF)</label>
                    <input type="file" id="pagoArchivo" name="archivo" accept=".pdf" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('registerPagoModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="saveNewPago()">Guardar</button>
        </div>
    </div>
</div>

<div id="editPagoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Pago</h2>
            <button class="close" onclick="closeModal('editPagoModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editPagoForm" enctype="multipart/form-data">
                <input type="hidden" id="editPagoId" name="id">
                <input type="hidden" id="editPagoNumRegistro" name="numRegistro">
                <div class="form-group">
                    <label for="editPagoConcepto">Concepto</label>
                    <input type="text" id="editPagoConcepto" name="concepto" required>
                </div>
                <div class="form-group">
                    <label for="editPagoBeneficiario">Beneficiario</label>
                    <input type="text" id="editPagoBeneficiario" name="beneficiario" required>
                </div>
                <div class="form-group">
                    <label for="editPagoBanco">Banco</label>
                    <select id="editPagoBanco" name="banco" required>
                        <option value="">Seleccione un banco...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editPagoCantidad">Cantidad</label>
                    <input type="number" id="editPagoCantidad" name="cantidad" step="0.01" min="0" required>
                </div>
                <div class="form-group">
                    <label for="editPagoFechaFirma">Fecha de Firma</label>
                    <input type="date" id="editPagoFechaFirma" name="fechaFirma" required>
                </div>
                <div class="form-group">
                    <label for="editPagoDescripcion">Descripción</label>
                    <textarea id="editPagoDescripcion" name="descripcion" class="ckeditor"></textarea>
                </div>
                <div class="form-group">
                    <label for="editPagoArchivo">Archivo PDF</label>
                    <span id="currentPagoArchivoName" style="margin-left: 10px;"></span>
                    <input type="file" id="editPagoArchivo" name="archivo" accept=".pdf">
                    <small>Deja en blanco para mantener el archivo actual. Selecciona uno nuevo para
                        reemplazarlo.</small>
                    <div class="form-check" style="margin-top: 10px;">
                        <input type="checkbox" id="removeCurrentPagoFile" name="remove_current_file" value="true">
                        <label for="removeCurrentPagoFile" class="form-check-label">Eliminar archivo actual</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('editPagoModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="updatePago()">Actualizar</button>
        </div>
    </div>
</div>


<script>
    // =========================================================
    // Pagos Module Variables
    // =========================================================
    let currentPagePagos = 1;
    const recordsPerPagePagos = 10; // O la cantidad de registros por página que prefieras
    const pagoSearchInput = document.getElementById('pagoSearchInput');
    const pagosTableBody = document.getElementById('pagosTableBody');
    const noPagosData = document.getElementById('noPagosData');

    // =========================================================
    // Pagos Module Event Listeners
    // =========================================================
    document.addEventListener('DOMContentLoaded', () => {
        // Carga inicial de pagos (cuando el módulo está activo)
        loadPagos();
        // Carga los bancos para los select en ambos modales (nuevo y editar)
        loadBancos('pagoBanco');
        loadBancos('editPagoBanco');

        // Event listener para la búsqueda de pagos
        pagoSearchInput.addEventListener('input', () => {
            currentPagePagos = 1; // Reinicia la página en cada nueva búsqueda
            loadPagos();
        });
    });

    // =========================================================
    // Pagos Module Functions
    // =========================================================

    // Función auxiliar para poblar los select de bancos
    async function loadBancos(selectId) {
        const selectElement = document.getElementById(selectId);
        selectElement.innerHTML = '<option value="">Cargando bancos...</option>'; // Placeholder

        try {
            const response = await fetch('api/listar_bancos.php');
            const result = await response.json();

            if (result.success) {
                selectElement.innerHTML = '<option value="">Seleccione un banco...</option>'; // Reinicia el select
                result.data.forEach(banco => {
                    const option = document.createElement('option');
                    option.value = banco.Id;
                    option.textContent = banco.Nombre;
                    selectElement.appendChild(option);
                });
            } else {
                console.error('Error al cargar bancos:', result.message);
                selectElement.innerHTML = '<option value="">Error al cargar bancos</option>';
            }
        } catch (error) {
            console.error('Error de red al cargar bancos:', error);
            selectElement.innerHTML = '<option value="">Error de conexión</option>';
        }
    }

    // READ: Cargar y mostrar Pagos en la tabla
    async function loadPagos() {
        const query = `api/listar_pagos.php?limit=${recordsPerPagePagos}&page=${currentPagePagos}&search=${pagoSearchInput.value}`;
        try {
            const response = await fetch(query);
            const result = await response.json();

            if (result.success) {
                // Actualiza las estadísticas
                document.getElementById('totalPagos').textContent = result.totalRecords;
                document.getElementById('todayPagos').textContent = result.todayRecords;
                document.getElementById('monthPagos').textContent = result.monthRecords;
                document.getElementById('nextRegisterPagos').textContent = result.nextRegister;

                pagosTableBody.innerHTML = ''; // Limpia la tabla antes de añadir nuevos datos
                if (result.data.length > 0) {
                    noPagosData.style.display = 'none'; // Oculta el mensaje de "no datos"
                    result.data.forEach(pago => {
                        const row = pagosTableBody.insertRow();
                        row.innerHTML = `
                            <td>${pago.NumRegistro}</td>
                            <td>${pago.Concepto}</td>
                            <td>${pago.Beneficiario}</td>
                            <td>${pago.NombreBanco || 'N/A'}</td>
                            <td>${parseFloat(pago.Cantidad).toLocaleString('es-GQ', { style: 'currency', currency: 'XAF' })}</td>
                            <td>${pago.FechaFirma}</td>
                            <td>${pago.Archivo ? `<a href="api/uploads/pagos/${pago.Archivo}" target="_blank">Ver</a>` : 'N/A'}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="showEditModalPago(${pago.Id})">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="deletePago(${pago.Id})">Eliminar</button>
                            </td>
                        `;
                    });
                } else {
                    // Muestra mensaje si no hay pagos
                    noPagosData.style.display = 'block';
                    noPagosData.querySelector('h3').textContent = 'No se encontraron pagos';
                    noPagosData.querySelector('p').textContent = 'No hay registros de pagos que coincidan con la búsqueda.';
                }
                updatePaginationPagos(result.totalRecords); // Actualiza la paginación
            } else {
                alert('Error al cargar los pagos: ' + result.message);
                console.error('Error al cargar los pagos:', result.message);
                noPagosData.style.display = 'block';
                noPagosData.querySelector('h3').textContent = 'Error al cargar datos';
                noPagosData.querySelector('p').textContent = result.message;
            }
        } catch (error) {
            alert('Error de conexión al servidor.');
            console.error('Error de red:', error);
            noPagosData.style.display = 'block';
            noPagosData.querySelector('h3').textContent = 'Error de conexión';
            noPagosData.querySelector('p').textContent = 'No se pudo conectar al servidor para obtener los pagos.';
        }
    }

    // CREATE: Guardar Nuevo Pago
    async function saveNewPago() {
        const form = document.getElementById('registerPagoForm');
        const formData = new FormData(form);

        // Obtiene la descripción del textarea normal (sin CKEditor)
        formData.set('descripcion', document.getElementById('pagoDescripcion').value);

        try {
            const response = await fetch('api/guardar_pagos.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Pago registrado correctamente. NumRegistro: ' + result.numRegistro);
                closeModal('registerPagoModal');
                form.reset(); // Reinicia el formulario
                loadPagos(); // Recarga la tabla para mostrar el nuevo pago
            } else {
                alert('Error al registrar pago: \n' + (result.messages ? result.messages.join('\n') : result.message));
            }
        } catch (error) {
            console.error('Error de red:', error);
            alert('Error de conexión al servidor al registrar pago.');
        }
    }

    // UPDATE: Mostrar Modal de Edición de Pago
    async function showEditModalPago(id) {
        try {
            const response = await fetch(`api/obtener_pagos.php?id=${id}`);
            const result = await response.json();

            if (result.success && result.data) {
                const pago = result.data;
                document.getElementById('editPagoId').value = pago.Id;
                document.getElementById('editPagoNumRegistro').value = pago.NumRegistro;

                document.getElementById('editPagoConcepto').value = pago.Concepto;
                document.getElementById('editPagoBeneficiario').value = pago.Beneficiario;
                document.getElementById('editPagoCantidad').value = pago.Cantidad;
                document.getElementById('editPagoFechaFirma').value = pago.FechaFirma;

                // Precarga la descripción en el textarea normal
                document.getElementById('editPagoDescripcion').value = pago.Descripcion || '';

                // Selecciona el banco correcto en el dropdown
                document.getElementById('editPagoBanco').value = pago.Banco;

                // Maneja la visualización del archivo actual
                const currentArchivoNameSpan = document.getElementById('currentPagoArchivoName');
                const removeFileCheckbox = document.getElementById('removeCurrentPagoFile');
                if (pago.Archivo) {
                    currentArchivoNameSpan.innerHTML = `Archivo actual: <a href="api/uploads/pagos/${pago.Archivo}" target="_blank">${pago.Archivo}</a>`;
                    removeFileCheckbox.checked = false; // Asegura que no esté marcado inicialmente
                } else {
                    currentArchivoNameSpan.textContent = 'No hay archivo adjunto.';
                    removeFileCheckbox.checked = false; // Si no hay archivo, no tiene sentido la opción de eliminarlo
                }

                openModal('editPagoModal');
            } else {
                alert('Error al cargar los datos del pago para edición: ' + result.message);
                console.error('Error al cargar los datos del pago para edición:', result.message);
            }
        } catch (error) {
            console.error('Error de red:', error);
            alert('Error de conexión al servidor al cargar datos de pago.');
        }
    }

    // UPDATE: Enviar Actualización de Pago
    async function updatePago() {
        const form = document.getElementById('editPagoForm');
        const formData = new FormData(form);

        // Obtiene la descripción del textarea normal
        formData.set('descripcion', document.getElementById('editPagoDescripcion').value);

        // Maneja la eliminación del archivo si el checkbox está marcado
        if (document.getElementById('removeCurrentPagoFile').checked) {
            formData.append('remove_current_file', 'true');
        } else {
            formData.delete('remove_current_file'); // Asegura que no se envíe si no está marcado
        }

        try {
            const response = await fetch('api/actualizar_pagos.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Pago actualizado correctamente.');
                closeModal('editPagoModal');
                loadPagos(); // Recarga la tabla para mostrar los cambios
            } else {
                alert('Error al actualizar pago: \n' + (result.messages ? result.messages.join('\n') : result.message));
            }
        } catch (error) {
            console.error('Error de red:', error);
            alert('Error de conexión al servidor al actualizar pago.');
        }
    }

    // DELETE: Eliminar Pago
    async function deletePago(id) {
        if (!confirm('¿Estás seguro de que quieres eliminar este pago? Esta acción no se puede deshacer.')) {
            return; // Si el usuario cancela, no hace nada
        }

        try {
            const response = await fetch('api/eliminar_pagos.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: id })
            });
            const result = await response.json();

            if (result.success) {
                alert('Pago eliminado correctamente.');
                loadPagos(); // Recarga la tabla
            } else {
                alert('Error al eliminar pago: \n' + (result.message || 'Error desconocido.'));
            }
        } catch (error) {
            console.error('Error de red:', error);
            alert('Error de conexión al servidor al eliminar pago.');
        }
    }

    // =========================================================
    // Funciones de Paginación para Pagos
    // =========================================================
    function updatePaginationPagos(totalRecords) {
        const totalPages = Math.ceil(totalRecords / recordsPerPagePagos);
        const pageNumbersContainer = document.getElementById('pagoPageNumbers');
        pageNumbersContainer.innerHTML = '';

        const maxPagesToShow = 5; // Número máximo de botones de página a mostrar

        let startPage = Math.max(1, currentPagePagos - Math.floor(maxPagesToShow / 2));
        let endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

        if (endPage - startPage + 1 < maxPagesToShow) {
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        // Botón "Primera"
        if (currentPagePagos > 1) {
            const firstBtn = document.createElement('button');
            firstBtn.textContent = '<<';
            firstBtn.classList.add('btn', 'btn-secondary', 'btn-sm', 'mx-1');
            firstBtn.onclick = () => { currentPagePagos = 1; loadPagos(); };
            pageNumbersContainer.appendChild(firstBtn);
        }

        for (let i = startPage; i <= endPage; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.classList.add('btn', 'btn-secondary', 'btn-sm', 'mx-1');
            if (i === currentPagePagos) {
                button.classList.add('active', 'btn-primary'); // Clase activa para Bootstrap
            }
            button.onclick = () => {
                currentPagePagos = i;
                loadPagos();
            };
            pageNumbersContainer.appendChild(button);
        }

        // Botón "Última"
        if (currentPagePagos < totalPages) {
            const lastBtn = document.createElement('button');
            lastBtn.textContent = '>>';
            lastBtn.classList.add('btn', 'btn-secondary', 'btn-sm', 'mx-1');
            lastBtn.onclick = () => { currentPagePagos = totalPages; loadPagos(); };
            pageNumbersContainer.appendChild(lastBtn);
        }

        // Deshabilita/habilita los botones de navegación principal
        document.getElementById('prevPagoBtn').disabled = currentPagePagos === 1;
        document.getElementById('nextPagoBtn').disabled = currentPagePagos === totalPages;

        // Información de paginación actual
        const startRecord = (currentPagePagos - 1) * recordsPerPagePagos + 1;
        const endRecord = Math.min(currentPagePagos * recordsPerPagePagos, totalRecords);
        document.getElementById('pagoPaginationInfo').textContent = `Mostrando ${startRecord}-${endRecord} de ${totalRecords} pagos`;
    }

    // Cambiar de página (anterior/siguiente)
    function changePagoPage(direction) {
        if (direction === 'prev' && currentPagePagos > 1) {
            currentPagePagos--;
        } else if (direction === 'next' && currentPagePagos < Math.ceil(document.getElementById('totalPagos').textContent / recordsPerPagePagos)) {
            currentPagePagos++;
        }
        loadPagos();
    }


    // =========================================================
    // Funciones Generales de Modales
    // =========================================================

    /**
     * Abre un modal específico.
     * @param {string} modalId El ID del elemento modal a abrir.
     */
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show'); // Añade la clase 'show' para mostrar el modal (Bootstrap)
            modal.style.display = 'flex'; // Asegura que se muestre como flex para centrado
            document.body.style.overflow = 'hidden'; // Evita el scroll del cuerpo
        }
    }

    /**
     * Cierra un modal específico y resetea los formularios.
     * @param {string} modalId El ID del elemento modal a cerrar.
     */
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show'); // Remueve la clase 'show'
            modal.style.display = 'none'; // Oculta el modal
            document.body.style.overflow = ''; // Restaura el scroll del cuerpo

            // Si es el modal de registro, resetea el formulario
            if (modalId === 'registerPagoModal') {
                const form = document.getElementById('registerPagoForm');
                if (form) {
                    form.reset();
                    // Limpiar el textarea de descripción
                    document.getElementById('pagoDescripcion').value = '';
                }
            }
            // Si es el modal de edición, resetea el formulario de edición
            else if (modalId === 'editPagoModal') {
                const form = document.getElementById('editPagoForm');
                if (form) {
                    form.reset();
                    // Limpiar el textarea de descripción
                    document.getElementById('editPagoDescripcion').value = '';
                    // Limpia el nombre del archivo actual y desmarca el checkbox de eliminación
                    document.getElementById('currentPagoArchivoName').textContent = '';
                    document.getElementById('removeCurrentPagoFile').checked = false;
                }
            }
        }
    }

    // Cierra el modal si se hace clic fuera de su contenido
    window.addEventListener('click', (event) => {
        const registerModal = document.getElementById('registerPagoModal');
        const editModal = document.getElementById('editPagoModal');

        if (event.target === registerModal) {
            closeModal('registerPagoModal');
        }
        if (event.target === editModal) {
            closeModal('editPagoModal');
        }
    });

</script>