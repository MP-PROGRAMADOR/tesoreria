<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/conexion.php'); // Adjust path as needed
header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$pagoId = isset($data['id']) ? (int)$data['id'] : 0;

if ($pagoId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de pago inválido o ausente.']);
    exit;
}

try {
    $pdo->beginTransaction();

    // First, get the file path to delete it
    $stmt = $pdo->prepare("SELECT Archivo FROM pagos WHERE Id = ?");
    $stmt->execute([$pagoId]);
    $filePath = $stmt->fetchColumn();

    // Delete the record from the database
    $stmt = $pdo->prepare("DELETE FROM pagos WHERE Id = ?");
    $stmt->execute([$pagoId]);

    if ($stmt->rowCount() > 0) {
        // If the database record was deleted, try to delete the file
        if ($filePath && file_exists('../' . $filePath)) { // Adjust path relative to script
            unlink('../' . $filePath);
        }
        $pdo->commit();
        $response['success'] = true;
        $response['message'] = 'Pago eliminado correctamente.';
    } else {
        $pdo->rollBack();
        http_response_code(404);
        $response['message'] = 'Pago no encontrado para eliminar.';
    }

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error de base de datos al eliminar pago: " . $e->getMessage());
    $response['message'] = 'Error al eliminar el pago de la base de datos: ' . $e->getMessage();
    http_response_code(500);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error inesperado al eliminar pago: " . $e->getMessage());
    $response['message'] = 'Error inesperado al eliminar el pago: ' . $e->getMessage();
    http_response_code(500);
}

echo json_encode($response);
?>