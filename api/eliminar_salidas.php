<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => ''];

$salidaId = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $salidaId = (int)$_POST['id'];
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $salidaId = (int)($_DELETE['id'] ?? null);
}

if (!$salidaId) {
    $response['message'] = 'ID de salida no proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $pdo->beginTransaction();

    // Get filename to delete
    $stmt = $pdo->prepare("SELECT Archivo FROM salidas WHERE Id = ?");
    $stmt->execute([$salidaId]);
    $fileNameToDelete = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Delete from 'personafisica' (if linked)
    $stmt = $pdo->prepare("DELETE FROM personafisica WHERE Salida = ?");
    $stmt->execute([$salidaId]);
    $stmt->closeCursor();

    // Delete from 'ir' (if linked)
    $stmt = $pdo->prepare("DELETE FROM ir WHERE Salida = ?");
    $stmt->execute([$salidaId]);
    $stmt->closeCursor();

    // Delete from 'salidas' table
    $stmt = $pdo->prepare("DELETE FROM salidas WHERE Id = ?");
    $stmt->execute([$salidaId]);
    $stmt->closeCursor();

    // If deletion was successful, remove the physical file
    if ($fileNameToDelete && file_exists('../uploads/salidas/' . $fileNameToDelete)) { // Ruta relativa a `api/`
        unlink('../uploads/salidas/' . $fileNameToDelete);
    }

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Salida eliminada correctamente.';

} catch (PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error de base de datos al eliminar la salida: ' . $e->getMessage();
} catch (Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error inesperado al eliminar la salida: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>