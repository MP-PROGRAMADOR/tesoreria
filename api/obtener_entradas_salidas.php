<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    $query = "SELECT NumRegistro, TipoDoc FROM entradas ORDER BY NumRegistro DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $response['data'] = $stmt->fetchAll();
    $response['success'] = true;
    $stmt->closeCursor();
} catch (PDOException $e) {
    $response['message'] = "Error al obtener entradas: " . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>