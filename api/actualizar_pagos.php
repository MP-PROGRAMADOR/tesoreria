<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../../config/conexion.php'); // Adjust path as needed
header('Content-Type: application/json');

$response = ['success' => false, 'messages' => []];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'messages' => ['Método no permitido.']]);
    exit;
}

function clean_input($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

// Data collection and sanitation
$idPago         = clean_input($_POST['id'] ?? ''); // Hidden input 'id'
$concepto       = clean_input($_POST['concepto'] ?? '');
$beneficiario   = clean_input($_POST['beneficiario'] ?? '');
$bancoId        = clean_input($_POST['banco'] ?? '');
$cantidad       = clean_input($_POST['cantidad'] ?? '');
$fechaFirma     = clean_input($_POST['fechaFirma'] ?? '');
$descripcion    = $_POST['descripcion'] ?? ''; // CKEditor content
$file           = $_FILES['archivo'] ?? null;
$removeCurrentFile = isset($_POST['remove_current_file']) && $_POST['remove_current_file'] === 'true';

$usuarioId      = $_SESSION['usuario']['id'] ?? null;

$errors = [];

// Validations
if (empty($idPago) || !ctype_digit($idPago)) { $errors[] = "ID de pago inválido o ausente. Necesario para la actualización."; }
if (empty($concepto)) { $errors[] = "El concepto es obligatorio."; }
if (empty($beneficiario)) { $errors[] = "El beneficiario es obligatorio."; }
if (empty($bancoId) || !ctype_digit($bancoId)) { $errors[] = "Seleccione un banco válido."; }
if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) { $errors[] = "La cantidad debe ser un número positivo."; }
if (empty($fechaFirma) || !DateTime::createFromFormat('Y-m-d', $fechaFirma)) { $errors[] = "La fecha de firma es obligatoria y debe ser válida (YYYY-MM-DD)."; }
if (empty($descripcion)) { $errors[] = "La descripción es obligatoria."; }

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

$oldFilePath = null;
$pagoNumRegistro = null; // To keep the existing NumRegistro
try {
    $stmt = $pdo->prepare("SELECT Archivo, NumRegistro FROM pagos WHERE Id = ?");
    $stmt->execute([$idPago]);
    $pagoData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pagoData) {
        $oldFilePath = $pagoData['Archivo'];
        $pagoNumRegistro = $pagoData['NumRegistro'];
    } else {
        $errors[] = "No se encontró el pago con el ID proporcionado.";
    }
} catch (PDOException $e) {
    error_log("Error al obtener datos del pago existente para actualización: " . $e->getMessage());
    $errors[] = "Error al verificar el pago existente.";
}

if (!empty($errors)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

$uploadedFilePath = $oldFilePath;

// Handle file changes
if ($removeCurrentFile) {
    // If checkbox is checked, set file path to null and delete old file
    if ($oldFilePath && file_exists('../' . $oldFilePath)) { // Adjust path relative to script
        unlink('../' . $oldFilePath);
    }
    $uploadedFilePath = null;
}

if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = '../uploads/pagos/'; // Relative to this script (api/pagos/)
    $allowedTypes = ['application/pdf'];
    $maxSize = 10 * 1024 * 1024; // 10MB

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $mime = mime_content_type($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($mime, $allowedTypes)) {
        $errors[] = "Tipo de archivo no permitido. Solo PDF.";
    }
    if ($file['size'] > $maxSize) {
        $errors[] = "Archivo muy grande (máx. 10MB).";
    }

    if (empty($errors)) {
        $prefix = 'PAG';
        $shortDate = date('ymd');
        $rand = mt_rand(1000, 9999);
        $shortName = "{$prefix}{$shortDate}_{$rand}.{$ext}";

        $destination = $uploadDir . $shortName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            chmod($destination, 0644);
            $uploadedFilePath = 'uploads/pagos/' . $shortName; // Path to save in DB

            // Delete old file if a new one is successfully uploaded and it's different
            if ($oldFilePath && file_exists('../' . $oldFilePath) && ('uploads/pagos/' . $shortName) !== $oldFilePath) {
                unlink('../' . $oldFilePath);
            }
        } else {
            $errors[] = "No se pudo guardar el nuevo archivo adjunto.";
        }
    }
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// Database Update (Transaction)
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        UPDATE pagos SET
            Concepto = :concepto,
            Descripcion = :descripcion,
            FechaFirma = :fechaFirma,
            Cantidad = :cantidad,
            Archivo = :archivo,
            Usuario = :usuario,
            Beneficiario = :beneficiario,
            Banco = :banco
        WHERE Id = :id
    ");
    $stmt->execute([
        ':concepto'     => $concepto,
        ':descripcion'  => $descripcion,
        ':fechaFirma'   => $fechaFirma,
        ':cantidad'     => $cantidad,
        ':archivo'      => $uploadedFilePath,
        ':usuario'      => $usuarioId,
        ':beneficiario' => $beneficiario,
        ':banco'        => $bancoId,
        ':id'           => $idPago
    ]);

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Pago actualizado correctamente.';
    $response['id'] = $idPago;
    $response['numRegistro'] = $pagoNumRegistro; // Return existing NumRegistro

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error de base de datos al actualizar pago: " . $e->getMessage());
    $response['messages'][] = 'Error al actualizar el pago en la base de datos.';
    http_response_code(500);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error inesperado al actualizar pago: " . $e->getMessage());
    $response['messages'][] = 'Error inesperado al procesar la actualización del pago.';
    http_response_code(500);
}

echo json_encode($response);
?>