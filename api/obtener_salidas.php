<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que esta ruta sea correcta

$response = ['success' => false, 'message' => ''];
$data = [];
$totalRegistros = 0;
$totalHoy = 0;
$totalMes = 0;
$nextRegistro = '';

try {
    // Parámetros GET
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // Total general
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM Salidas");
    $totalRegistros = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total hoy
    $today = date('Y-m-d');
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM Salidas WHERE DATE(FechaRegistro) = ?");
    $stmt->execute([$today]);
    $totalHoy = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Total mes actual
    $firstDayMonth = date('Y-m-01');
    $lastDayMonth = date('Y-m-t');
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM Salidas WHERE FechaRegistro BETWEEN ? AND ?");
    $stmt->execute([$firstDayMonth, $lastDayMonth]);
    $totalMes = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Próximo número de registro
    $stmt = $pdo->prepare("SELECT MAX(NumRegistro) AS last_reg FROM Salidas WHERE NumRegistro LIKE 'SL-%'");
    $stmt->execute();
    $lastReg = $stmt->fetch(PDO::FETCH_ASSOC)['last_reg'];

    if ($lastReg && preg_match('/SL-(\d{4})-(\d+)/', $lastReg, $matches)) {
        $year = (int)$matches[1];
        $number = (int)$matches[2];
        if ($year == date('Y')) {
            $nextRegistro = 'SL-' . date('Y') . '-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextRegistro = 'SL-' . date('Y') . '-001';
        }
    } else {
        $nextRegistro = 'SL-' . date('Y') . '-001';
    }

    // Consulta principal
    $query = "
        SELECT
            s.Id,
            s.NumRegistro,
            DATE_FORMAT(s.FechaRegistro, '%d-%m-%Y') AS FechaRegistro,
            s.TipoDoc,
            s.Descripcion,
            s.PalabrasClaves,
            r.Nombre AS NombreReferencia,
            DATE_FORMAT(s.FechaFirma, '%d-%m-%Y') AS FechaFirma,
            s.Importe,
            s.DestinoTipo,
            s.PersonaFisicaDestino,
            s.InstitucionDestino,
            GROUP_CONCAT(DISTINCT CONCAT(i.Nombre_Corto, '/', d.Nombre) SEPARATOR ', ') AS MultiplesDestinos,
            s.EntradaRelacionada,
            s.NombreArchivo
        FROM Salidas s
        LEFT JOIN Referencias r ON s.Referencia = r.Id
        LEFT JOIN Salidas_Destinos_Multiples sdm ON s.Id = sdm.SalidaId
        LEFT JOIN Departementos d ON sdm.DepartamentoId = d.id
        LEFT JOIN Instituciones i ON d.Institucion = i.Id
        WHERE 1=1
    ";

    $params = [];

    if (!empty($search)) {
        $query .= " AND (
            s.NumRegistro LIKE :search OR
            s.Descripcion LIKE :search OR
            s.PalabrasClaves LIKE :search OR
            r.Nombre LIKE :search
        )";
        $params[':search'] = '%' . $search . '%';
    }

    $query .= " GROUP BY s.Id ORDER BY s.FechaRegistro DESC LIMIT :limit OFFSET :offset";

    // Preparar y ejecutar
    $stmt = $pdo->prepare($query);
    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = count($data) > 0 ? 'Salidas obtenidas correctamente.' : 'No se encontraron salidas.';
    $response['data'] = $data;
    $response['totalRecords'] = $totalRegistros;
    $response['todayRecords'] = $totalHoy;
    $response['monthRecords'] = $totalMes;
    $response['nextRegister'] = $nextRegistro;

} catch (Exception $e) {
    $response['message'] = 'Error al obtener las salidas: ' . $e->getMessage();
}

echo json_encode($response);
