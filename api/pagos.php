<?php
// api/pagos.php
require_once 'config.php';
setApiHeaders();

try {
    $mysqli = getDbConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id > 0) {
                $stmt = $mysqli->prepare("SELECT p.Id, p.NumRegistro, p.Concepto, p.Descripcion, p.FechaFirma, p.Cantidad, p.Archivo, p.Beneficiario, b.Nombre AS NombreBanco, u.Nombre AS NombreUsuario
                                         FROM pagos p
                                         LEFT JOIN bancos b ON p.Banco = b.Id
                                         LEFT JOIN usuarios u ON p.Usuario = u.Id
                                         WHERE p.Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $pago = $result->fetch_assoc();
                $stmt->close();
                if ($pago) {
                    $pago['FechaFirma'] = $pago['FechaFirma'] ? date('Y-m-d', strtotime($pago['FechaFirma'])) : ''; // Formato para editar
                    sendJsonResponse(['success' => true, 'data' => $pago]);
                } else {
                    sendErrorResponse('Pago no encontrado.', 404);
                }
            } elseif (isset($_GET['download_pdf'])) {
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generatePagosPdf($mysqli, $searchTerm);
            } else {
                $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT p.Id, p.NumRegistro, p.Concepto, p.Descripcion, p.FechaFirma, p.Cantidad, p.Archivo, p.Beneficiario, b.Nombre AS NombreBanco, u.Nombre AS NombreUsuario
                               FROM pagos p
                               LEFT JOIN bancos b ON p.Banco = b.Id
                               LEFT JOIN usuarios u ON p.Usuario = u.Id";
                $sql_count = "SELECT COUNT(p.Id) AS total FROM pagos p";
                
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(p.NumRegistro LIKE ? OR p.Concepto LIKE ? OR p.Descripcion LIKE ? OR p.Beneficiario LIKE ? OR b.Nombre LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'sssss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY p.FechaFirma DESC, p.Id DESC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                // Obtener total de registros
                $stmt_count = $mysqli->prepare($sql_count);
                if ($stmt_count === false) sendErrorResponse('Error al preparar consulta de conteo: ' . $mysqli->error);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1] . $param_types[2] . $param_types[3] . $param_types[4]];
                    $search_params_count = [$params[0], $params[1], $params[2], $params[3], $params[4]];
                    foreach ($search_params_count as &$p) { $bind_args_count[] = &$p; }
                    call_user_func_array([$stmt_count, 'bind_param'], $bind_args_count);
                }
                $stmt_count->execute();
                $result_count = $stmt_count->get_result();
                $total_records = $result_count->fetch_assoc()['total'];
                $stmt_count->close();

                // Obtener datos
                $stmt = $mysqli->prepare($sql_select);
                if ($stmt === false) sendErrorResponse('Error al preparar consulta de datos: ' . $mysqli->error);
                $bind_args = [$param_types];
                foreach ($params as &$p) { $bind_args[] = &$p; }
                call_user_func_array([$stmt, 'bind_param'], $bind_args);
                
                $stmt->execute();
                $result = $stmt->get_result();
                $data = [];
                while ($row = $result->fetch_assoc()) {
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
            $concepto = $input['Concepto'] ?? null;
            $descripcion = $input['Descripcion'] ?? null;
            $fechaFirma = $input['FechaFirma'] ?? null;
            $cantidad = $input['Cantidad'] ?? null;
            $archivo = $input['Archivo'] ?? null; // Esto se manejaría mejor con subida de archivos
            $usuario = $input['Usuario'] ?? null;
            $beneficiario = $input['Beneficiario'] ?? null;
            $banco = $input['Banco'] ?? null;

            if (empty($numRegistro) || empty($concepto) || empty($fechaFirma) || !isset($cantidad)) {
                sendErrorResponse('NumRegistro, Concepto, FechaFirma y Cantidad son obligatorios.', 400);
            }

            $stmt = $mysqli->prepare("INSERT INTO pagos (NumRegistro, Concepto, Descripcion, FechaFirma, Cantidad, Archivo, Usuario, Beneficiario, Banco) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssdsisss", $numRegistro, $concepto, $descripcion, $fechaFirma, $cantidad, $archivo, $usuario, $beneficiario, $banco);

            if ($stmt->execute()) {
                sendJsonResponse(['success' => true, 'message' => 'Pago creado exitosamente.', 'id' => $mysqli->insert_id]);
            } else {
                sendErrorResponse('Error al crear pago: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $numRegistro = $input['NumRegistro'] ?? null;
            $concepto = $input['Concepto'] ?? null;
            $descripcion = $input['Descripcion'] ?? null;
            $fechaFirma = $input['FechaFirma'] ?? null;
            $cantidad = $input['Cantidad'] ?? null;
            $archivo = $input['Archivo'] ?? null;
            $usuario = $input['Usuario'] ?? null;
            $beneficiario = $input['Beneficiario'] ?? null;
            $banco = $input['Banco'] ?? null;

            if (empty($id) || empty($numRegistro) || empty($concepto) || empty($fechaFirma) || !isset($cantidad)) {
                sendErrorResponse('ID, NumRegistro, Concepto, FechaFirma y Cantidad son obligatorios para la actualización.', 400);
            }

            $stmt = $mysqli->prepare("UPDATE pagos SET NumRegistro = ?, Concepto = ?, Descripcion = ?, FechaFirma = ?, Cantidad = ?, Archivo = ?, Usuario = ?, Beneficiario = ?, Banco = ? WHERE Id = ?");
            $stmt->bind_param("sssdsisssi", $numRegistro, $concepto, $descripcion, $fechaFirma, $cantidad, $archivo, $usuario, $beneficiario, $banco, $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Pago actualizado exitosamente.']);
                } else {
                    sendErrorResponse('Pago no encontrado o no hubo cambios.', 404);
                }
            } else {
                sendErrorResponse('Error al actualizar pago: ' . $stmt->error, 500);
            }
            $stmt->close();
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
            if (empty($id)) sendErrorResponse('ID de pago no especificado.', 400);

            $stmt = $mysqli->prepare("DELETE FROM pagos WHERE Id = ?");
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    sendJsonResponse(['success' => true, 'message' => 'Pago eliminado exitosamente.']);
                } else {
                    sendErrorResponse('Pago no encontrado.', 404);
                }
            } else {
                sendErrorResponse('Error al eliminar pago: ' . $stmt->error, 500);
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

function generatePagosPdf($mysqli, $searchTerm) {
    class PDF extends FPDF { /* ... igual que en decretos, adapta cabecera y footer ... */
        function Header() {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Pagos', 0, 1, 'C');
            $this->Ln(5);
        }
        function Footer() { /* ... */ }

        function ImprovedTable($header, $data) {
            $this->SetFillColor(44, 90, 160);
            $this->SetTextColor(255);
            $this->SetDrawColor(0, 0, 0);
            $this->SetLineWidth(.3);
            $this->SetFont('', 'B');

            // Ajusta anchos de columna para pagos
            $w = array(15, 25, 45, 30, 25, 45); // Ejemplo: Id, NumRegistro, Concepto, Cantidad, Fecha, Beneficiario
            
            for($i=0; $i<count($header); $i++)
                $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
            $this->Ln();

            $this->SetFillColor(240, 248, 255);
            $this->SetTextColor(0);
            $this->SetFont('');

            $fill = false;
            foreach($data as $row) {
                // Considera MultiCell para Concepto y Descripcion si son largos
                $conceptHeight = 7; // Altura mínima de la fila
                
                $this->Cell($w[0], $conceptHeight, $row['Id'], 'LR', 0, 'C', $fill);
                $this->Cell($w[1], $conceptHeight, $row['NumRegistro'], 'LR', 0, 'L', $fill);
                
                $x = $this->GetX(); $y = $this->GetY();
                $this->MultiCell($w[2], 5, $row['Concepto'], 'LR', 'L', $fill);
                $this->SetXY($x + $w[2], $y); // Vuelve a la posición para la siguiente celda

                $this->Cell($w[3], $conceptHeight, number_format($row['Cantidad'], 2), 'LR', 0, 'R', $fill);
                $this->Cell($w[4], $conceptHeight, $row['FechaFirma'], 'LR', 0, 'C', $fill);
                
                $x = $this->GetX(); $y = $this->GetY();
                $this->MultiCell($w[5], 5, $row['Beneficiario'], 'LR', 'L', $fill);
                $this->SetXY($x + $w[5], $y);

                // Añade el resto de las celdas de la fila
                // Puedes necesitar ajustar esto dependiendo de qué campos incluyas en $header
                // y los anchos $w

                $this->Ln($conceptHeight);
                $fill = !$fill;
            }
            $this->Cell(array_sum($w), 0, '', 'T');
        }
    }

    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('L'); // Página horizontal para más columnas
    $pdf->SetFont('Arial', '', 9); // Fuente más pequeña para más datos

    $sql = "SELECT p.Id, p.NumRegistro, p.Concepto, p.FechaFirma, p.Cantidad, p.Beneficiario
            FROM pagos p
            LEFT JOIN bancos b ON p.Banco = b.Id
            LEFT JOIN usuarios u ON p.Usuario = u.Id";
    $params = [];
    $param_types = '';

    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE p.NumRegistro LIKE ? OR p.Concepto LIKE ? OR p.Beneficiario LIKE ?";
        $params[] = $search_pattern; $params[] = $search_pattern; $params[] = $search_pattern;
        $param_types .= 'sss';
    }
    $sql .= " ORDER BY p.FechaFirma DESC, p.Id DESC";

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
        $row['FechaFirma'] = $row['FechaFirma'] ? date('d/m/Y', strtotime($row['FechaFirma'])) : '';
        $data[] = $row;
    }
    $stmt->close();

    $header = array('ID', 'Nº Reg.', 'Concepto', 'Cantidad', 'Fecha', 'Beneficiario');
    $pdf->ImprovedTable($header, $data);
    
    $pdf->Output('I', 'reporte_pagos.pdf');
    exit();
}