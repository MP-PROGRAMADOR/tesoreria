<?php
// api/referencias.php
require_once 'config.php';
setApiHeaders();

try {
    $mysqli = getDbConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            if ($id > 0) {
                $stmt = $mysqli->prepare("SELECT Id, Nombre, Codigo FROM referencias WHERE Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $referencia = $result->fetch_assoc();
                $stmt->close();
                if ($referencia)
                    sendJsonResponse(['success' => true, 'data' => $referencia]);
                else
                    sendErrorResponse('Referencia no encontrada.', 404);
            } elseif (isset($_GET['download_pdf'])) {
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generateReferenciasPdf($mysqli, $searchTerm);
            } else {
                $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT Id, Nombre, Codigo FROM referencias";
                $sql_count = "SELECT COUNT(Id) AS total FROM referencias";
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(Nombre LIKE ? OR Codigo LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'ss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY Nombre ASC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                $stmt_count = $mysqli->prepare($sql_count);
                if ($stmt_count === false)
                    sendErrorResponse('Error al preparar consulta de conteo: ' . $mysqli->error);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1]];
                    $search_params_count = [$params[0], $params[1]];
                    foreach ($search_params_count as &$p) {
                        $bind_args_count[] = &$p;
                    }
                    call_user_func_array([$stmt_count, 'bind_param'], $bind_args_count);
                }
                $stmt_count->execute();
                $total_records = $stmt_count->get_result()->fetch_assoc()['total'];
                $stmt_count->close();

                $stmt = $mysqli->prepare($sql_select);
                if ($stmt === false)
                    sendErrorResponse('Error al preparar consulta de datos: ' . $mysqli->error);
                $bind_args = [$param_types];
                foreach ($params as &$p) {
                    $bind_args[] = &$p;
                }
                call_user_func_array([$stmt, 'bind_param'], $bind_args);

                $stmt->execute();
                $result = $stmt->get_result();
                $data = [];
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
                $stmt->close();
                sendJsonResponse(['success' => true, 'data' => $data, 'total' => $total_records]);
            }
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $nombre = $input['Nombre'] ?? null;
            $codigo = $input['Codigo'] ?? null;
            if (empty($nombre) || empty($codigo))
                sendErrorResponse('Nombre y Código de referencia son obligatorios.', 400);

            $stmt = $mysqli->prepare("INSERT INTO referencias (Nombre, Codigo) VALUES (?, ?)");
            $stmt->bind_param("ss", $nombre, $codigo);
            if ($stmt->execute())
                sendJsonResponse(['success' => true, 'message' => 'Referencia creada exitosamente.', 'id' => $mysqli->insert_id]);
            else
                sendErrorResponse('Error al crear referencia: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $nombre = $input['Nombre'] ?? null;
            $codigo = $input['Codigo'] ?? null;
            if (empty($id) || empty($nombre) || empty($codigo))
                sendErrorResponse('ID, Nombre y Código de referencia son obligatorios para la actualización.', 400);

            $stmt = $mysqli->prepare("UPDATE referencias SET Nombre = ?, Codigo = ? WHERE Id = ?");
            $stmt->bind_param("ssi", $nombre, $codigo, $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Referencia actualizada exitosamente.']);
                else
                    sendErrorResponse('Referencia no encontrada o no hubo cambios.', 404);
            } else
                sendErrorResponse('Error al actualizar referencia: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (empty($id))
                sendErrorResponse('ID de referencia no especificado.', 400);

            $stmt = $mysqli->prepare("DELETE FROM referencias WHERE Id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Referencia eliminada exitosamente.']);
                else
                    sendErrorResponse('Referencia no encontrada.', 404);
            } else
                sendErrorResponse('Error al eliminar referencia: ' . $mysqli->error, 500);
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

function generateReferenciasPdf($mysqli, $searchTerm)
{
    class PDF extends FPDF
    { /* ... */
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Referencias', 0, 1, 'C');
            $this->Ln(5);
        }
        function Footer()
        { /* ... */
        }
        function ImprovedTable($header, $data)
        {
            $this->SetFillColor(44, 90, 160);
            $this->SetTextColor(255);
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');
            $w = array(30, 80, 70); // Ajusta anchos
            for ($i = 0; $i < count($header); $i++)
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();
            $this->SetFillColor(240, 248, 255);
            $this->SetTextColor(0);
            $this->SetFont('');
            $fill = false;
            foreach ($data as $row) {
                $this->Cell($w[0], 6, $row['Id'], 'LR', 0, 'C', $fill);
                $this->Cell($w[1], 6, $row['Nombre'], 'LR', 0, 'L', $fill);
                $this->Cell($w[2], 6, $row['Codigo'], 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;
            }
            $this->Cell(array_sum($w), 0, '', 'T');
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 10);
    $sql = "SELECT Id, Nombre, Codigo FROM referencias";
    $params = [];
    $param_types = '';
    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE Nombre LIKE ? OR Codigo LIKE ?";
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $param_types .= 'ss';
    }
    $sql .= " ORDER BY Nombre ASC";
    $stmt = $mysqli->prepare($sql);
    if (!empty($params)) {
        $bind_args = [$param_types];
        foreach ($params as &$p) {
            $bind_args[] = &$p;
        }
        call_user_func_array([$stmt, 'bind_param'], $bind_args);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();
    $header = array('ID', 'Nombre', 'Código');
    $pdf->ImprovedTable($header, $data);
    $pdf->Output('I', 'reporte_referencias.pdf');
    exit();
}