<style>
    /* Estilos CSS proporcionados por el usuario para las clases */
    .container-fluid {
        padding: 1rem;
    }

    .stats {
        display: flex;
        justify-content: space-around;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        padding: 1rem;
        text-align: center;
        flex-grow: 1;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #007bff;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .search-box {
        position: relative;
        flex-grow: 1;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 0.75rem 0.75rem 2.5rem;
        /* Space for icon */
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    .search-box .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        fill: #6c757d;
    }

    .btn {
        padding: 0.75rem 1.25rem;
        border-radius: 0.25rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: white;
        background-color: #007bff;
        border: 1px solid #007bff;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn .icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    .table-container {
        background-color: #fff;
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        overflow-x: auto;
        /* Para tablas responsivas */
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead th {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
        background-color: #f2f2f2;
    }

    .table tbody td {
        padding: 0.75rem;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f5f5f5;
    }

    .no-data {
        text-align: center;
        padding: 2rem;
        color: #6c757d;
    }

    .no-data svg {
        width: 60px;
        height: 60px;
        fill: #adb5bd;
        margin-bottom: 1rem;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        gap: 0.5rem;
    }

    .pagination button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        cursor: pointer;
    }

    .pagination button:disabled {
        background-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
    }

    .pagination .page-number,
    .pagination .page-info {
        padding: 0.5rem 1rem;
    }

    .pagination .icon {
        width: 20px;
        height: 20px;
        fill: currentColor;
    }

    /* Modal Styles */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1000;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        /* 5% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
        border-radius: 0.5rem;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 15px;
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.5rem;
        color: #343a40;
    }

    .modal-header .close {
        color: #aaa;
        font-size: 28px;
        font-weight: bold;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
    }

    .modal-header .close:hover,
    .modal-header .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-body .form-group {
        margin-bottom: 1rem;
    }

    .modal-body .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #495057;
    }

    .modal-body .form-group input[type="text"],
    .modal-body .form-group input[type="date"],
    .modal-body .form-group input[type="file"],
    .modal-body .form-group select,
    .modal-body .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-sizing: border-box;
        /* Ensures padding doesn't increase width */
    }

    .modal-body .radio-group {
        display: flex;
        gap: 1rem;
        margin-top: 0.5rem;
    }

    .modal-body .radio-item input[type="radio"] {
        margin-right: 0.5rem;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
        padding-top: 15px;
        border-top: 1px solid #dee2e6;
        margin-top: 15px;
    }

    /* Adjustments for the new design's form elements based on provided CSS */
    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.75rem;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        box-sizing: border-box;
        width: 100%;
        /* Ensure they fill their container */
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #495057;
    }

    .form-check-label {
        display: inline-block;
        /* To align label next to checkbox */
        margin-left: 0.5rem;
    }

    /* Styles for CKEditor if you're using it, to match the form-control look */
    .ckeditor-container {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.5rem;
    }
</style>


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
            <div class="stat-number" id="totalDecretos">0</div>
            <div class="stat-label">Total Decretos</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="todayDecretos">0</div>
            <div class="stat-label">Hoy</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="monthDecretos">0</div>
            <div class="stat-label">Este Mes</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" id="nextRegisterDecretos">N/A</div>
            <div class="stat-label">Próximo Decreto</div>
        </div>
    </div>

    <div class="controls">
        <div class="search-box">
            <input type="text" id="decretoSearchInput"
                placeholder="Buscar por descripción, entrada, persona o miembro...">
            <svg class="search-icon" viewBox="0 0 24 24">
                <path
                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
            </svg>
        </div>
        <button class="btn btn-primary" onclick="openModal('registerDecretoModal')">
            <svg class="icon" viewBox="0 0 24 24">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
            </svg>
            Nuevo Decreto
        </button>
    </div>

    <div class="table-container pb-3">
        <table class="table" id="decretosTable">
            <thead>
                <tr>
                    <th>ID Decreto</th>
                    <th>Fecha</th>
                    <th>Descripción</th>
                    <th>Documento de Entrada</th>
                    <th>Destino</th>
                    <th>Archivo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="decretosTableBody">
            </tbody>
        </table>
        <div id="noDecretosData" class="no-data" style="display: none;">
            <svg viewBox="0 0 24 24">
                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
            </svg>
            <h3>No hay datos disponibles</h3>
            <p>No se encontraron decretos que coincidan con tu búsqueda</p>
        </div>
        <div class="pagination">
            <button onclick="changeDecretoPage('prev')" id="prevDecretoBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M15.41 7.41L14 6l-6 6 6 6 1.41-1.41L10.83 12z" />
                </svg>
            </button>
            <div id="decretoPageNumbers"></div>
            <button onclick="changeDecretoPage('next')" id="nextDecretoBtn">
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M10 6L8.59 7.41 13.17 12l-4.58 4.59L10 18l6-6z" />
                </svg>
            </button>
            <div class="pagination-info" id="decretoPaginationInfo"></div>
        </div>
    </div>
</div>

<div id="registerDecretoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Nuevo Decreto</h2>
            <button class="close" onclick="closeModal('registerDecretoModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="registerDecretoForm" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="decretoDescripcion">Descripción del Decreto</label>
                    <textarea id="decretoDescripcion" name="descripcion" class="ckeditor"
                        placeholder="Descripción del documento"></textarea>
                </div>

                <div class="form-group">
                    <label>Decreto para:</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="decretoPersonaFisica" name="procede" value="pf" checked>
                            <label for="decretoPersonaFisica">Una Persona Física</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="decretoMiembros" name="procede" value="pj">
                            <label for="decretoMiembros">Miembros</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="decretoMiembrosPF" name="procede" value="vpj">
                            <label for="decretoMiembrosPF">Miembros y una Persona Física</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="decretoCampoPersonaFisica">
                    <label for="decretoNombrePersona">Nombre Completo de la Persona</label>
                    <input type="text" id="decretoNombrePersona" name="persFisic"
                        placeholder="Ingrese el nombre completo de la persona">
                </div>

                <div class="form-group" id="decretoCampoMiembros" style="display: none;">
                    <label>Selecciona Miembros</label>
                    <div id="decretoMiembrosCheckboxes">
                    </div>
                </div>

                <div class="form-group">
                    <label for="decretoArchivo">Selecciona el Documento (PDF)</label>
                    <input type="file" id="decretoArchivo" name="archivo" accept=".pdf">
                </div>
                <div class="form-group">
                    <label for="decretoEntradaDoc">Entrada Relacionada (Opcional)</label>
                    <select id="decretoEntradaDoc" name="entradaDoc">
                        <option value="">Seleccione el número de registro del documento de entrada...</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary"
                onclick="closeModal('registerDecretoModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="saveNewDecreto()">Guardar</button>
        </div>
    </div>
</div>

<div id="editDecretoModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Editar Decreto</h2>
            <button class="close" onclick="closeModal('editDecretoModal')">&times;</button>
        </div>
        <div class="modal-body">
            <form id="editDecretoForm" enctype="multipart/form-data">
                <input type="hidden" id="editDecretoId" name="id">
                <div class="form-group">
                    <label for="editDecretoDescripcion">Descripción del Decreto</label>
                    <textarea id="editDecretoDescripcion" name="descripcion" class="ckeditor"></textarea>
                </div>

                <div class="form-group">
                    <label>Decreto para:</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input type="radio" id="editDecretoPersonaFisica" name="procede" value="pf">
                            <label for="editDecretoPersonaFisica">Una Persona Física</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="editDecretoMiembros" name="procede" value="pj">
                            <label for="editDecretoMiembros">Miembros</label>
                        </div>
                        <div class="radio-item">
                            <input type="radio" id="editDecretoMiembrosPF" name="procede" value="vpj">
                            <label for="editDecretoMiembrosPF">Miembros y una Persona Física</label>
                        </div>
                    </div>
                </div>

                <div class="form-group" id="editDecretoCampoPersonaFisica">
                    <label for="editDecretoNombrePersona">Nombre Completo de la Persona</label>
                    <input type="text" id="editDecretoNombrePersona" name="persFisic"
                        placeholder="Ingrese el nombre completo de la persona">
                </div>

                <div class="form-group" id="editDecretoCampoMiembros" style="display: none;">
                    <label>Selecciona Miembros</label>
                    <div id="editDecretoMiembrosCheckboxes">
                    </div>
                </div>

                <div class="form-group">
                    <label for="editDecretoArchivo">Archivo PDF</label>
                    <span id="currentDecretoArchivoName" style="margin-left: 10px;"></span>
                    <input type="file" id="editDecretoArchivo" name="archivo" accept=".pdf">
                    <small>Deja en blanco para mantener el archivo actual. Selecciona uno nuevo para
                        reemplazarlo.</small>
                    <div class="form-check" style="margin-top: 10px;">
                        <input type="checkbox" id="removeCurrentDecretoFile" name="remove_current_file" value="true">
                        <label for="removeCurrentDecretoFile" class="form-check-label">Eliminar archivo actual</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="editDecretoEntradaDoc">Entrada Relacionada (Opcional)</label>
                    <select id="editDecretoEntradaDoc" name="entradaDoc">
                        <option value="">Seleccione el número de registro del documento de entrada...</option>
                    </select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal('editDecretoModal')">Cancelar</button>
            <button type="button" class="btn btn-primary" onclick="updateDecreto()">Actualizar</button>
        </div>
    </div>
</div>

<script>
    // Variables globales para la paginación y búsqueda
    let currentDecretoPage = 1;
    const decretosPerPage = 10; // Fijo para este ejemplo, podrías hacerlo dinámico con un select
    let currentDecretoSearch = '';

    // Referencias a elementos del DOM
    const decretosTableBody = document.getElementById('decretosTableBody');
    const noDecretosData = document.getElementById('noDecretosData');
    const totalDecretosSpan = document.getElementById('totalDecretos');
    const todayDecretosSpan = document.getElementById('todayDecretos');
    const monthDecretosSpan = document.getElementById('monthDecretos');
    const decretoSearchInput = document.getElementById('decretoSearchInput');
    const decretoPageNumbersDiv = document.getElementById('decretoPageNumbers');
    const prevDecretoBtn = document.getElementById('prevDecretoBtn');
    const nextDecretoBtn = document.getElementById('nextDecretoBtn');
    const decretoPaginationInfo = document.getElementById('decretoPaginationInfo');

    // Referencias para el modal de registro (Crear)
    const registerDecretoModal = document.getElementById('registerDecretoModal');
    const registerDecretoForm = document.getElementById('registerDecretoForm');
    const decretoDescripcionInput = document.getElementById('decretoDescripcion');
    const decretoPersonaFisicaRadio = document.getElementById('decretoPersonaFisica');
    const decretoMiembrosRadio = document.getElementById('decretoMiembros');
    const decretoMiembrosPFRadio = document.getElementById('decretoMiembrosPF');
    const decretoCampoPersonaFisica = document.getElementById('decretoCampoPersonaFisica');
    const decretoCampoMiembros = document.getElementById('decretoCampoMiembros');
    const decretoMiembrosCheckboxesDiv = document.getElementById('decretoMiembrosCheckboxes');
    const decretoEntradaDocSelect = document.getElementById('decretoEntradaDoc');


    // Referencias para el modal de edición (Actualizar)
    const editDecretoModal = document.getElementById('editDecretoModal');
    const editDecretoForm = document.getElementById('editDecretoForm');
    const editDecretoIdInput = document.getElementById('editDecretoId');
    const editDecretoDescripcionInput = document.getElementById('editDecretoDescripcion');
    const editDecretoPersonaFisicaRadio = document.getElementById('editDecretoPersonaFisica');
    const editDecretoMiembrosRadio = document.getElementById('editDecretoMiembros');
    const editDecretoMiembrosPFRadio = document.getElementById('editDecretoMiembrosPF');
    const editDecretoCampoPersonaFisica = document.getElementById('editDecretoCampoPersonaFisica');
    const editDecretoCampoMiembros = document.getElementById('editDecretoCampoMiembros');
    const editDecretoMiembrosCheckboxesDiv = document.getElementById('editDecretoMiembrosCheckboxes');
    const editDecretoEntradaDocSelect = document.getElementById('editDecretoEntradaDoc');
    const currentDecretoArchivoNameSpan = document.getElementById('currentDecretoArchivoName');
    const removeCurrentDecretoFileCheckbox = document.getElementById('removeCurrentDecretoFile');


    // CKEditor Instances
    let registerCKEditor;
    let editCKEditor;

    // --- Funciones de Utilidad ---

    // Función para abrir y cerrar modales (simple, sin Bootstrap JS)
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        // Limpiar formularios al cerrar
        if (modalId === 'registerDecretoModal') {
            registerDecretoForm.reset();
            if (registerCKEditor) registerCKEditor.setData('');
            toggleDecretoDestinoFields('pf'); // Resetear a Persona Física por defecto
            document.getElementById('decretoCampoMiembros').style.display = 'none'; // Asegurar que Miembros esté oculto
        } else if (modalId === 'editDecretoModal') {
            editDecretoForm.reset();
            if (editCKEditor) editCKEditor.setData('');
            toggleEditDecretoDestinoFields('pf'); // Resetear a Persona Física por defecto
            document.getElementById('editDecretoCampoMiembros').style.display = 'none'; // Asegurar que Miembros esté oculto
            currentDecretoArchivoNameSpan.textContent = ''; // Limpiar nombre de archivo actual
            removeCurrentDecretoFileCheckbox.checked = false; // Desmarcar checkbox de eliminación
        }
    }

    // Inicializar CKEditor para el formulario de registro
    function initializeRegisterCKEditor() {
        if (typeof CKEDITOR !== 'undefined' && !CKEDITOR.instances.decretoDescripcion) {
            registerCKEditor = CKEDITOR.replace('decretoDescripcion');
        }
    }

    // Inicializar CKEditor para el formulario de edición
    function initializeEditCKEditor() {
        if (typeof CKEDITOR !== 'undefined' && !CKEDITOR.instances.editDecretoDescripcion) {
            editCKEditor = CKEDITOR.replace('editDecretoDescripcion');
        }
    }


    // Función para alternar la visibilidad de los campos de destino
    function toggleDecretoDestinoFields(procedeValue) {
        decretoCampoPersonaFisica.style.display = 'none';
        decretoCampoMiembros.style.display = 'none';

        if (procedeValue === 'pf') {
            decretoCampoPersonaFisica.style.display = 'block';
        } else if (procedeValue === 'pj') {
            decretoCampoMiembros.style.display = 'block';
        } else if (procedeValue === 'vpj') {
            decretoCampoPersonaFisica.style.display = 'block';
            decretoCampoMiembros.style.display = 'block';
        }
    }

    // Función para alternar la visibilidad de los campos de destino en edición
    function toggleEditDecretoDestinoFields(procedeValue) {
        editDecretoCampoPersonaFisica.style.display = 'none';
        editDecretoCampoMiembros.style.display = 'none';

        if (procedeValue === 'pf') {
            editDecretoCampoPersonaFisica.style.display = 'block';
        } else if (procedeValue === 'pj') {
            editDecretoCampoMiembros.style.display = 'block';
        } else if (procedeValue === 'vpj') {
            editDecretoCampoPersonaFisica.style.display = 'block';
            editDecretoCampoMiembros.style.display = 'block';
        }
    }


    // --- Carga de Datos (Miembros y Entradas) ---

    // Cargar miembros para checkboxes (tanto en crear como en editar)
    async function loadMiembros(targetDiv) {
        try {
            const response = await fetch('api/obtener_miembros_decretos.php');
            const result = await response.json();
            if (result.success) {
                targetDiv.innerHTML = ''; // Limpiar existentes
                result.data.forEach(miembro => {
                    const div = document.createElement('div');
                    div.className = 'checkbox-item'; // Mantener consistencia con los estilos existentes si aplica
                    div.innerHTML = `
                        <input type="checkbox" id="miembro-${miembro.Id}-${targetDiv.id}" name="miembro[]" value="${miembro.Id}">
                        <label for="miembro-${miembro.Id}-${targetDiv.id}">${miembro.Nombre}</label>
                    `;
                    targetDiv.appendChild(div);
                });
            } else {
                console.error('Error al cargar miembros:', result.message);
            }
        } catch (error) {
            console.error('Error de red al cargar miembros:', error);
        }
    }

    // Cargar entradas para selects (tanto en crear como en editar)
    async function loadEntradas(targetSelect) {
        try {
            const response = await fetch('api/obtener_entradas_decretos.php');
            const result = await response.json();
            if (result.success) {
                targetSelect.innerHTML = '<option value="">Seleccione el número de registro del documento de entrada...</option>';
                result.data.forEach(entrada => {
                    const option = document.createElement('option');
                    option.value = entrada.Id; // Usar el ID para la FK
                    option.textContent = `${entrada.NumRegistro} / ${entrada.TipoDoc}`;
                    targetSelect.appendChild(option);
                });
            } else {
                console.error('Error al cargar entradas:', result.message);
            }
        } catch (error) {
            console.error('Error de red al cargar entradas:', error);
        }
    }

    // --- Funciones CRUD ---

    // Fetch Decretos
    async function fetchDecretos() {
        const url = `api/listar_decretos.php?page=${currentDecretoPage}&limit=${decretosPerPage}&search=${encodeURIComponent(currentDecretoSearch)}`;
        try {
            const response = await fetch(url);
            const result = await response.json();

            if (result.success) {
                totalDecretosSpan.textContent = result.totalRecords; 
                todayDecretosSpan.textContent = result.todayRecords;
                monthDecretosSpan.textContent = result.monthRecords;
                document.getElementById('nextRegisterDecretos').textContent = result.nextRegister;

                decretosTableBody.innerHTML = ''; // Limpiar filas existentes
                if (result.data.length > 0) {
                    noDecretosData.style.display = 'none';
                    result.data.forEach(decreto => {
                        const row = document.createElement('tr');
                        let destinoDisplay = '';
                        if (decreto.DestinoTipo === 'pf') {
                            destinoDisplay = `Persona Física: ${decreto.PersonaFisicaDestino || 'N/A'}`;
                        } else if (decreto.DestinoTipo === 'pj') {
                            destinoDisplay = `Miembros: ${decreto.MiembrosDestino || 'N/A'}`;
                        } else if (decreto.DestinoTipo === 'vpj') {
                            destinoDisplay = `Persona Física: ${decreto.PersonaFisicaDestino || 'N/A'}<br>Miembros: ${decreto.MiembrosDestino || 'N/A'}`;
                        } else {
                            destinoDisplay = 'No definido';
                        }

                        const fileLink = decreto.NombreArchivo ?
                            `<a href="api/uploads/decretos/${decreto.NombreArchivo}" target="_blank" class="btn btn-info btn-sm">
                                <svg class="icon" viewBox="0 0 24 24"><path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" /></svg>
                                Ver PDF
                             </a>` : 'No archivo';

                        row.innerHTML = `
                            <td>${decreto.Id}</td>
                            <td>${decreto.Fecha}</td>
                            <td>${decreto.Descripcion.substring(0, 100)}${decreto.Descripcion.length > 100 ? '...' : ''}</td>
                            <td>${decreto.EntradaNumRegistro ? `${decreto.EntradaNumRegistro} / ${decreto.EntradaTipoDoc}` : 'N/A'}</td>
                            <td>${destinoDisplay}</td>
                            <td>${fileLink}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-decreto-btn" data-id="${decreto.Id}">
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" /></svg>
                                    Editar
                                </button>
                                <button class="btn btn-danger btn-sm delete-decreto-btn" data-id="${decreto.Id}">
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" /></svg>
                                    Eliminar
                                </button>
                            </td>
                        `;
                        decretosTableBody.appendChild(row);
                    });
                    attachDecretoEventListeners();
                    renderDecretoPagination(result.totalRecords);
                } else {
                    noDecretosData.style.display = 'block';
                    decretoPageNumbersDiv.innerHTML = '';
                    decretoPaginationInfo.textContent = '';
                    prevDecretoBtn.disabled = true;
                    nextDecretoBtn.disabled = true;
                }
            } else {
                alert('Error al cargar decretos: ' + result.message);
                console.error('Error response:', result.message);
                decretosTableBody.innerHTML = '<tr><td colspan="7" class="text-center">Error al cargar datos.</td></tr>';
                noDecretosData.style.display = 'block';
            }
        } catch (error) {
            alert('Error de red al cargar decretos: ' + error.message);
            console.error('Network error:', error);
            decretosTableBody.innerHTML = '<tr><td colspan="7" class="text-center">Error de conexión.</td></tr>';
            noDecretosData.style.display = 'block';
        }
    }

    // Renderizar controles de paginación
    function renderDecretoPagination(totalRecords) {
        const totalPages = Math.ceil(totalRecords / decretosPerPage);
        decretoPageNumbersDiv.innerHTML = '';
        if (totalPages > 1) {
            for (let i = 1; i <= totalPages; i++) {
                const pageSpan = document.createElement('span');
                pageSpan.className = `page-number ${i === currentDecretoPage ? 'active' : ''}`;
                pageSpan.textContent = i;
                pageSpan.onclick = () => {
                    currentDecretoPage = i;
                    fetchDecretos();
                };
                decretoPageNumbersDiv.appendChild(pageSpan);
            }
            prevDecretoBtn.disabled = currentDecretoPage === 1;
            nextDecretoBtn.disabled = currentDecretoPage === totalPages;
        } else {
            prevDecretoBtn.disabled = true;
            nextDecretoBtn.disabled = true;
        }
        const start = (currentDecretoPage - 1) * decretosPerPage + 1;
        const end = Math.min(currentDecretoPage * decretosPerPage, totalRecords);
        decretoPaginationInfo.textContent = `Mostrando ${start}-${end} de ${totalRecords} decretos`;
    }

    // Cambiar de página
    function changeDecretoPage(direction) {
        if (direction === 'prev' && currentDecretoPage > 1) {
            currentDecretoPage--;
        } else if (direction === 'next' && currentDecretoPage < Math.ceil(parseInt(totalDecretosSpan.textContent) / decretosPerPage)) {
            currentDecretoPage++;
        }
        fetchDecretos();
    }

    // Guardar nuevo decreto
    async function saveNewDecreto() {
        const formData = new FormData(registerDecretoForm);

        // Obtener datos de CKEditor
        if (registerCKEditor) {
            formData.set('descripcion', registerCKEditor.getData());
        }

        try {
            const response = await fetch('api/guardar_decretos.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                closeModal('registerDecretoModal');
                fetchDecretos(); // Recargar la tabla
            } else {
                alert('Error al guardar decreto: ' + result.message);
            }
        } catch (error) {
            alert('Error de red al guardar decreto: ' + error.message);
            console.error(error);
        }
    }

    // Cargar datos de decreto para edición
    async function loadDecretoForEdit(id) {
        // Cargar miembros y entradas antes de cargar los datos del decreto
        await loadMiembros(editDecretoMiembrosCheckboxesDiv);
        await loadEntradas(editDecretoEntradaDocSelect);

        try {
            const response = await fetch(`api/detalles_decretos.php?id=${id}`);
            const result = await response.json();

            if (result.success && result.data) {
                const decreto = result.data;
                editDecretoIdInput.value = decreto.Id;

                // Set CKEditor content
                if (editCKEditor) {
                    editCKEditor.setData(decreto.Descripcion || '');
                } else {
                    editDecretoDescripcionInput.value = decreto.Descripcion || '';
                }

                // Seleccionar el tipo de destino
                const procedeRadio = document.getElementById(`editDecreto${decreto.DestinoTipo.charAt(0).toUpperCase() + decreto.DestinoTipo.slice(1)}`);
                if (procedeRadio) {
                    procedeRadio.checked = true;
                    toggleEditDecretoDestinoFields(decreto.DestinoTipo);
                } else { // Fallback if type not explicitly found (e.g., 'none')
                    editDecretoPersonaFisicaRadio.checked = true; // Default to Persona Fisica
                    toggleEditDecretoDestinoFields('pf');
                }


                document.getElementById('editDecretoNombrePersona').value = decreto.PersonaFisicaDestino || '';

                // Marcar miembros seleccionados
                document.querySelectorAll('#editDecretoMiembrosCheckboxes input[type="checkbox"]').forEach(checkbox => {
                    checkbox.checked = false; // Desmarcar todos primero
                });
                if (decreto.MiembrosDestinoIds && Array.isArray(decreto.MiembrosDestinoIds)) {
                    decreto.MiembrosDestinoIds.forEach(miembroId => {
                        const checkbox = document.getElementById(`edit-miembro-${miembroId}-${editDecretoMiembrosCheckboxesDiv.id}`);
                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    });
                }

                editDecretoEntradaDocSelect.value = decreto.DocEntrada || '';

                // Mostrar nombre del archivo actual
                if (decreto.NombreArchivo) {
                    currentDecretoArchivoNameSpan.textContent = `(${decreto.NombreArchivo})`;
                    currentDecretoArchivoNameSpan.style.display = 'inline';
                } else {
                    currentDecretoArchivoNameSpan.textContent = '';
                    currentDecretoArchivoNameSpan.style.display = 'none';
                }
                removeCurrentDecretoFileCheckbox.checked = false; // Asegurarse de que esté desmarcado inicialmente

                openModal('editDecretoModal');

            } else {
                alert('Error al cargar datos del decreto para edición: ' + result.message);
                console.error('Error response:', result.message);
            }
        } catch (error) {
            alert('Error de red al cargar datos del decreto: ' + error.message);
            console.error('Network error:', error);
        }
    }

    // Actualizar decreto
    async function updateDecreto() {
        const formData = new FormData(editDecretoForm);

        // Obtener datos de CKEditor
        if (editCKEditor) {
            formData.set('descripcion', editCKEditor.getData());
        }

        // Si el checkbox de eliminar archivo está marcado, añadirlo al formData
        if (removeCurrentDecretoFileCheckbox.checked) {
            formData.append('remove_current_file', 'true');
        }

        try {
            const response = await fetch('api/actualizar_decretos.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                closeModal('editDecretoModal');
                fetchDecretos(); // Recargar la tabla
            } else {
                alert('Error al actualizar decreto: ' + result.message);
            }
        } catch (error) {
            alert('Error de red al actualizar decreto: ' + error.message);
            console.error(error);
        }
    }

    // Eliminar decreto
    async function deleteDecreto(id) {
        if (!confirm('¿Estás seguro de que quieres eliminar este decreto?')) {
            return;
        }

        const formData = new FormData();
        formData.append('id', id);

        try {
            const response = await fetch('api/eliminar_decretos.php', {
                method: 'POST', // Usamos POST para mayor compatibilidad con algunos servidores
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert(result.message);
                fetchDecretos(); // Recargar la tabla
            } else {
                alert('Error al eliminar decreto: ' + result.message);
            }
        } catch (error) {
            alert('Error de red al eliminar decreto: ' + error.message);
            console.error(error);
        }
    }

    // --- Event Listeners ---

    // Event listeners para los radio buttons de "Procede de" en el modal de registro
    decretoPersonaFisicaRadio.addEventListener('change', () => toggleDecretoDestinoFields('pf'));
    decretoMiembrosRadio.addEventListener('change', () => toggleDecretoDestinoFields('pj'));
    decretoMiembrosPFRadio.addEventListener('change', () => toggleDecretoDestinoFields('vpj'));

    // Event listeners para los radio buttons de "Procede de" en el modal de edición
    editDecretoPersonaFisicaRadio.addEventListener('change', () => toggleEditDecretoDestinoFields('pf'));
    editDecretoMiembrosRadio.addEventListener('change', () => toggleEditDecretoDestinoFields('pj'));
    editDecretoMiembrosPFRadio.addEventListener('change', () => toggleEditDecretoDestinoFields('vpj'));


    // Delegación de eventos para botones de Editar y Eliminar en la tabla
    function attachDecretoEventListeners() {
        document.querySelectorAll('.edit-decreto-btn').forEach(button => {
            button.onclick = () => loadDecretoForEdit(button.dataset.id);
        });
        document.querySelectorAll('.delete-decreto-btn').forEach(button => {
            button.onclick = () => deleteDecreto(button.dataset.id);
        });
    }

    // Manejo de la búsqueda
    let searchDecretoTimeout;
    decretoSearchInput.addEventListener('keyup', () => {
        clearTimeout(searchDecretoTimeout);
        searchDecretoTimeout = setTimeout(() => {
            currentDecretoSearch = decretoSearchInput.value;
            currentDecretoPage = 1; // Reiniciar paginación al buscar
            fetchDecretos();
        }, 300); // Debounce de 300ms
    });

    // Carga inicial de datos al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        initializeRegisterCKEditor(); // Inicializar CKEditor para el formulario de registro
        initializeEditCKEditor(); // Inicializar CKEditor para el formulario de edición

        fetchDecretos();
        loadMiembros(decretoMiembrosCheckboxesDiv); // Cargar miembros para el formulario de registro
        loadEntradas(decretoEntradaDocSelect); // Cargar entradas para el formulario de registro

        // Asegurar que el campo de persona física esté visible por defecto al cargar
        toggleDecretoDestinoFields('pf');
        toggleEditDecretoDestinoFields('pf'); // También para el de edición al inicio
    });
</script>