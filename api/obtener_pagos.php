<?php
header('Content-Type: application/json');
require_once('../../config/conexion.php'); // Adjust path as needed

$response = ['success' => false, 'message' => '', 'data' => null];

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
    exit;
}

$pagoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($pagoId <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'ID de pago inválido o ausente.']);
    exit;
}

try {
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception('Conexión a la base de datos no disponible.');
    }

    $stmt = $pdo->prepare("
        SELECT
            p.Id,
            p.NumRegistro,
            p.Concepto,
            p.Descripcion,
            p.FechaFirma,
            p.Cantidad,
            p.Archivo,
            p.Beneficiario,
            p.Banco
        FROM
            pagos p
        WHERE p.Id = ?
    ");
    $stmt->execute([$pagoId]);
    $pago = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pago) {
        $response['success'] = true;
        $response['message'] = 'Pago encontrado.';
        $response['data'] = $pago;
    } else {
        http_response_code(404);
        $response['message'] = 'Pago no encontrado.';
    }

} catch (PDOException $e) {
    http_response_code(500);
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
}

echo json_encode($response);
?>