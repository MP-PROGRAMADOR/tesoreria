<?php
// api/entradas.php
require '../conexion/conexion.php';

$entradas = [];
$search = $_GET['search'] ?? '';
$limit = $_GET['limit'] ?? 10;
$offset = $_GET['offset'] ?? 0;

// Validar y sanear inputs
$limit = (int)$limit > 0 ? (int)$limit : 10;
$offset = (int)$offset >= 0 ? (int)$offset : 0;
$search = $conn->real_escape_string($search); // Para prevenir SQL Injection

$query = "SELECT e.Id, e.NumRegistro, e.FechaRegistro, e.TipoDoc, e.Archivo, e.Descripcion, e.FechaFirma, e.Importe, u.Nombre as UsuarioNombre, r.Nombre as ReferenciaNombre
          FROM entradas e
          LEFT JOIN usuarios u ON e.Usuario = u.Id
          LEFT JOIN referencias r ON e.Referencia = r.Id";

$where = [];
if (!empty($search)) {
    $where[] = "(e.NumRegistro LIKE '%{$search}%' OR e.Descripcion LIKE '%{$search}%' OR e.PalabrasClaves LIKE '%{$search}%' OR e.TipoDoc LIKE '%{$search}%')";
}

if (!empty($where)) {
    $query .= " WHERE " . implode(" AND ", $where);
}

$query .= " ORDER BY e.FechaRegistro DESC LIMIT ? OFFSET ?";

try {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $entradas[] = array_map('htmlspecialchars', $row); // Sanitizar la salida
    }

    // Contar el total de registros para paginación
    $count_query = "SELECT COUNT(Id) AS total FROM entradas";
    if (!empty($where)) {
        $count_query .= " WHERE " . implode(" AND ", $where);
    }
    $totalResult = $conn->query($count_query);
    $total = $totalResult ? $totalResult->fetch_assoc()['total'] : 0;

    echo json_encode(['data' => $entradas, 'total' => $total]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error al obtener documentos de entrada: " . $e->getMessage()]);
} finally {
    $conn->close();
}
?>