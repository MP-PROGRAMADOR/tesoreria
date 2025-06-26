<?php
// PRIMERO y MUY IMPORTANTE: Asegúrate de que NADA se imprima antes de esta línea.
// No hay espacios, saltos de línea, BOM de UTF-8 invisible, etc.

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Ajustar en producción
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

 
require '../conexion/conexion.php';
// --- Obtener parámetros de la solicitud ---
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
// Usar sentencias preparadas para el término de búsqueda es más seguro.
$searchTerm = isset($_GET['search']) ? $_GET['search'] : ''; 

// --- Construir la consulta SQL ---
// Usaremos sentencias preparadas para la parte de la búsqueda para mayor seguridad.
$sql_select = "SELECT 
                    s.Id, 
                    s.NumRegistro, 
                    s.FechaRegistro, 
                    s.TipoDoc, 
                    s.Archivo, 
                    s.Descripcion, 
                    s.PalabrasClaves, 
                    s.FechaFirma, 
                    s.Importe,
                    s.Entrada AS EntradaRelacionada,
                    r.Nombre AS NombreReferencia,
                    u.Nombre AS NombreUsuario
                FROM salidas s
                LEFT JOIN referencias r ON s.Referencia = r.Id
                LEFT JOIN usuarios u ON s.Usuario = u.Id";

$sql_count = "SELECT COUNT(s.Id) AS total FROM salidas s"; // Usa s.Id en COUNT
$where_params = [];
$param_types = '';

if (!empty($searchTerm)) {
    $search_pattern = '%' . $searchTerm . '%';
    $where_clauses_array = [];
    $where_clauses_array[] = "s.NumRegistro LIKE ?";
    $where_clauses_array[] = "s.TipoDoc LIKE ?";
    $where_clauses_array[] = "s.Descripcion LIKE ?";
    $where_clauses_array[] = "s.PalabrasClaves LIKE ?";
    $where_clauses_array[] = "s.Importe LIKE ?";
    $where_clauses_array[] = "r.Nombre LIKE ?";
    $where_clauses_array[] = "u.Nombre LIKE ?";
    
    $sql_select .= " WHERE (" . implode(" OR ", $where_clauses_array) . ")";
    $sql_count .= " WHERE (" . implode(" OR ", $where_clauses_array) . ")";

    // Añadir los parámetros para la sentencia preparada
    for ($i = 0; $i < count($where_clauses_array); $i++) {
        $where_params[] = $search_pattern;
        $param_types .= 's'; // 's' para string
    }
}

// Añadir paginación
$sql_select .= " ORDER BY s.FechaRegistro DESC LIMIT ? OFFSET ?";
$param_types .= 'ii'; // 'i' para integer (limit y offset)
$where_params[] = $limit;
$where_params[] = $offset;


$data = [];
$total_records = 0;

// --- Preparar y ejecutar consulta para obtener el total de registros ---
$stmt_count = $conn->prepare($sql_count);
if ($stmt_count === false) {
    echo json_encode(['error' => 'Error al preparar la consulta de conteo: ' . $conn->error]);
    exit();
}

if (!empty($searchTerm)) {
    // Si hay término de búsqueda, bind_param solo para los parámetros de búsqueda
    // Usamos 's' para string para los términos de búsqueda
    $search_bind_params = array_fill(0, count($where_clauses_array), $search_pattern);
    $bind_args = [str_repeat('s', count($where_clauses_array))];
    foreach ($search_bind_params as &$p) {
        $bind_args[] = &$p;
    }
    call_user_func_array([$stmt_count, 'bind_param'], $bind_args);
}

$stmt_count->execute();
$result_count = $stmt_count->get_result();

if ($result_count) {
    $row_count = $result_count->fetch_assoc();
    $total_records = $row_count['total'];
    $result_count->free();
} else {
    echo json_encode(['error' => 'Error al obtener el total de registros: ' . $stmt_count->error]);
    $stmt_count->close();
    $conn->close();
    exit();
}
$stmt_count->close();

// --- Preparar y ejecutar consulta para obtener los datos ---
$stmt = $conn->prepare($sql_select);
if ($stmt === false) {
    echo json_encode(['error' => 'Error al preparar la consulta de datos: ' . $conn->error]);
    exit();
}

// Bind de parámetros para la consulta principal (búsqueda + paginación)
if (!empty($where_params)) {
    $bind_args = [$param_types];
    foreach ($where_params as &$param) {
        $bind_args[] = &$param;
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_args);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Formatear fechas si es necesario
        $row['FechaRegistro'] = $row['FechaRegistro'] ? date('d/m/Y', strtotime($row['FechaRegistro'])) : '';
        $row['FechaFirma'] = $row['FechaFirma'] ? date('d/m/Y', strtotime($row['FechaFirma'])) : '';
        $data[] = $row;
    }
    $result->free();
} else {
    echo json_encode(['error' => 'Error al obtener los datos: ' . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

// --- Cerrar conexión ---
$conn->close();

// --- Devolver respuesta JSON ---
echo json_encode([
    'data' => $data,
    'total' => $total_records
]);

// Final de tu archivo PHP. No debe haber ningún carácter, espacio o nueva línea
// después de esta etiqueta. Es por esto que a menudo se omite la etiqueta de cierre.
 ?>