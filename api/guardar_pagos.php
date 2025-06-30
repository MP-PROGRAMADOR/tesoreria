<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/conexion.php'); // Adjust path as needed
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
$concepto       = clean_input($_POST['concepto'] ?? '');
$beneficiario   = clean_input($_POST['beneficiario'] ?? '');
$bancoId        = clean_input($_POST['banco'] ?? '');
$cantidad       = clean_input($_POST['cantidad'] ?? '');
$fechaFirma     = clean_input($_POST['fechaFirma'] ?? '');
$descripcion    = $_POST['descripcion'] ?? ''; // CKEditor content, usually not trimmed/stripped tags here
$file           = $_FILES['archivo'] ?? null;

$usuarioId      = $_SESSION['usuario']['id'] ?? null;

$errors = [];

// Validations
if (empty($concepto)) { $errors[] = "El concepto es obligatorio."; }
if (empty($beneficiario)) { $errors[] = "El beneficiario es obligatorio."; }
if (empty($bancoId) || !ctype_digit($bancoId)) { $errors[] = "Seleccione un banco válido."; }
if (empty($cantidad) || !is_numeric($cantidad) || $cantidad <= 0) { $errors[] = "La cantidad debe ser un número positivo."; }
if (empty($fechaFirma) || !DateTime::createFromFormat('Y-m-d', $fechaFirma)) { $errors[] = "La fecha de firma es obligatoria y debe ser válida (YYYY-MM-DD)."; }
if (empty($descripcion)) { $errors[] = "La descripción es obligatoria."; }
if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) { $errors[] = "Se requiere adjuntar un archivo PDF para el pago."; }


if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// File Upload Handling
$uploadedFilePath = null;
if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/pagos/'; // Relative to this script (api/pagos/)
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
        // Generate short file name: e.g., PAG240626_4832.pdf
        $prefix = 'PAG';
        $shortDate = date('ymd');
        $rand = mt_rand(1000, 9999);
        $shortName = "{$prefix}{$shortDate}_{$rand}.{$ext}";

        $destination = $uploadDir . $shortName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            chmod($destination, 0644);
            $uploadedFilePath = 'uploads/pagos/' . $shortName; // Path to save in DB, relative to web root or a consistent base
        } else {
            $errors[] = "No se pudo guardar el archivo adjunto.";
        }
    }
} else {
     $errors[] = "Error en la subida del archivo. Código: " . ($file['error'] ?? 'N/A');
}


if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// Generate NumRegistro
$currentYear = date('Y');
$stmtLastNum = $pdo->prepare("SELECT NumRegistro FROM pagos WHERE NumRegistro LIKE ? ORDER BY Id DESC LIMIT 1");
$stmtLastNum->execute(["PA-{$currentYear}-%"]);
$lastNumRegistro = $stmtLastNum->fetchColumn();

$nextSequence = 1;
if ($lastNumRegistro) {
    $parts = explode('-', $lastNumRegistro);
    if (count($parts) === 3 && is_numeric($parts[2])) {
        $nextSequence = (int)$parts[2] + 1;
    }
}
$numRegistro = "PA-{$currentYear}-" . str_pad($nextSequence, 3, '0', STR_PAD_LEFT);


// Database operation (Transaction)
try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO pagos (NumRegistro, Concepto, Descripcion, FechaFirma, Cantidad, Archivo, Usuario, Beneficiario, Banco)
        VALUES (:numRegistro, :concepto, :descripcion, :fechaFirma, :cantidad, :archivo, :usuario, :beneficiario, :banco)
    ");
    $stmt->execute([
        ':numRegistro'  => $numRegistro,
        ':concepto'     => $concepto,
        ':descripcion'  => $descripcion,
        ':fechaFirma'   => $fechaFirma,
        ':cantidad'     => $cantidad,
        ':archivo'      => $uploadedFilePath,
        ':usuario'      => $usuarioId,
        ':beneficiario' => $beneficiario,
        ':banco'        => $bancoId
    ]);

    $pagoId = $pdo->lastInsertId();

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Pago registrado correctamente.';
    $response['id'] = $pagoId;
    $response['numRegistro'] = $numRegistro;

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error de base de datos al crear pago: " . $e->getMessage());
    $response['messages'][] = 'Error al crear el pago en la base de datos.';
    if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
         $response['messages'][] = 'Posiblemente el número de registro ya existe o hay un problema con la clave única.';
    }
    http_response_code(500);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error inesperado al crear pago: " . $e->getMessage());
    $response['messages'][] = 'Error inesperado al procesar la creación del pago.';
    http_response_code(500);
}

echo json_encode($response);
?>