<?php
header('Content-Type: application/json');
require_once('../config/conexion.php');

$response = [
    'success' => false,
    'message' => '',
    'data' => [],
    'totalRecords' => 0,
    'todayRecords' => 0,
    'monthRecords' => 0,
    'nextRegister' => ''
];

try {
    // --- Validar conexión PDO ---
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception('Conexión a la base de datos no disponible.');
    }

    // --- Parámetros de entrada con validaciones básicas ---
    $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // --- Consulta: Total de registros ---
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM salidas");
    $response['totalRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del día ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM salidas WHERE FechaRegistro = CURDATE()");
    $stmt->execute();
    $response['todayRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del mes actual ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM salidas WHERE FechaRegistro BETWEEN ? AND ?");
    $stmt->execute([date('Y-m-01'), date('Y-m-t')]);
    $response['monthRecords'] = (int) $stmt->fetchColumn();

    // --- Generar próximo número de registro ---
    $stmt = $pdo->prepare("SELECT MAX(NumRegistro) AS last_reg FROM salidas WHERE NumRegistro LIKE 'SL-%'");
    $stmt->execute();
    $lastReg = $stmt->fetchColumn();

    if ($lastReg && preg_match('/SL-(\d{4})-(\d+)/', $lastReg, $matches)) {
        $anio = (int)$matches[1];
        $num = (int)$matches[2];
        $nuevoNum = ($anio == date('Y')) ? $num + 1 : 1;
    } else {
        $nuevoNum = 1;
    }

    $response['nextRegister'] = 'SL-' . date('Y') . '-' . str_pad($nuevoNum, 3, '0', STR_PAD_LEFT);

    // --- Consulta principal con filtros ---
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
        s.Entrada AS EntradaRelacionadaNum,
        s.Archivo AS NombreArchivo,

        pf.NombreCompleto AS PersonaFisicaDestino,

        (
            SELECT i2.Nombre 
            FROM ir ir2
            INNER JOIN departementos d2 ON ir2.Seccion = d2.Id
            INNER JOIN instituciones i2 ON d2.Institucion = i2.Id
            WHERE ir2.Salida = s.Id
            LIMIT 1
        ) AS InstitucionDestino,

        GROUP_CONCAT(DISTINCT CONCAT(i.Nombre_Corto, '/', d.Nombre) SEPARATOR ', ') AS MultiplesDestinos,
        GROUP_CONCAT(DISTINCT d.Id) AS DepartamentosMultiplesIds

    FROM salidas s
    LEFT JOIN referencias r ON s.Referencia = r.Id
    LEFT JOIN personafisica pf ON pf.Salida = s.Id

    LEFT JOIN ir ON ir.Salida = s.Id
    LEFT JOIN departementos d ON ir.Seccion = d.Id
    LEFT JOIN instituciones i ON d.Institucion = i.Id

    WHERE 1=1
";


    $params = [];

    // --- Filtro de búsqueda ---
    if (!empty($search)) {
        $query .= " AND (
            s.NumRegistro LIKE :search OR 
            s.Descripcion LIKE :search OR 
            s.PalabrasClaves LIKE :search OR 
            r.Nombre LIKE :search
        )";
        $params[':search'] = "%$search%";
    }

    $query .= " GROUP BY s.Id ORDER BY s.FechaRegistro DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($query);

    // Bind dinámico
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- Procesamiento por cada fila ---
    foreach ($rows as &$row) {
        $row['destinoTipo'] = 'N/A';
        $row['envioA'] = 'N/A';
        $row['persFisic'] = null;
        $row['institucionId'] = null;
        $row['departamentoIds'] = [];

        if ($row['PersonaFisicaDestino']) {
            $row['destinoTipo'] = 'pf';
            $row['envioA'] = $row['PersonaFisicaDestino'];
            $row['persFisic'] = $row['PersonaFisicaDestino'];
        } elseif ($row['MultiplesDestinos']) {
            $departamentos = array_map('intval', explode(',', $row['DepartamentosMultiplesIds'] ?? ''));
            if (count($departamentos) === 1) {
                $stmtDept = $pdo->prepare("
                    SELECT d.Nombre, i.Nombre AS InstitucionNombre, i.Id AS InstitucionId 
                    FROM departementos d 
                    JOIN instituciones i ON d.Institucion = i.Id 
                    WHERE d.Id = ?
                ");
                $stmtDept->execute([$departamentos[0]]);
                $info = $stmtDept->fetch(PDO::FETCH_ASSOC);
                if ($info) {
                    $row['destinoTipo'] = 'pj';
                    $row['envioA'] = $info['InstitucionNombre'];
                    $row['institucionId'] = $info['InstitucionId'];
                }
            } else {
                $row['destinoTipo'] = 'vpj';
                $row['envioA'] = 'Varias Personas Jurídicas';
                $row['departamentoIds'] = $departamentos;
            }
        }

        // Limpiar
        unset($row['PersonaFisicaDestino'], $row['InstitucionDestino'], $row['MultiplesDestinos'], $row['DepartamentosMultiplesIds']);

        // Fallback
        $row['NombreReferencia'] = $row['NombreReferencia'] ?? 'N/A';
    }

    $response['success'] = true;
    $response['message'] = 'Salidas cargadas correctamente.';
    $response['data'] = $rows;

} catch (PDOException $e) {
    http_response_code(500);
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
}

echo json_encode($response);
