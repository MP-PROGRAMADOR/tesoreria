<?php
// api/usuarios.php
require_once 'config.php';
setApiHeaders();

try {
    $mysqli = getDbConnection();
    $method = $_SERVER['REQUEST_METHOD'];

    switch ($method) {
        case 'GET':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
            if ($id > 0) {
                $stmt = $mysqli->prepare("SELECT u.Id, u.Nombre, u.Pass, u.Dpto, d.Nombre AS NombreDepartamento, u.Tipo_Usuario
                                         FROM usuarios u
                                         LEFT JOIN departementos d ON u.Dpto = d.Id
                                         WHERE u.Id = ?");
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();
                $usuario = $result->fetch_assoc();
                $stmt->close();
                if ($usuario)
                    sendJsonResponse(['success' => true, 'data' => $usuario]);
                else
                    sendErrorResponse('Usuario no encontrado.', 404);
            } elseif (isset($_GET['download_pdf'])) {
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
                generateUsuariosPdf($mysqli, $searchTerm);
            } else {
                $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
                $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
                $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

                $sql_select = "SELECT u.Id, u.Nombre, u.Dpto, d.Nombre AS NombreDepartamento, u.Tipo_Usuario
                               FROM usuarios u
                               LEFT JOIN departementos d ON u.Dpto = d.Id";
                $sql_count = "SELECT COUNT(u.Id) AS total FROM usuarios u";
                $where_clauses = [];
                $params = [];
                $param_types = '';

                if (!empty($searchTerm)) {
                    $search_pattern = '%' . $searchTerm . '%';
                    $where_clauses[] = "(u.Nombre LIKE ? OR d.Nombre LIKE ? OR u.Tipo_Usuario LIKE ?)";
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $params[] = $search_pattern;
                    $param_types .= 'sss';
                }

                if (!empty($where_clauses)) {
                    $sql_select .= " WHERE " . implode(" AND ", $where_clauses);
                    $sql_count .= " WHERE " . implode(" AND ", $where_clauses);
                }

                $sql_select .= " ORDER BY u.Nombre ASC LIMIT ? OFFSET ?";
                $params[] = $limit;
                $params[] = $offset;
                $param_types .= 'ii';

                $stmt_count = $mysqli->prepare($sql_count);
                if ($stmt_count === false)
                    sendErrorResponse('Error al preparar consulta de conteo: ' . $mysqli->error);
                if (!empty($searchTerm)) {
                    $bind_args_count = [$param_types[0] . $param_types[1] . $param_types[2]];
                    $search_params_count = [$params[0], $params[1], $params[2]];
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
            $pass = $input['Pass'] ?? null; // Contraseña en texto plano (¡HASHAR ANTES DE GUARDAR EN PROD!)
            $dpto = $input['Dpto'] ?? null;
            $tipoUsuario = $input['Tipo_Usuario'] ?? null;
            // Foto (blob) no se manejará directamente por JSON POST. Necesitaría un endpoint separado para subida de archivos.

            if (empty($nombre) || empty($pass) || empty($tipoUsuario)) {
                sendErrorResponse('Nombre, Contraseña y Tipo de Usuario son obligatorios.', 400);
            }

            // Hashing de la contraseña (¡CRÍTICO para producción!)
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

            $stmt = $mysqli->prepare("INSERT INTO usuarios (Nombre, Pass, Dpto, Tipo_Usuario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssis", $nombre, $hashed_pass, $dpto, $tipoUsuario);
            if ($stmt->execute())
                sendJsonResponse(['success' => true, 'message' => 'Usuario creado exitosamente.', 'id' => $mysqli->insert_id]);
            else
                sendErrorResponse('Error al crear usuario: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $id = $input['Id'] ?? null;
            $nombre = $input['Nombre'] ?? null;
            $pass = $input['Pass'] ?? null; // Si se envía, actualizar contraseña
            $dpto = $input['Dpto'] ?? null;
            $tipoUsuario = $input['Tipo_Usuario'] ?? null;
            if (empty($id) || empty($nombre) || empty($tipoUsuario)) {
                sendErrorResponse('ID, Nombre y Tipo de Usuario son obligatorios para la actualización.', 400);
            }

            $update_sql = "UPDATE usuarios SET Nombre = ?, Dpto = ?, Tipo_Usuario = ?";
            $update_params = [$nombre, $dpto, $tipoUsuario];
            $update_param_types = 'sis';

            if (!empty($pass)) {
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $update_sql .= ", Pass = ?";
                $update_params[] = $hashed_pass;
                $update_param_types .= 's';
            }
            $update_sql .= " WHERE Id = ?";
            $update_params[] = $id;
            $update_param_types .= 'i';

            $stmt = $mysqli->prepare($update_sql);
            if ($stmt === false)
                sendErrorResponse('Error al preparar la actualización de usuario: ' . $mysqli->error);

            $bind_args = [$update_param_types];
            foreach ($update_params as &$p) {
                $bind_args[] = &$p;
            }
            call_user_func_array([$stmt, 'bind_param'], $bind_args);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Usuario actualizado exitosamente.']);
                else
                    sendErrorResponse('Usuario no encontrado o no hubo cambios.', 404);
            } else
                sendErrorResponse('Error al actualizar usuario: ' . $stmt->error, 500);
            $stmt->close();
            break;

        case 'DELETE':
            $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
            if (empty($id))
                sendErrorResponse('ID de usuario no especificado.', 400);

            $stmt = $mysqli->prepare("DELETE FROM usuarios WHERE Id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0)
                    sendJsonResponse(['success' => true, 'message' => 'Usuario eliminado exitosamente.']);
                else
                    sendErrorResponse('Usuario no encontrado.', 404);
            } else
                sendErrorResponse('Error al eliminar usuario: ' . $mysqli->error, 500);
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

function generateUsuariosPdf($mysqli, $searchTerm)
{
    class PDF extends FPDF
    { /* ... */
        function Header()
        {
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Reporte de Usuarios', 0, 1, 'C');
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
            $w = array(20, 70, 50, 40); // Ajusta anchos
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
                $this->Cell($w[2], 6, $row['NombreDepartamento'], 'LR', 0, 'L', $fill);
                $this->Cell($w[3], 6, $row['Tipo_Usuario'], 'LR', 0, 'L', $fill);
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
    $sql = "SELECT u.Id, u.Nombre, d.Nombre AS NombreDepartamento, u.Tipo_Usuario FROM usuarios u LEFT JOIN departementos d ON u.Dpto = d.Id";
    $params = [];
    $param_types = '';
    if (!empty($searchTerm)) {
        $search_pattern = '%' . $searchTerm . '%';
        $sql .= " WHERE u.Nombre LIKE ? OR d.Nombre LIKE ? OR u.Tipo_Usuario LIKE ?";
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $params[] = $search_pattern;
        $param_types .= 'sss';
    }
    $sql .= " ORDER BY u.Nombre ASC";
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
    $header = array('ID', 'Nombre', 'Departamento', 'Tipo Usuario');
    $pdf->ImprovedTable($header, $data);
    $pdf->Output('I', 'reporte_usuarios.pdf');
    exit();
}
