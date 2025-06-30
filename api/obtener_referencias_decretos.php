<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    $query = "SELECT Id, Nombre FROM miembros ORDER BY Nombre ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $response['data'] = $stmt->fetchAll();
    $response['success'] = true;
    $stmt->closeCursor();
} catch (PDOException $e) {
    $response['message'] = "Error al obtener miembros: " . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>