<?php
header('Content-Type: application/json');
require_once('../config/conexion.php');

global $pdo;

$response = [
    'success' => false,
    'message' => '',
    'data' => [],
    'totalRecords' => 0,
    'todayRecords' => 0,
    'monthRecords' => 0,
    'nextRegister' => 'N/A' // Initialize
];

try {
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception('Conexión a la base de datos no disponible.');
    }

    $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // --- Consulta: Total de registros ---
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM pagos");
    $response['totalRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del día ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pagos WHERE DATE(FechaFirma) = CURDATE()");
    $stmt->execute();
    $response['todayRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del mes actual ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pagos WHERE FechaFirma BETWEEN ? AND ?");
    $stmt->execute([date('Y-m-01'), date('Y-m-t')]);
    $response['monthRecords'] = (int) $stmt->fetchColumn();

    // --- Generar próximo NumRegistro para Pagos (PA-YYYY-NNN) ---
    // This logic assumes a sequential number for the current year
    $currentYear = date('Y');
    $stmtLastNum = $pdo->prepare("SELECT NumRegistro FROM pagos WHERE NumRegistro LIKE ? ORDER BY Id DESC LIMIT 1");
    $stmtLastNum->execute(["PA-{$currentYear}-%"]);
    $lastNumRegistro = $stmtLastNum->fetchColumn();

    $nextSequence = 1;
    if ($lastNumRegistro) {
        $parts = explode('-', $lastNumRegistro);
        if (count($parts) === 3 && is_numeric($parts[2])) {
            $nextSequence = (int)$parts[2] + 1;
        }
    }
    $response['nextRegister'] = "PA-{$currentYear}-" . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);


    // --- Consulta principal con filtros ---
    $query = "
        SELECT
            p.Id,
            p.NumRegistro,
            p.Concepto,
            p.Descripcion,
            DATE_FORMAT(p.FechaFirma, '%d-%m-%Y') AS FechaFirma,
            p.Cantidad,
            p.Archivo,
            p.Beneficiario,
            b.Nombre AS NombreBanco
        FROM
            pagos p
        LEFT JOIN
            bancos b ON p.Banco = b.Id
        WHERE 1=1
    ";

    $params = [];
    if (!empty($search)) {
        $query .= " AND (
            p.NumRegistro LIKE :search OR
            p.Concepto LIKE :search OR
            p.Descripcion LIKE :search OR
            p.Beneficiario LIKE :search OR
            b.Nombre LIKE :search
        )";
        $params[':search'] = "%$search%";
    }

    $query .= " ORDER BY p.Id DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($query);
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Pagos cargados correctamente.';
    $response['data'] = $rows;

} catch (PDOException $e) {
    http_response_code(500);
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
}

echo json_encode($response);
?>