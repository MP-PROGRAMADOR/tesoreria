<?php
// api/decretos.php
require_once 'config.php'; // Incluye la configuración global y funciones de utilidad

setApiHeaders(); // Establece las cabeceras HTTP para CORS y JSON

try {
    $mysqli = getDbConnection(); // Obtiene la conexión a la base de datos

    $method = $_SERVER['REQUEST_METHOD']; // Obtiene el método de la solicitud HTTP

    switch ($method) {
        case 'GET':
            // Operación READ (Lectura de datos con paginación y búsqueda)
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                // Obtener un solo registro por ID
                $stmt = $mysqli->prepare("SELECT Id, Descripcion, Fecha, Archivo, DocEntrada FROM decretos WHERE Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $decreto = $result->fetch_assoc();
                $stmt->close();
                if ($decreto) {
                    sendJsonResponse(['success' => true, 'data' => $decreto]);
                } else {
                    sendErrorResponse('Decreto no encontrado.', 404);
                }
            } elseif (isset($_GET['download_pdf'])) {
                // Generar PDF
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generateDecretosPdf($mysqli, $searchTerm); // Llama a la función de generación de PDF
            } else {
                // Obtener todos los registros con paginación y búsqueda
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT Id, Descripcion, Fecha, Archivo, DocEntrada FROM decretos";
                $sql_count = "SELECT COUNT(Id) AS total FROM decretos";
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(Descripcion LIKE ? OR Archivo LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'ss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY Fecha DESC, Id DESC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                // Obtener total de registros
                $stmt_count = $mysqli->prepare($sql_count);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1]]; // 'ss' para Descripcion y Archivo
                    $search_params_count = [$params[0], $params[1]];
                    foreach ($search_params_count as &$p) { $bind_args_count[] = &$p; }
                    call_user_func_array([$stmt_count, 'bind_param'], $bind_args_count);
                }
                $stmt_count->execute();
                $result_count = $stmt_count->get_result();
                $total_records = $result_count->fetch_assoc()['total'];
                $stmt_count->close();

                // Obtener datos
                $stmt = $mysqli->prepare($sql_select);
                $bind_args = [$param_types];
                foreach ($params as &$p) { $bind_args[] = &$p; }
                call_user_func_array([$stmt, 'bind_param'], $bind_args);
                
                $stmt->execute();
                $result = $stmt->get_result();
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $row['Fecha'] = $row['Fecha'] ? date('d/m/Y', strtotime($row['Fecha'])) : '';
                    $data[] = $row;
                }
                $stmt->close();

                sendJsonResponse(['success' => true, 'data' => $data, 'total' => $total_records]);
            }
            break;

        case 'POST':
            // Operación CREATE (Crear nuevo registro)
            $input = json_decode(file_get_contents('php://input'), true);
            $descripcion = $input['Descripcion'] ?? null;
            $fecha = $input['Fecha'] ?? null; // Formato YYYY-MM-DD
            $archivo = $input['Archivo'] ?? null;
            $docEntrada = $input['DocEntrada'] ?? null;

            if (empty($descripcion) || empty($fecha)) {
                sendErrorResponse('Descripción y Fecha son campos obligatorios.', 400);
            }

            $stmt = $mysqli->prepare("INSERT INTO decretos (Descripcion, Fecha, Archivo, DocEntrada) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $descripcion, $fecha, $archivo, $docEntrada);

            if ($stmt->execute()) {
                sendJsonResponse(['success' => true, 'message' => 'Decreto creado exitosamente.', 'id' => $mysqli->insert_id]);
            } else {
                sendErrorResponse('Error al crear decreto: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'PUT':
            // Operación UPDATE (Actualizar registro existente)
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $descripcion = $input['Descripcion'] ?? null;
            $fecha = $input['Fecha'] ?? null;
            $archivo = $input['Archivo'] ?? null;
            $docEntrada = $input['DocEntrada'] ?? null;

            if (empty($id) || empty($descripcion) || empty($fecha)) {
                sendErrorResponse('ID, Descripción y Fecha son campos obligatorios para la actualización.', 400);
            }

            $stmt = $mysqli->prepare("UPDATE decretos SET Descripcion = ?, Fecha = ?, Archivo = ?, DocEntrada = ? WHERE Id = ?");
            $stmt->bind_param("sssii", $descripcion, $fecha, $archivo, $docEntrada, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Decreto actualizado exitosamente.']);
                } else {
                    sendErrorResponse('Decreto no encontrado o no hubo cambios.', 404);
                }
            } else {
                sendErrorResponse('Error al actualizar decreto: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'DELETE':
            // Operación DELETE (Eliminar registro)
            $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

            if (empty($id)) {
                sendErrorResponse('ID de decreto no especificado.', 400);
            }

            $stmt = $mysqli->prepare("DELETE FROM decretos WHERE Id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Decreto eliminado exitosamente.']);
                } else {
                    sendErrorResponse('Decreto no encontrado.', 404);
                }
            } else {
                sendErrorResponse('Error al eliminar decreto: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        default:
            sendErrorResponse('Método HTTP no soportado.', 405);
            break;
    }

} catch (Exception $e) {
    sendErrorResponse($e->getMessage());
} finally {
    if (isset($mysqli) && $mysqli) {
        $mysqli->close();
    }
}

/**
 * Genera un PDF con los datos de decretos filtrados por término de búsqueda.
 * @param mysqli $mysqli La conexión a la base de datos.
 * @param string $searchTerm El término de búsqueda para filtrar los decretos.
 */
function generateDecretosPdf($mysqli, $searchTerm) {
    class PDF extends FPDF {
        // Cabecera de página
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Decretos', 0, 1, 'C');
            $this->Ln(5);
        }

        // Pie de página
        function Footer() {
            $this->SetY(-15);
            $this->SetFont('Arial', 'I', 8);
            $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        }

        // Tabla mejorada
        function ImprovedTable($header, $data) {
            // Colores, ancho de línea y fuente en negrita
            $this->SetFillColor(44, 90, 160); // var(--primary-color) #2c5aa0
            $this->SetTextColor(255);
            $this->SetDrawColor(0, 0, 0); // Negro para bordes
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');

            // Anchos de columnas
            $w = array(15, 80, 30, 30, 35); // Ajusta estos anchos según tus columnas
            
            // Cabecera
            for($i=0; $i<count($header); $i++)
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();

            // Restauración de colores y fuente
            $this->SetFillColor(240, 248, 255); // Color de fondo para filas impares
            $this->SetTextColor(0);
            $this->SetFont('');

            // Datos
            $fill = false;
            foreach($data as $row) {
                // Controlar el salto de línea para Descripcion si es muy larga
                $descripcionCellHeight = 7;
                $descripcionLines = $this->MultiCell($w[1], 5, $row['Descripcion'], 0, 'L', false, false); // Calcula líneas
                if ($descripcionLines > 1) {
                    $descripcionCellHeight = $descripcionLines * 5; // Altura por línea y espacio
                }

                $this->Cell($w[0], $descripcionCellHeight, $row['Id'], 'LR', 0, 'C', $fill);
                
                // Guardar posición antes de MultiCell
                $x = $this->GetX();
                $y = $this->GetY();
                $this->MultiCell($w[1], 5, $row['Descripcion'], 'LR', 'L', $fill);
                // Volver a la posición de la columna siguiente después de MultiCell
                $this->SetXY($x + $w[1], $y);

                $this->Cell($w[2], $descripcionCellHeight, $row['Fecha'], 'LR', 0, 'C', $fill);
                $this->Cell($w[3], $descripcionCellHeight, $row['Archivo'], 'LR', 0, 'L', $fill);
                $this->Cell($w[4], $descripcionCellHeight, $row['DocEntrada'], 'LR', 0, 'C', $fill);
                $this->Ln($descripcionCellHeight);
                $fill = !$fill;
            }
            // Línea de cierre
            $this->Cell(array_sum($w), 0, '', 'T');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);

    // Consulta para obtener los datos
    $sql = "SELECT Id, Descripcion, Fecha, Archivo, DocEntrada FROM decretos";
    $params = [];
    $param_types = '';

    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE Descripcion LIKE ? OR Archivo LIKE ?";
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $param_types .= 'ss';
    }
    $sql .= " ORDER BY Fecha DESC, Id DESC";

    $stmt = $mysqli->prepare($sql);
    if (!empty($params)) {
        $bind_args = [$param_types];
        foreach ($params as &$p) { $bind_args[] = &$p; }
        call_user_func_array([$stmt, 'bind_param'], $bind_args);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $row['Fecha'] = $row['Fecha'] ? date('d/m/Y', strtotime($row['Fecha'])) : '';
        $data[] = $row;
    }
    $stmt->close();

    $header = array('ID', 'Descripción', 'Fecha', 'Archivo', 'Doc. Entrada');
    $pdf->ImprovedTable($header, $data);
    
    // Salida del PDF directamente al navegador
    $pdf->Output('I', 'reporte_decretos.pdf');
    exit();
}
