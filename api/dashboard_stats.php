<?php
// api/dashboard_stats.php
require '../conexion/conexion.php';

$response = [
    'entradas' => 0,
    'salidas' => 0,
    'pagos' => 0,
    'usuarios' => 0
];

try {
    // Total Entradas
    $result = $conn->query("SELECT COUNT(Id) AS total FROM entradas");
    if ($result) {
        $response['entradas'] = $result->fetch_assoc()['total'];
        $result->free();
    }

    // Total Salidas
    $result = $conn->query("SELECT COUNT(Id) AS total FROM salidas");
    if ($result) {
        $response['salidas'] = $result->fetch_assoc()['total'];
        $result->free();
    }

    // Total Pagos
    $result = $conn->query("SELECT COUNT(Id) AS total FROM pagos");
    if ($result) {
        $response['pagos'] = $result->fetch_assoc()['total'];
        $result->free();
    }

    // Total Usuarios
    $result = $conn->query("SELECT COUNT(Id) AS total FROM usuarios");
    if ($result) {
        $response['usuarios'] = $result->fetch_assoc()['total'];
        $result->free();
    }

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error al obtener estadísticas: " . $e->getMessage()]);
} finally {
    $conn->close();
}
?>