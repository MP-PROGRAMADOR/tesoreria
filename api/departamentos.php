<?php
// api/departamentos.php
require_once 'config.php';
setApiHeaders();

try {
    $mysqli = getDbConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            if ($id > 0) {
                $stmt = $mysqli->prepare("SELECT d.Id, d.Nombre, d.Telefono, d.Email, i.Nombre AS NombreInstitucion
                                         FROM departementos d
                                         LEFT JOIN instituciones i ON d.Institucion = i.Id
                                         WHERE d.Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $departamento = $result->fetch_assoc();
                $stmt->close();
                if ($departamento)
                    sendJsonResponse(['success' => true, 'data' => $departamento]);
                else
                    sendErrorResponse('Departamento no encontrado.', 404);
            } elseif (isset($_GET['download_pdf'])) {
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generateDepartamentosPdf($mysqli, $searchTerm);
            } else {
                $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT d.Id, d.Nombre, d.Telefono, d.Email, i.Nombre AS NombreInstitucion
                               FROM departementos d
                               LEFT JOIN instituciones i ON d.Institucion = i.Id";
                $sql_count = "SELECT COUNT(d.Id) AS total FROM departementos d";
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(d.Nombre LIKE ? OR d.Telefono LIKE ? OR d.Email LIKE ? OR i.Nombre LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'ssss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY d.Nombre ASC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                $stmt_count = $mysqli->prepare($sql_count);
                if ($stmt_count === false)
                    sendErrorResponse('Error al preparar consulta de conteo: ' . $mysqli->error);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1] . $param_types[2] . $param_types[3]];
                    $search_params_count = [$params[0], $params[1], $params[2], $params[3]];
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
            $telefono = $input['Telefono'] ?? null;
            $email = $input['Email'] ?? null;
            $institucion = $input['Institucion'] ?? null; // ID de la institución
            if (empty($nombre))
                sendErrorResponse('El Nombre del departamento es obligatorio.', 400);

            $stmt = $mysqli->prepare("INSERT INTO departementos (Nombre, Telefono, Email, Institucion) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("sssi", $nombre, $telefono, $email, $institucion);
            if ($stmt->execute())
                sendJsonResponse(['success' => true, 'message' => 'Departamento creado exitosamente.', 'id' => $mysqli->insert_id]);
            else
                sendErrorResponse('Error al crear departamento: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $nombre = $input['Nombre'] ?? null;
            $telefono = $input['Telefono'] ?? null;
            $email = $input['Email'] ?? null;
            $institucion = $input['Institucion'] ?? null;
            if (empty($id) || empty($nombre))
                sendErrorResponse('ID y Nombre del departamento son obligatorios para la actualización.', 400);

            $stmt = $mysqli->prepare("UPDATE departementos SET Nombre = ?, Telefono = ?, Email = ?, Institucion = ? WHERE Id = ?");
            $stmt->bind_param("sssii", $nombre, $telefono, $email, $institucion, $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Departamento actualizado exitosamente.']);
                else
                    sendErrorResponse('Departamento no encontrado o no hubo cambios.', 404);
            } else
                sendErrorResponse('Error al actualizar departamento: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (empty($id))
                sendErrorResponse('ID de departamento no especificado.', 400);

            $stmt = $mysqli->prepare("DELETE FROM departementos WHERE Id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Departamento eliminado exitosamente.']);
                else
                    sendErrorResponse('Departamento no encontrado.', 404);
            } else
                sendErrorResponse('Error al eliminar departamento: ' . $mysqli->error, 500);
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

function generateDepartamentosPdf($mysqli, $searchTerm)
{
    class PDF extends FPDF
    { /* ... */
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Departamentos', 0, 1, 'C');
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
            $w = array(20, 60, 30, 50, 30); // Ajusta anchos
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
                $this->Cell($w[2], 6, $row['Telefono'], 'LR', 0, 'L', $fill);
                $this->Cell($w[3], 6, $row['Email'], 'LR', 0, 'L', $fill);
                $this->Cell($w[4], 6, $row['NombreInstitucion'], 'LR', 0, 'L', $fill);
                $this->Ln();
                $fill = !$fill;
            }
            $this->Cell(array_sum($w), 0, '', 'T');
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', '', 9);
    $sql = "SELECT d.Id, d.Nombre, d.Telefono, d.Email, i.Nombre AS NombreInstitucion FROM departementos d LEFT JOIN instituciones i ON d.Institucion = i.Id";
    $params = [];
    $param_types = '';
    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE d.Nombre LIKE ? OR d.Telefono LIKE ? OR d.Email LIKE ? OR i.Nombre LIKE ?";
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $param_types .= 'ssss';
    }
    $sql .= " ORDER BY d.Nombre ASC";
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
    $header = array('ID', 'Nombre', 'Teléfono', 'Email', 'Institución');
    $pdf->ImprovedTable($header, $data);
    $pdf->Output('I', 'reporte_departamentos.pdf');
    exit();
}
