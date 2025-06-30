<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => ''];

$decretoId = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $decretoId = (int)$_POST['id'];
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $decretoId = (int)($_DELETE['id'] ?? null);
}

if (!$decretoId) {
    $response['message'] = 'ID de decreto no proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $pdo->beginTransaction();

    // Obtener el nombre del archivo para eliminarlo
    $stmt = $pdo->prepare("SELECT Archivo FROM decretos WHERE Id = ?");
    $stmt->execute([$decretoId]);
    $fileNameToDelete = $stmt->fetchColumn();
    $stmt->closeCursor();

    // Eliminar de 'personafisica' (si está vinculado)
    $stmt = $pdo->prepare("DELETE FROM personafisica WHERE Decreto = ?");
    $stmt->execute([$decretoId]);
    $stmt->closeCursor();

    // Eliminar de 'destino' (si está vinculado)
    $stmt = $pdo->prepare("DELETE FROM destino WHERE Decreto = ?");
    $stmt->execute([$decretoId]);
    $stmt->closeCursor();

    // Eliminar de la tabla 'decretos'
    $stmt = $pdo->prepare("DELETE FROM decretos WHERE Id = ?");
    $stmt->execute([$decretoId]);
    $stmt->closeCursor();

    // Si la eliminación fue exitosa, borrar el archivo físico
    if ($fileNameToDelete && file_exists('uploads/decretos/' . $fileNameToDelete)) {
        unlink('uploads/decretos/' . $fileNameToDelete);
    }

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Decreto eliminado correctamente.';

} catch (PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error de base de datos al eliminar el decreto: ' . $e->getMessage();
} catch (Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error inesperado al eliminar el decreto: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>