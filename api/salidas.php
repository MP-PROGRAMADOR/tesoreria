<?php
// api/salidas.php
require_once 'config.php';
setApiHeaders();

try {
    $mysqli = getDbConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            if ($id > 0) {
                $stmt = $mysqli->prepare("SELECT s.Id, s.NumRegistro, s.FechaRegistro, s.TipoDoc, s.Archivo, s.Descripcion, s.PalabrasClaves, s.FechaFirma, s.Importe, s.Entrada AS EntradaRelacionada, s.Referencia AS ReferenciaId, r.Nombre AS NombreReferencia, s.Usuario AS UsuarioId, u.Nombre AS NombreUsuario
                                         FROM salidas s
                                         LEFT JOIN referencias r ON s.Referencia = r.Id
                                         LEFT JOIN usuarios u ON s.Usuario = u.Id
                                         WHERE s.Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $salida = $result->fetch_assoc();
                $stmt->close();
                if ($salida) {
                    $salida['FechaRegistro'] = $salida['FechaRegistro'] ? date('Y-m-d', strtotime($salida['FechaRegistro'])) : '';
                    $salida['FechaFirma'] = $salida['FechaFirma'] ? date('Y-m-d', strtotime($salida['FechaFirma'])) : '';
                    sendJsonResponse(['success' => true, 'data' => $salida]);
                } else {
                    sendErrorResponse('Documento de Salida no encontrado.', 404);
                }
            } elseif (isset($_GET['download_pdf'])) {
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generateSalidasPdf($mysqli, $searchTerm);
            } else {
                $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT s.Id, s.NumRegistro, s.FechaRegistro, s.TipoDoc, s.Archivo, s.Descripcion, s.PalabrasClaves, s.FechaFirma, s.Importe, s.Entrada AS EntradaRelacionada, r.Nombre AS NombreReferencia, u.Nombre AS NombreUsuario
                               FROM salidas s
                               LEFT JOIN referencias r ON s.Referencia = r.Id
                               LEFT JOIN usuarios u ON s.Usuario = u.Id";
                $sql_count = "SELECT COUNT(s.Id) AS total FROM salidas s";
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(s.NumRegistro LIKE ? OR s.TipoDoc LIKE ? OR s.Descripcion LIKE ? OR s.PalabrasClaves LIKE ? OR r.Nombre LIKE ? OR u.Nombre LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'ssssss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY s.FechaRegistro DESC, s.Id DESC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                $stmt_count = $mysqli->prepare($sql_count);
                if ($stmt_count === false)
                    sendErrorResponse('Error al preparar consulta de conteo: ' . $mysqli->error);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1] . $param_types[2] . $param_types[3] . $param_types[4] . $param_types[5]];
                    $search_params_count = [$params[0], $params[1], $params[2], $params[3], $params[4], $params[5]];
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
                    $row['FechaRegistro'] = $row['FechaRegistro'] ? date('d/m/Y', strtotime($row['FechaRegistro'])) : '';
                    $row['FechaFirma'] = $row['FechaFirma'] ? date('d/m/Y', strtotime($row['FechaFirma'])) : '';
                    $data[] = $row;
                }
                $stmt->close();
                sendJsonResponse(['success' => true, 'data' => $data, 'total' => $total_records]);
            }
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $numRegistro = $input['NumRegistro'] ?? null;
            $fechaRegistro = $input['FechaRegistro'] ?? null;
            $tipoDoc = $input['TipoDoc'] ?? null;
            $archivo = $input['Archivo'] ?? null; // Manejo de archivos separado
            $descripcion = $input['Descripcion'] ?? null;
            $palabrasClaves = $input['PalabrasClaves'] ?? null;
            $fechaFirma = $input['FechaFirma'] ?? null;
            $importe = $input['Importe'] ?? null;
            $entrada = $input['Entrada'] ?? null; // ID de entrada
            $referencia = $input['Referencia'] ?? null; // ID de referencia
            $usuario = $input['Usuario'] ?? null; // ID de usuario

            if (empty($numRegistro) || empty($fechaRegistro) || empty($tipoDoc)) {
                sendErrorResponse('Número de Registro, Fecha de Registro y Tipo de Documento son obligatorios.', 400);
            }

            $stmt = $mysqli->prepare("INSERT INTO salidas (NumRegistro, FechaRegistro, TipoDoc, Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Entrada, Referencia, Usuario) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssssdsii", $numRegistro, $fechaRegistro, $tipoDoc, $archivo, $descripcion, $palabrasClaves, $fechaFirma, $importe, $entrada, $referencia, $usuario);

            if ($stmt->execute()) {
                sendJsonResponse(['success' => true, 'message' => 'Documento de Salida creado exitosamente.', 'id' => $mysqli->insert_id]);
            } else {
                sendErrorResponse('Error al crear documento de salida: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $numRegistro = $input['NumRegistro'] ?? null;
            $fechaRegistro = $input['FechaRegistro'] ?? null;
            $tipoDoc = $input['TipoDoc'] ?? null;
            $archivo = $input['Archivo'] ?? null;
            $descripcion = $input['Descripcion'] ?? null;
            $palabrasClaves = $input['PalabrasClaves'] ?? null;
            $fechaFirma = $input['FechaFirma'] ?? null;
            $importe = $input['Importe'] ?? null;
            $entrada = $input['Entrada'] ?? null;
            $referencia = $input['Referencia'] ?? null;
            $usuario = $input['Usuario'] ?? null;

            if (empty($id) || empty($numRegistro) || empty($fechaRegistro) || empty($tipoDoc)) {
                sendErrorResponse('ID, Número de Registro, Fecha de Registro y Tipo de Documento son obligatorios para la actualización.', 400);
            }

            $stmt = $mysqli->prepare("UPDATE salidas SET NumRegistro = ?, FechaRegistro = ?, TipoDoc = ?, Archivo = ?, Descripcion = ?, PalabrasClaves = ?, FechaFirma = ?, Importe = ?, Entrada = ?, Referencia = ?, Usuario = ? WHERE Id = ?");
            $stmt->bind_param("sssssssdsiii", $numRegistro, $fechaRegistro, $tipoDoc, $archivo, $descripcion, $palabrasClaves, $fechaFirma, $importe, $entrada, $referencia, $usuario, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Documento de Salida actualizado exitosamente.']);
                } else {
                    sendErrorResponse('Documento de Salida no encontrado o no hubo cambios.', 404);
                }
            } else {
                sendErrorResponse('Error al actualizar documento de salida: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (empty($id))
                sendErrorResponse('ID de documento de salida no especificado.', 400);

            $stmt = $mysqli->prepare("DELETE FROM salidas WHERE Id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Documento de Salida eliminado exitosamente.']);
                } else {
                    sendErrorResponse('Documento de Salida no encontrado.', 404);
                }
            } else {
                sendErrorResponse('Error al eliminar documento de salida: ' . $mysqli->error, 500);
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

function generateSalidasPdf($mysqli, $searchTerm)
{
    class PDF extends FPDF
    { /* ... */
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Documentos de Salida', 0, 1, 'C');
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
            $w = array(15, 25, 25, 30, 60, 25, 30); // Ajusta anchos para un A4 landscape
            for ($i = 0; $i < count($header); $i++)
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();
            $this->SetFillColor(240, 248, 255);
            $this->SetTextColor(0);
            $this->SetFont('');
            $fill = false;
            foreach ($data as $row) {
                // MultiCell para Descripcion si es larga
                $descHeight = 7;
                $this->Cell($w[0], $descHeight, $row['Id'], 'LR', 0, 'C', $fill);
                $this->Cell($w[1], $descHeight, $row['NumRegistro'], 'LR', 0, 'L', $fill);
                $this->Cell($w[2], $descHeight, $row['FechaRegistro'], 'LR', 0, 'C', $fill);
                $this->Cell($w[3], $descHeight, $row['TipoDoc'], 'LR', 0, 'L', $fill);

                $x = $this->GetX();
                $y = $this->GetY();
                $this->MultiCell($w[4], 5, $row['Descripcion'], 'LR', 'L', $fill);
                $this->SetXY($x + $w[4], $y);

                $this->Cell($w[5], $descHeight, $row['NombreUsuario'], 'LR', 0, 'L', $fill);
                $this->Cell($w[6], $descHeight, $row['NombreReferencia'], 'LR', 0, 'L', $fill);
                $this->Ln($descHeight);
                $fill = !$fill;
            }
            $this->Cell(array_sum($w), 0, '', 'T');
        }
    }
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L'); // Horizontal
    $pdf->SetFont('Arial', '', 9);
    $sql = "SELECT s.Id, s.NumRegistro, s.FechaRegistro, s.TipoDoc, s.Descripcion, u.Nombre AS NombreUsuario, r.Nombre AS NombreReferencia FROM salidas s LEFT JOIN referencias r ON s.Referencia = r.Id LEFT JOIN usuarios u ON s.Usuario = u.Id";
    $params = [];
    $param_types = '';
    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE s.NumRegistro LIKE ? OR s.TipoDoc LIKE ? OR s.Descripcion LIKE ? OR u.Nombre LIKE ? OR r.Nombre LIKE ?";
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $param_types .= 'sssss';
    }
    $sql .= " ORDER BY s.FechaRegistro DESC, s.Id DESC";
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
        $row['FechaRegistro'] = $row['FechaRegistro'] ? date('d/m/Y', strtotime($row['FechaRegistro'])) : '';
        $data[] = $row;
    }
    $stmt->close();
    $header = array('ID', 'Nº Reg.', 'Fecha Reg.', 'Tipo Doc.', 'Descripción', 'Usuario', 'Referencia');
    $pdf->ImprovedTable($header, $data);
    $pdf->Output('I', 'reporte_salidas.pdf');
    exit();
}