<?php
// Set content type to JSON
header('Content-Type: application/json');
// Include your database connection
require_once('../config/conexion.php'); // Adjust path if necessary

global $pdo; // Assuming $pdo is your PDO connection object

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    // Prepare and execute the SQL query to select all members
    $stmt = $pdo->prepare("SELECT Id, Nombre FROM miembros ORDER BY Nombre ASC");
    $stmt->execute();
    
    // Fetch all results
    $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Set success to true and add data to the response
    $response['success'] = true;
    $response['message'] = 'Miembros obtenidos correctamente.';
    $response['data'] = $members;

} catch (PDOException $e) {
    // Catch PDO exceptions (database errors)
    $response['message'] = 'Error de base de datos al obtener miembros: ' . $e->getMessage();
} catch (Exception $e) {
    // Catch any other exceptions
    $response['message'] = 'Error inesperado al obtener miembros: ' . $e->getMessage();
} finally {
    // Always encode the response as JSON
    echo json_encode($response);
}
?>