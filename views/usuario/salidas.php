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



<div class="container-fluid p-4 ">
    <div class="stats">
        <div class="stat-card">
            <div class="stat-number" id="totalSalidas">0</div>
            <div class="stat-label">Total Salidas</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="todaySalidas">0</div>
            <div class="stat-label">Hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="monthSalidas">0</div>
            <div class="stat-label">Este Mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="nextRegisterSalidas">SL-2024-001</div>
            <div class="stat-label">Próximo Registro</div>
        </div>
    </div>

    <div class="controls">
        <div class="search-box">
            <input type="text" id="searchInputSalidas" placeholder="Buscar por número, descripción, referencia...">
            <svg class="search-icon" viewBox="0 0 24 24">
                <path
                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
            </svg>
        </div>
        <button class="btn btn-primary" onclick="openModal('registerModalSalidas')">
            <svg class="icon" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
            Nueva Salida
        </button>
    </div>

    <div class="table-container pb-3">
        <table class="table table-striped table-hover" id="salidasTable">
            <thead>
                <tr>
                    <th>Nº Registro</th>
                    <th>Fecha</th>
                    <th>Tipo Doc.</th>
                    <th>Descripción</th>
                    <th>Palabras Claves</th>
                    <th>Referencia</th>
                    <th>Fecha Firma</th>
                    <th>Importe</th>
                    <th>Envío a</th>
                    <th>Entrada Relacionada</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tableBodySalidas">
            </tbody>
        </table>
        <div id="noDataSalidas" class="no-data" style="display: none;">
            <svg viewBox="0 0 24 24">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
            </svg>
            <h3>No hay datos disponibles</h3>
            <p>No se encontraron salidas que coincidan con tu búsqueda</p>
        </div>
        <div class="pagination">
            <button onclick="changePageSalidas('prev')" id="prevBtnSalidas">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                </svg>
            </button>
            <div id="pageNumbersSalidas"></div>
            <button onclick="changePageSalidas('next')" id="nextBtnSalidas">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </button>
            <div class="pagination-info" id="paginationInfoSalidas"></div>
        </div>
    </div>
</div>

<div id="registerModalSalidas" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>FORMULARIO DE REGISTRO DE SALIDAS</h2>
            <button class="close" onclick="closeModal('registerModalSalidas')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="registerFormSalidas" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="TipoDocSalida">Tipo de Documento</label>
                    <input type="text" class="form-control" id="TipoDocSalida" name="TipoDoc"
                        placeholder="Ejemplo: carta, oficio, contrato...">
                </div>
                <div class="form-group">
                    <label for="descripcionSalida">Descripción</label>
                    <textarea name="descripcion" id="descripcionSalida" class="form-control" cols="30" rows="5"
                        placeholder="Descripción detallada del documento"></textarea>
                </div>
                <div class="form-group">
                    <label for="palabrasClavesSalida">Palabras Claves del Documento</label>
                    <input type="text" class="form-control" id="palabrasClavesSalida" name="palabrasClaves"
                        placeholder="Ejemplo: solicitud, permiso, informe, acuerdo...">
                </div>
                <div class="form-group">
                    <label for="fechaFirmaSalida">¿Cuando se Firmó el documento?</label>
                    <input type="date" class="form-control" id="fechaFirmaSalida" name="fechaFirma">
                </div>
                <div class="form-group">
                    <label for="importeSalida">Importe</label>
                    <input type="text" class="form-control" id="importeSalida" name="importe"
                        placeholder="Ejemplo: 1.000.000 (opcional)">
                </div>
                <div class="form-group">
                    <label for="refSalida">Seleccione la Referencia</label>
                    <select class="form-control" id="refSalida" name="ref">
                        <option selected value="">seleccione una referencia.....</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="archivoSalida">Selecciona el Documento (PDF)</label>
                    <input type="file" class="form-control" id="archivoSalida" name="archivo" accept=".pdf">
                </div>

                <label>Se envía a...</label>
                <div class="form-group radio-group">
                    <div class="radio-item">
                        <input class="checkbox" name="destinoTipo" type="radio" id="perFSSalida" value="pf">
                        <label for="perFSSalida">Una Persona Física</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="destinoTipo" type="radio" id="perJSSalida" value="pj">
                        <label for="perJSSalida">Una Persona Jurídica</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="destinoTipo" type="radio" id="vperJSSalida" value="vpj">
                        <label for="vperJSSalida">Varias Personas Jurídicas</label>
                    </div>
                </div>

                <div class="form-group" id="pfsSalida" style="display:none;">
                    <label for="persFisicSalida">Nombre Completo de la Persona</label>
                    <input type="text" class="form-control" id="persFisicSalida" name="persFisic"
                        placeholder="Ingrese el nombre completo de la persona">
                </div>
                <div class="form-group" id="pjsSalida" style="display:none;">
                    <label for="institucionSalida">Seleccione la Institución</label>
                    <select class="form-control" id="institucionSalida" name="institucion">
                        <option selected value="">seleccione una Institución.....</option>
                    </select>
                </div>

                <div class="form-group" id="vpjsSalida" style="display:none;">
                    <label>
                        <h5>Institución y Sección</h5>
                    </label>
                    <div id="checkboxesInstiDepartSalida">
                    </div>
                </div>

                <label>¿Tuvo una Entrada relacionada?</label>
                <div class="form-group radio-group">
                    <div class="radio-item">
                        <input class="checkbox" name="entradaRelacionada" type="radio" id="siEntradaSalida" value="si">
                        <label for="siEntradaSalida">Sí</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="entradaRelacionada" type="radio" id="noEntradaSalida" value="no"
                            checked>
                        <label for="noEntradaSalida">No</label>
                    </div>
                </div>

                <div class="form-group" id="entradasRelacionadasSalida" style="display:none;">
                    <label for="selectEntradasSalida">Seleccione la Entrada</label>
                    <select class="form-control" id="selectEntradasSalida" name="selEntrada">
                        <option selected value="">seleccione una Entrada.....</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('registerModalSalidas')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">GUARDAR SALIDA</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editModalSalidas" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Salida</h2>
            <button class="close" onclick="closeModal('editModalSalidas')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editFormSalidas" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="editIdSalida" name="id">
                <div class="form-group">
                    <label for="editTipoDocSalida">Tipo de Documento</label>
                    <input type="text" class="form-control" id="editTipoDocSalida" name="TipoDoc">
                </div>
                <div class="form-group">
                    <label for="editDescripcionSalida">Descripción</label>
                    <textarea id="editDescripcionSalida" name="descripcion" class="form-control" cols="30"
                        rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label for="editPalabrasClavesSalida">Palabras Claves del Documento</label>
                    <input type="text" class="form-control" id="editPalabrasClavesSalida" name="palabrasClaves">
                </div>
                <div class="form-group">
                    <label for="editFechaFirmaSalida">Fecha de Firma</label>
                    <input type="date" class="form-control" id="editFechaFirmaSalida" name="fechaFirma">
                </div>
                <div class="form-group">
                    <label for="editImporteSalida">Importe</label>
                    <input type="text" class="form-control" id="editImporteSalida" name="importe">
                </div>
                <div class="form-group">
                    <label for="editRefSalida">Referencia</label>
                    <select class="form-control" id="editRefSalida" name="ref">
                        <option value="">Seleccione una referencia...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="editArchivoSalida">Archivo PDF Actual</label>
                    <span id="currentPdfNameSalida" style="margin-left: 10px;"></span>
                    <input type="file" class="form-control" id="editArchivoSalida" name="archivo" accept=".pdf">
                    <small>Deja en blanco para mantener el archivo actual. Selecciona uno nuevo para
                        reemplazarlo.</small>
                </div>

                <label>Se envía a:</label>
                <div class="form-group radio-group">
                    <div class="radio-item">
                        <input class="checkbox" name="editDestinoTipo" type="radio" id="editPerFSSalida" value="pf">
                        <label for="editPerFSSalida">Una Persona Física</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="editDestinoTipo" type="radio" id="editPerJSSalida" value="pj">
                        <label for="editPerJSSalida">Una Persona Jurídica</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="editDestinoTipo" type="radio" id="editVperJSSalida" value="vpj">
                        <label for="editVperJSSalida">Varias Personas Jurídicas</label>
                    </div>
                </div>

                <div class="form-group" id="editPfsSalida" style="display:none;">
                    <label for="editPersFisicSalida">Nombre Completo de la Persona</label>
                    <input type="text" class="form-control" id="editPersFisicSalida" name="persFisic">
                </div>
                <div class="form-group" id="editPjsSalida" style="display:none;">
                    <label for="editInstitucionSalida">Seleccione la Institución</label>
                    <select class="form-control" id="editInstitucionSalida" name="institucion">
                        <option value="">seleccione una Institución.....</option>
                    </select>
                </div>
                <div class="form-group" id="editVpjsSalida" style="display:none;">
                    <label>
                        <h5>Institución y Sección</h5>
                    </label>
                    <div id="editCheckboxesInstiDepartSalida">
                    </div>
                </div>

                <label>¿Tuvo una Entrada relacionada?</label>
                <div class="form-group radio-group">
                    <div class="radio-item">
                        <input class="checkbox" name="editEntradaRelacionada" type="radio" id="editSiEntradaSalida"
                            value="si">
                        <label for="editSiEntradaSalida">Sí</label>
                    </div>
                    <div class="radio-item">
                        <input class="checkbox" name="editEntradaRelacionada" type="radio" id="editNoEntradaSalida"
                            value="no">
                        <label for="editNoEntradaSalida">No</label>
                    </div>
                </div>

                <div class="form-group" id="editEntradasRelacionadasSalida" style="display:none;">
                    <label for="editSelectEntradasSalida">Seleccione la Entrada</label>
                    <select class="form-control" id="editSelectEntradasSalida" name="selEntrada">
                        <option value="">seleccione una Entrada.....</option>
                    </select>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        onclick="closeModal('editModalSalidas')">Cancelar</button>
                    <button type="submit" class="btn btn-primary">ACTUALIZAR SALIDA</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const registerModalSalidas = document.getElementById('registerModalSalidas');
        const editModalSalidas = document.getElementById('editModalSalidas');
        const registerFormSalidas = document.getElementById('registerFormSalidas');
        const editFormSalidas = document.getElementById('editFormSalidas');
        const tableBodySalidas = document.getElementById('tableBodySalidas');
        const searchInputSalidas = document.getElementById('searchInputSalidas');
        const noDataSalidas = document.getElementById('noDataSalidas');

        // Elementos para mostrar/ocultar en el formulario de registro
        const perFSSalida = document.getElementById('perFSSalida');
        const perJSSalida = document.getElementById('perJSSalida');
        const vperJSSalida = document.getElementById('vperJSSalida');
        const pfsSalida = document.getElementById('pfsSalida');
        const pjsSalida = document.getElementById('pjsSalida');
        const vpjsSalida = document.getElementById('vpjsSalida');

        const siEntradaSalida = document.getElementById('siEntradaSalida');
        const noEntradaSalida = document.getElementById('noEntradaSalida');
        const entradasRelacionadasSalida = document.getElementById('entradasRelacionadasSalida');

        // Elementos para mostrar/ocultar en el formulario de edición
        const editPerFSSalida = document.getElementById('editPerFSSalida');
        const editPerJSSalida = document.getElementById('editPerJSSalida');
        const editVperJSSalida = document.getElementById('editVperJSSalida');
        const editPfsSalida = document.getElementById('editPfsSalida');
        const editPjsSalida = document.getElementById('editPjsSalida');
        const editVpjsSalida = document.getElementById('editVpjsSalida');

        const editSiEntradaSalida = document.getElementById('editSiEntradaSalida');
        const editNoEntradaSalida = document.getElementById('editNoEntradaSalida');
        const editEntradasRelacionadasSalida = document.getElementById('editEntradasRelacionadasSalida');

        let currentPage = 1;
        const recordsPerPage = 10; // Número de registros por página

        // --- Funciones para Modales ---
        window.openModal = function (modalId) {
            document.getElementById(modalId).style.display = 'block';
            if (modalId === 'registerModalSalidas') {
                resetRegisterForm();
                // Cargar datos en los selects al abrir el modal de registro
                loadReferences('refSalida');
                loadInstitutions('institucionSalida');
                loadDepartmentsForMultiple('checkboxesInstiDepartSalida');
                loadEntries('selectEntradasSalida');
                // Inicializar visibilidad de campos condicionales
                toggleDestinoFields('register');
                toggleEntradaRelacionadaFields('register');
            }
            // Para el modal de edición, la carga de datos se hace en showEditModal
        };

        window.closeModal = function (modalId) {
            document.getElementById(modalId).style.display = 'none';
        };

        window.onclick = function (event) {
            if (event.target == registerModalSalidas) {
                closeModal('registerModalSalidas');
            }
            if (event.target == editModalSalidas) {
                closeModal('editModalSalidas');
            }
        };

        // --- Funciones para campos condicionales (Persona Física/Jurídica/Varias) ---
        function toggleDestinoFields(formType, initialValue = null) {
            let pfRadio, pjRadio, vpjRadio, pfDiv, pjDiv, vpjDiv;

            if (formType === 'register') {
                pfRadio = perFSSalida;
                pjRadio = perJSSalida;
                vpjRadio = vperJSSalida;
                pfDiv = pfsSalida;
                pjDiv = pjsSalida;
                vpjDiv = vpjsSalida;
            } else { // edit
                pfRadio = editPerFSSalida;
                pjRadio = editPerJSSalida;
                vpjRadio = editVperJSSalida;
                pfDiv = editPfsSalida;
                pjDiv = editPjsSalida;
                vpjDiv = editVpjsSalida;
            }

            pfDiv.style.display = 'none';
            pjDiv.style.display = 'none';
            vpjDiv.style.display = 'none';

            let selectedValue = initialValue;
            if (initialValue === null) {
                if (pfRadio.checked) selectedValue = pfRadio.value;
                else if (pjRadio.checked) selectedValue = pjRadio.value;
                else if (vpjRadio.checked) selectedValue = vpjRadio.value;
            }

            if (selectedValue === 'pf') {
                pfDiv.style.display = 'block';
            } else if (selectedValue === 'pj') {
                pjDiv.style.display = 'block';
            } else if (selectedValue === 'vpj') {
                vpjDiv.style.display = 'block';
            }
        }

        // Event listeners para radio buttons de destino (registro)
        [perFSSalida, perJSSalida, vperJSSalida].forEach(radio => {
            radio.addEventListener('change', () => toggleDestinoFields('register'));
        });
        // Event listeners para radio buttons de destino (edición)
        [editPerFSSalida, editPerJSSalida, editVperJSSalida].forEach(radio => {
            radio.addEventListener('change', () => toggleDestinoFields('edit'));
        });


        // --- Funciones para campos condicionales (Entrada Relacionada) ---
        function toggleEntradaRelacionadaFields(formType, initialValue = null) {
            let siRadio, noRadio, entradaDiv;

            if (formType === 'register') {
                siRadio = siEntradaSalida;
                noRadio = noEntradaSalida;
                entradaDiv = entradasRelacionadasSalida;
            } else { // edit
                siRadio = editSiEntradaSalida;
                noRadio = editNoEntradaSalida;
                entradaDiv = editEntradasRelacionadasSalida;
            }

            if (initialValue === null) {
                if (siRadio.checked) {
                    entradaDiv.style.display = 'block';
                } else {
                    entradaDiv.style.display = 'none';
                }
            } else {
                if (initialValue === 'si') {
                    entradaDiv.style.display = 'block';
                    siRadio.checked = true;
                } else {
                    entradaDiv.style.display = 'none';
                    noRadio.checked = true;
                }
            }
        }

        // Event listeners para radio buttons de entrada relacionada (registro)
        [siEntradaSalida, noEntradaSalida].forEach(radio => {
            radio.addEventListener('change', () => toggleEntradaRelacionadaFields('register'));
        });
        // Event listeners para radio buttons de entrada relacionada (edición)
        [editSiEntradaSalida, editNoEntradaSalida].forEach(radio => {
            radio.addEventListener('change', () => toggleEntradaRelacionadaFields('edit'));
        });


        // --- Carga de datos en selects/checkboxes ---
        async function loadReferences(selectId, selectedValue = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Cargando referencias...</option>';
            try {
                const response = await fetch('api/obtener_referencias_salidas.php');
                const data = await response.json();
                if (data.success) {
                    select.innerHTML = '<option value="">seleccione una referencia.....</option>';
                    data.data.forEach(ref => {
                        const option = document.createElement('option');
                        option.value = ref.Id;
                        option.textContent = `${ref.Codigo} / ${ref.Nombre}`;
                        if (selectedValue && ref.Id == selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="">Error al cargar referencias</option>';
                    console.error('Error al cargar referencias:', data.message);
                }
            } catch (error) {
                select.innerHTML = '<option value="">Error de conexión</option>';
                console.error('Error de red al cargar referencias:', error);
            }
        }

        async function loadInstitutions(selectId, selectedValue = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Cargando instituciones...</option>';
            try {
                const response = await fetch('api/obtener_instituciones_salidas.php');
                const data = await response.json();
                if (data.success) {
                    select.innerHTML = '<option value="">seleccione una Institución.....</option>';
                    Object.values(data.data).forEach(inst => {
                        const option = document.createElement('option');
                        option.value = inst.codigo; // Asumiendo que Codigo es el ID de la institución
                        option.textContent = `${inst.institucionNombre} / ${inst.DepartamentoNombre}`; // Si tienes departamento en esta tabla, podrías añadirlo
                        if (selectedValue && inst.codigo == selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="">Error al cargar instituciones</option>';
                    console.error('Error al cargar instituciones:', data.message);
                }
            } catch (error) {
                select.innerHTML = '<option value="">Error de conexión</option>';
                console.error('Error de red al cargar instituciones:', error);
            }
        }

        async function loadDepartmentsForMultiple(containerId, selectedDepartments = []) {
            const container = document.getElementById(containerId);
            container.innerHTML = '<p>Cargando departamentos...</p>';
            try {
                const response = await fetch('api/obtener_departamentos_salidas.php');
                const data = await response.json();
                if (data.success) {
                    container.innerHTML = '';
                    if (data.data.length === 0) {
                        container.innerHTML = '<p>No hay departamentos disponibles.</p>';
                        return;
                    }
                    data.data.forEach(dpto => {
                        const div = document.createElement('div');
                        div.classList.add('form-group'); // O tu clase de estilo para checkboxes
                        const checkbox = document.createElement('input');
                        checkbox.type = 'checkbox';
                        // Para registro, el name es instiDepart[], para edición, editInstiDepart[]
                        checkbox.name = containerId.includes('edit') ? 'editInstiDepart[]' : 'instiDepart[]';
                        checkbox.id = `${containerId}${dpto.CodDpto}`;
                        checkbox.value = dpto.CodDpto;

                        if (selectedDepartments.includes(dpto.CodDpto.toString())) {
                            checkbox.checked = true;
                        }

                        const label = document.createElement('label');
                        label.htmlFor = checkbox.id;
                        label.textContent = `${dpto.NomInsti} / ${dpto.NomDpto}`;

                        div.appendChild(checkbox);
                        div.appendChild(label);
                        container.appendChild(div);
                    });
                } else {
                    container.innerHTML = '<p>Error al cargar departamentos</p>';
                    console.error('Error al cargar departamentos:', data.message);
                }
            } catch (error) {
                container.innerHTML = '<p>Error de conexión</p>';
                console.error('Error de red al cargar departamentos:', error);
            }
        }

        async function loadEntries(selectId, selectedValue = null) {
            const select = document.getElementById(selectId);
            select.innerHTML = '<option value="">Cargando entradas...</option>';
            try {
                const response = await fetch('api/obtener_entradas_salidas.php');
                const data = await response.json();
                if (data.success) {
                    select.innerHTML = '<option value="">seleccione una Entrada.....</option>';
                    data.data.forEach(entry => {
                        const option = document.createElement('option');
                        option.value = entry.NumRegistro;
                        option.textContent = `${entry.NumRegistro} / ${entry.TipoDoc}`;
                        if (selectedValue && entry.NumRegistro == selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                } else {
                    select.innerHTML = '<option value="">Error al cargar entradas</option>';
                    console.error('Error al cargar entradas:', data.message);
                }
            } catch (error) {
                select.innerHTML = '<option value="">Error de conexión</option>';
                console.error('Error de red al cargar entradas:', error);
            }
        }


        // --- Funciones CRUD ---

        // READ: Cargar y mostrar salidas
        async function loadSalidas() {
            const query = `api/listar_salidas.php?limit=${recordsPerPage}&page=${currentPage}&search=${searchInputSalidas.value}`;
            try {
                const response = await fetch(query);
                const result = await response.json();

                if (result.success) {
                    document.getElementById('totalSalidas').textContent = result.totalRecords;
                    document.getElementById('todaySalidas').textContent = result.todayRecords;
                    document.getElementById('monthSalidas').textContent = result.monthRecords;
                    document.getElementById('nextRegisterSalidas').textContent = result.nextRegister;

                    tableBodySalidas.innerHTML = ''; // Limpiar tabla
                    if (result.data.length > 0) {
                        noDataSalidas.style.display = 'none';
                        result.data.forEach(salida => {
                            console.log(salida.EntradaRelacionadaNum)
                            const row = tableBodySalidas.insertRow();
                            row.innerHTML = `
                            <td>${salida.NumRegistro}</td>
                            <td>${salida.FechaRegistro}</td>
                            <td>${salida.TipoDoc}</td>
                            <td>${salida.Descripcion}</td>
                            <td>${salida.PalabrasClaves}</td>
                            <td>${salida.NombreReferencia || 'N/A'}</td>
                            <td>${salida.FechaFirma || 'N/A'}</td>
                            <td>${salida.Importe || 'N/A'}</td>
                            <td>${getDestinoDisplay(salida)}</td>
                           <td>${salida.EntradaRelacionadaNum != null && salida.EntradaRelacionadaNum.toString().trim() !== ''
                                    ? salida.EntradaRelacionadaNum
                                    : 'No'
                                }</td>

                            <td>${salida.NombreArchivo ? `<a href="api/uploads/salidas/${salida.NombreArchivo}" target="_blank">Ver</a>` : 'N/A'}</td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="showEditModal(${salida.Id})">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteSalida(${salida.Id})">Eliminar</button>
                            </td>
                        `;
                        });
                    } else {
                        noDataSalidas.style.display = 'block';
                    }
                    updatePagination(result.totalRecords);
                } else {
                    alert('Error al cargar las salidas: ' + result.message);
                    console.error('Error al cargar las salidas:', result.message);
                    noDataSalidas.style.display = 'block';
                    noDataSalidas.querySelector('h3').textContent = 'Error al cargar datos';
                    noDataSalidas.querySelector('p').textContent = result.message;
                }
            } catch (error) {
                alert('Error de conexión al servidor.');
                console.error('Error de red:', error);
                noDataSalidas.style.display = 'block';
                noDataSalidas.querySelector('h3').textContent = 'Error de conexión';
                noDataSalidas.querySelector('p').textContent = 'No se pudo conectar al servidor para obtener las salidas.';
            }
        }

        function getDestinoDisplay(salida) {
            if (salida.DestinoTipo === 'pf') {
                return `Persona Física: ${salida.PersonaFisicaDestino || 'N/A'}`;
            } else if (salida.DestinoTipo === 'pj') {
                return `Institución: ${salida.InstitucionDestino || 'N/A'}`; // Mejorar esto para mostrar el nombre de la institución
            } else if (salida.DestinoTipo === 'vpj') {
                return `Múltiples: ${salida.MultiplesDestinos || 'N/A'}`;
            }
            return 'N/A';
        }


        // CREATE: Enviar nuevo formulario de salida
        registerFormSalidas.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Validar que al menos un tipo de destino esté seleccionado
            const destinoRadios = document.querySelectorAll('input[name="destinoTipo"]:checked');
            if (destinoRadios.length === 0) {
                alert('Por favor, selecciona un tipo de destino (Persona Física, Persona Jurídica o Varias Personas Jurídicas).');
                return;
            }

            // Validación específica para 'pf'
            if (perFSSalida.checked && !document.getElementById('persFisicSalida').value.trim()) {
                alert('Por favor, ingresa el nombre completo de la persona física.');
                return;
            }
            // Validación específica para 'pj'
            if (perJSSalida.checked && !document.getElementById('institucionSalida').value) {
                alert('Por favor, selecciona una institución.');
                return;
            }
            // Validación específica para 'vpj'
            if (vperJSSalida.checked && document.querySelectorAll('#checkboxesInstiDepartSalida input[type="checkbox"]:checked').length === 0) {
                alert('Por favor, selecciona al menos una Institución/Sección para el envío a varias personas jurídicas.');
                return;
            }

            // Validación para entrada relacionada
            if (siEntradaSalida.checked && !document.getElementById('selectEntradasSalida').value) {
                alert('Por favor, selecciona una entrada relacionada.');
                return;
            }

            // Validación de archivo PDF
            const archivoInput = document.getElementById('archivoSalida');
            if (archivoInput.files.length > 0) {
                const file = archivoInput.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (fileExtension !== 'pdf') {
                    alert('Solo se permiten archivos PDF.');
                    return;
                }
            }


            try {
                const response = await fetch('api/guardar_salidas.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    closeModal('registerModalSalidas');
                    loadSalidas(); // Recargar la tabla para mostrar la nueva salida
                } else {
                    alert('Error al guardar la salida: ' + result.message);
                    console.error('Error al guardar salida:', result.message);
                }
            } catch (error) {
                alert('Error de conexión al servidor al guardar la salida.');
                console.error('Error de red al guardar salida:', error);
            }
        });

        function resetRegisterForm() {
            registerFormSalidas.reset();
            // Asegurarse de que los campos condicionales estén ocultos
            pfsSalida.style.display = 'none';
            pjsSalida.style.display = 'none';
            vpjsSalida.style.display = 'none';
            entradasRelacionadasSalida.style.display = 'none';
            noEntradaSalida.checked = true; // Por defecto "No" para entrada relacionada
        }

        // UPDATE: Cargar datos en el modal de edición
        window.showEditModal = async function (id) {
            openModal('editModalSalidas');
            // Cargar datos de la salida específica
            console.log(id)
            try {
                const response = await fetch(`api/lista_salidas.php?id=${id}`); // Necesitarás crear read_single.php
                const result = await response.json();

                if (result.success && result.data) {
                    const salida = result.data;
                    document.getElementById('editIdSalida').value = salida.Id;
                    document.getElementById('editTipoDocSalida').value = salida.TipoDoc;
                    document.getElementById('editDescripcionSalida').value = salida.Descripcion;
                    document.getElementById('editPalabrasClavesSalida').value = salida.PalabrasClaves;
                    document.getElementById('editFechaFirmaSalida').value = salida.FechaFirma; // Formato YYYY-MM-DD
                    document.getElementById('editImporteSalida').value = salida.Importe;

                    // Cargar y seleccionar referencia
                    await loadReferences('editRefSalida', salida.Referencia);

                    // Mostrar nombre del archivo actual
                    const currentPdfNameSpan = document.getElementById('currentPdfNameSalida');
                    if (salida.NombreArchivo) {
                        currentPdfNameSpan.innerHTML = `<a href="api/uploads/salidas/${salida.NombreArchivo}" target="_blank">${salida.NombreArchivo}</a>`;
                    } else {
                        currentPdfNameSpan.textContent = 'Ninguno';
                    }

                    // Seleccionar radio button de destino y mostrar/ocultar campos
                    if (salida.DestinoTipo === 'pf') {
                        editPerFSSalida.checked = true;
                        document.getElementById('editPersFisicSalida').value = salida.PersonaFisicaDestino;
                    } else if (salida.DestinoTipo === 'pj') {
                        editPerJSSalida.checked = true;
                        await loadInstitutions('editInstitucionSalida', salida.InstitucionDestino);
                    } else if (salida.DestinoTipo === 'vpj') {
                        editVperJSSalida.checked = true;
                        // Necesitas una API para obtener los departamentos seleccionados para esta salida
                        // O read_single.php ya te devuelve los IDs de departamentos
                        const selectedDepartments = salida.DepartamentosMultiples ? salida.DepartamentosMultiples.split(',').map(d => d.trim()) : [];
                        await loadDepartmentsForMultiple('editCheckboxesInstiDepartSalida', selectedDepartments);
                    }
                    toggleDestinoFields('edit', salida.DestinoTipo);

                    // Seleccionar radio button de entrada relacionada y mostrar/ocultar campos
                    if (salida.EntradaRelacionada === 'si') {
                        editSiEntradaSalida.checked = true;
                        await loadEntries('editSelectEntradasSalida', salida.NumEntradaRelacionada);
                    } else {
                        editNoEntradaSalida.checked = true;
                        await loadEntries('editSelectEntradasSalida', null); // Limpiar select si no hay entrada
                    }
                    toggleEntradaRelacionadaFields('edit', salida.EntradaRelacionada);

                } else {
                    alert('Error al cargar los datos de la salida: ' + result.message);
                    closeModal('editModalSalidas');
                }
            } catch (error) {
                alert('Error de conexión al servidor al cargar datos de edición.');
                console.error('Error de red al cargar datos de edición:', error);
                closeModal('editModalSalidas');
            }
        };

        // UPDATE: Enviar formulario de edición
        editFormSalidas.addEventListener('submit', async function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            // Validar que al menos un tipo de destino esté seleccionado
            const destinoRadios = document.querySelectorAll('input[name="editDestinoTipo"]:checked');
            if (destinoRadios.length === 0) {
                alert('Por favor, selecciona un tipo de destino (Persona Física, Persona Jurídica o Varias Personas Jurídicas).');
                return;
            }

            // Validación específica para 'pf'
            if (editPerFSSalida.checked && !document.getElementById('editPersFisicSalida').value.trim()) {
                alert('Por favor, ingresa el nombre completo de la persona física.');
                return;
            }
            // Validación específica para 'pj'
            if (editPerJSSalida.checked && !document.getElementById('editInstitucionSalida').value) {
                alert('Por favor, selecciona una institución.');
                return;
            }
            // Validación específica para 'vpj'
            if (editVperJSSalida.checked && document.querySelectorAll('#editCheckboxesInstiDepartSalida input[type="checkbox"]:checked').length === 0) {
                alert('Por favor, selecciona al menos una Institución/Sección para el envío a varias personas jurídicas.');
                return;
            }

            // Validación para entrada relacionada
            if (editSiEntradaSalida.checked && !document.getElementById('editSelectEntradasSalida').value) {
                alert('Por favor, selecciona una entrada relacionada.');
                return;
            }

            // Validación de archivo PDF
            const archivoInput = document.getElementById('editArchivoSalida');
            if (archivoInput.files.length > 0) {
                const file = archivoInput.files[0];
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (fileExtension !== 'pdf') {
                    alert('Solo se permiten archivos PDF.');
                    return;
                }
            }

            try {
                const response = await fetch('api/actualizar_salidas.php', {
                    method: 'POST', // Usamos POST para manejar FormData con archivos
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    alert(result.message);
                    closeModal('editModalSalidas');
                    loadSalidas(); // Recargar la tabla
                } else {
                    alert('Error al actualizar la salida: ' + result.message);
                    console.error('Error al actualizar salida:', result.message);
                }
            } catch (error) {
                alert('Error de conexión al servidor al actualizar la salida.');
                console.error('Error de red al actualizar salida:', error);
            }
        });

        // DELETE: Eliminar salida
        window.deleteSalida = async function (id) {
            if (confirm('¿Estás seguro de que quieres eliminar esta salida? Esta acción es irreversible y eliminará el archivo PDF asociado.')) {
                try {
                    const response = await fetch('api/eliminar_salidas.php', {
                        method: 'POST', // O DELETE, si tu servidor lo soporta y lo configuras así
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded' // Necesario para enviar form data con DELETE puro
                        },
                        body: `id=${id}`
                    });
                    const result = await response.json();

                    if (result.success) {
                        alert(result.message);
                        loadSalidas(); // Recargar la tabla
                    } else {
                        alert('Error al eliminar la salida: ' + result.message);
                        console.error('Error al eliminar salida:', result.message);
                    }
                } catch (error) {
                    alert('Error de conexión al servidor al eliminar la salida.');
                    console.error('Error de red al eliminar salida:', error);
                }
            }
        };

        // --- Paginación y Búsqueda ---
        function updatePagination(totalRecords) {
            const totalPages = Math.ceil(totalRecords / recordsPerPage);
            const pageNumbersDiv = document.getElementById('pageNumbersSalidas');
            pageNumbersDiv.innerHTML = ''; // Limpiar números de página

            for (let i = 1; i <= totalPages; i++) {
                const pageBtn = document.createElement('span');
                pageBtn.textContent = i;
                pageBtn.classList.add('page-number');
                if (i === currentPage) {
                    pageBtn.classList.add('active');
                }
                pageBtn.onclick = () => {
                    currentPage = i;
                    loadSalidas();
                };
                pageNumbersDiv.appendChild(pageBtn);
            }

            document.getElementById('prevBtnSalidas').disabled = currentPage === 1;
            document.getElementById('nextBtnSalidas').disabled = currentPage === totalPages;

            const startRecord = (currentPage - 1) * recordsPerPage + 1;
            const endRecord = Math.min(currentPage * recordsPerPage, totalRecords);
            document.getElementById('paginationInfoSalidas').textContent = `Mostrando ${startRecord}-${endRecord} de ${totalRecords} salidas`;
        }

        window.changePageSalidas = function (direction) {
            if (direction === 'prev' && currentPage > 1) {
                currentPage--;
            } else if (direction === 'next' && currentPage * recordsPerPage < parseInt(document.getElementById('totalSalidas').textContent)) {
                currentPage++;
            }
            loadSalidas();
        };

        searchInputSalidas.addEventListener('keyup', function (e) {
            currentPage = 1; // Resetear a la primera página en cada búsqueda
            loadSalidas();
        });

        // Cargar salidas al iniciar la página
        loadSalidas();
    });
</script>