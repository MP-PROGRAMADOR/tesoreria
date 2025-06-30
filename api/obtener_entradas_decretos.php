<?php
// Set content type to JSON
header('Content-Type: application/json');
// Include your database connection
require_once('../config/conexion.php'); // Adjust path if necessary

global $pdo; // Assuming $pdo is your PDO connection object

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    // Prepare and execute the SQL query to select Id, NumRegistro, and TipoDoc from entradas
    $stmt = $pdo->prepare("SELECT Id, NumRegistro, TipoDoc FROM entradas ORDER BY NumRegistro DESC");
    $stmt->execute();
    
    // Fetch all results
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Set success to true and add data to the response
    $response['success'] = true;
    $response['message'] = 'Entradas obtenidas correctamente.';
    $response['data'] = $entries;

} catch (PDOException $e) {
    // Catch PDO exceptions (database errors)
    $response['message'] = 'Error de base de datos al obtener entradas: ' . $e->getMessage();
} catch (Exception $e) {
    // Catch any other exceptions
    $response['message'] = 'Error inesperado al obtener entradas: ' . $e->getMessage();
} finally {
    // Always encode the response as JSON
    echo json_encode($response);
}
?>