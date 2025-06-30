<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo; // Asegúrate de que $pdo esté disponible globalmente o pásalo como parámetro

$response = [
    'success' => false,
    'message' => '',
    'data' => [],
    'totalRecords' => 0,
    'todayRecords' => 0,
    'monthRecords' => 0
];

try {
    // Validar conexión PDO
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception('Conexión a la base de datos no disponible.');
    }

    // Parámetros de entrada con validaciones básicas
    $limit = isset($_GET['limit']) && is_numeric($_GET['limit']) && $_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $limit;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';

    // --- Consulta: Total de registros ---
    $stmt = $pdo->query("SELECT COUNT(*) AS total FROM decretos");
    $response['totalRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del día ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM decretos WHERE Fecha = CURDATE()");
    $stmt->execute();
    $response['todayRecords'] = (int) $stmt->fetchColumn();

    // --- Consulta: Registros del mes actual ---
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM decretos WHERE Fecha BETWEEN ? AND ?");
    $stmt->execute([date('Y-m-01'), date('Y-m-t')]);
    $response['monthRecords'] = (int) $stmt->fetchColumn();
    
    
    // --- Consulta: Id del proximo registro---
$stmt = $pdo->query("SELECT MAX(Id) AS last_id FROM decretos");
    $lastId = $stmt->fetchColumn();
    $response['nextRegister'] = ($lastId) ? (int)$lastId + 1 : 1; // Si no hay registros, el próximo será 1

    // --- Consulta principal con filtros ---
    $query = "
        SELECT
            d.Id,
            d.Descripcion,
            DATE_FORMAT(d.Fecha, '%d-%m-%Y') AS Fecha,
            d.Archivo AS NombreArchivo,
            d.DocEntrada, -- Incluir el ID de DocEntrada para el frontend
            e.NumRegistro AS EntradaNumRegistro,
            e.TipoDoc AS EntradaTipoDoc,
            pf.NombreCompleto AS PersonaFisicaDestino,
            GROUP_CONCAT(DISTINCT m.Nombre SEPARATOR ', ') AS MiembrosDestino,
            GROUP_CONCAT(DISTINCT m.Id) AS MiembrosDestinoIds
        FROM
            decretos d
        LEFT JOIN
            entradas e ON d.DocEntrada = e.Id
        LEFT JOIN
            personafisica pf ON d.Id = pf.Decreto
        LEFT JOIN
            destino dt ON d.Id = dt.Decreto
        LEFT JOIN
            miembros m ON dt.Miembro = m.Id
        WHERE 1=1
    ";

    $params = [];

    // Filtro de búsqueda
    if (!empty($search)) {
        $query .= " AND (
            d.Descripcion LIKE :search OR
            e.NumRegistro LIKE :search OR
            pf.NombreCompleto LIKE :search OR
            m.Nombre LIKE :search
        )";
        $params[':search'] = '%' . $search . '%';
    }

    $query .= " GROUP BY d.Id ORDER BY d.Fecha DESC LIMIT :limit OFFSET :offset";

    $stmt = $pdo->prepare($query);

    // Bind dinámico de los parámetros de búsqueda
    foreach ($params as $key => &$val) {
        $stmt->bindParam($key, $val, PDO::PARAM_STR);
    }
    // Bind de los parámetros de paginación
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // --- Procesamiento por cada fila para determinar DestinoTipo ---
    foreach ($rows as &$row) {
        $row['DestinoTipo'] = 'N/A'; // Valor por defecto
        if ($row['PersonaFisicaDestino'] && !empty($row['MiembrosDestino'])) {
            $row['DestinoTipo'] = 'vpj'; // Varios miembros y Persona Física
        } elseif ($row['PersonaFisicaDestino']) {
            $row['DestinoTipo'] = 'pf'; // Solo Persona Física
        } elseif (!empty($row['MiembrosDestino'])) {
            $row['DestinoTipo'] = 'pj'; // Solo Miembros
        }

        // Convertir MiembrosDestinoIds a un array de enteros
        $row['MiembrosDestinoIds'] = !empty($row['MiembrosDestinoIds']) ? array_map('intval', explode(',', $row['MiembrosDestinoIds'])) : [];

        // Limpiar campos intermedios si no los necesitas en el frontend tal cual
        // unset($row['PersonaFisicaDestino'], $row['MiembrosDestino']); // Podrías mantenerlos si los usas para el display
    }
    unset($row); // Rompe la referencia al último elemento

    $response['success'] = true;
    $response['message'] = 'Decretos cargados correctamente.';
    $response['data'] = $rows;

} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500); // Internal Server Error
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
}

echo json_encode($response);
?>