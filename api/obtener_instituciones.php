<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que esta ruta sea correcta

$response = ['success' => false, 'message' => ''];

try {
    $stmt = $pdo->prepare("SELECT Id AS id, Nombre AS nombre, Nombre_Corto AS nombre_corto FROM instituciones ORDER BY Nombre ASC");
    $stmt->execute();
    $institutions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $institutions;

} catch (PDOException $e) {
    $response['message'] = "Error de base de datos al obtener instituciones: " . $e->getMessage();
    error_log("Error al obtener instituciones: " . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = "Error inesperado: " . $e->getMessage();
    error_log("Error inesperado en obtener_instituciones.php: " . $e->getMessage());
}

echo json_encode($response);
?>