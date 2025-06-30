<?php
header('Content-Type: application/json');
require_once('../config/conexion.php');

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception('Conexión a la base de datos no disponible.');
    }

    $stmt = $pdo->query("SELECT Id, Nombre FROM bancos ORDER BY Nombre ASC");
    $bancos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['message'] = 'Bancos cargados correctamente.';
    $response['data'] = $bancos;

} catch (PDOException $e) {
    http_response_code(500);
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
}

echo json_encode($response);
?>