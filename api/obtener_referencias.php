<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que esta ruta sea correcta

$response = ['success' => false, 'message' => ''];

try {
    // Asumiendo que tienes una tabla llamada 'referencias' con columnas 'Id' y 'Nombre'.
    // Si tu tabla se llama diferente o tiene otras columnas para el ID y el nombre,
    // ajusta la consulta SQL a continuación.
    $stmt = $pdo->prepare("SELECT Id AS id, Nombre AS nombre FROM referencias ORDER BY Nombre ASC");
    $stmt->execute();
    $references = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $references;

} catch (PDOException $e) {
    $response['message'] = "Error de base de datos al obtener referencias: " . $e->getMessage();
    error_log("Error al obtener referencias: " . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = "Error inesperado: " . $e->getMessage();
    error_log("Error inesperado en obtener_referencias.php: " . $e->getMessage());
}

echo json_encode($response);
?>