<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('../config/conexion.php');
header('Content-Type: application/json');

$response = ['success' => false, 'messages' => []];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'messages' => ['Método no permitido.']]);
    exit;
}

function generarNumeroRegistro($pdo) {
    $prefijo = 'TGE';
    $fecha = date('Ymd');
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM entradas WHERE DATE(FechaRegistro) = CURDATE()");
    $stmt->execute();
    $conteo = $stmt->fetchColumn();
    $numero = str_pad($conteo + 1, 4, '0', STR_PAD_LEFT);
    return "{$prefijo}-{$fecha}-{$numero}";
}

function clean_input($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

// Datos del formulario
$TipoDoc         = clean_input($_POST['tipoDoc'] ?? '');
$Descripcion     = clean_input($_POST['descripcion'] ?? '');
$PalabrasClaves  = clean_input($_POST['palabrasClaves'] ?? '');
$FechaFirma      = clean_input($_POST['fechaFirma'] ?? '');
$Importe         = clean_input($_POST['importe'] ?? '');
$Referencia      = clean_input($_POST['referencia'] ?? '');
$Procede         = clean_input($_POST['procede'] ?? '');
$NombrePersona   = clean_input($_POST['nombrePersona'] ?? '');
$Institucion     = clean_input($_POST['institucion'] ?? '');
$FechaRegistro   = date('Y-m-d');
$NumRegistro     = generarNumeroRegistro($pdo);
$Usuario         = $_SESSION['usuario']['id'] ?? null;
$file            = $_FILES['archivo'] ?? null;

$errors = [];

// Validaciones
if (empty($TipoDoc) || strlen($TipoDoc) > 50) {
    $errors[] = "Tipo de documento obligatorio y máximo 50 caracteres.";
}
if (empty($Descripcion)) {
    $errors[] = "La descripción es obligatoria.";
}
if (empty($PalabrasClaves)) {
    $errors[] = "Debe incluir al menos una palabra clave.";
}
if (!empty($FechaFirma) && !DateTime::createFromFormat('Y-m-d', $FechaFirma)) {
    $errors[] = "Fecha de firma inválida.";
}
if (!empty($Importe) && !preg_match('/^\d+(\.\d{1,2})?$/', $Importe)) {
    $errors[] = "Importe inválido.";
}
if (!empty($Referencia) && !ctype_digit($Referencia)) {
    $errors[] = "Referencia inválida.";
}
if (!$Usuario || !ctype_digit((string) $Usuario)) {
    $errors[] = "Usuario no autenticado.";
}
if ($Procede === 'pf' && empty($NombrePersona)) {
    $errors[] = "Debe indicar el nombre completo.";
}
if ($Procede === 'pj' && empty($Institucion)) {
    $errors[] = "Debe seleccionar una institución.";
}

// Validación y subida de archivo
$uploadedFilePath = null;
if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/entradas/';
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024;

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $mime = mime_content_type($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($mime, $allowedTypes)) {
        $errors[] = "Archivo no permitido.";
    }
    if ($file['size'] > $maxSize) {
        $errors[] = "Archivo muy grande (máx. 5MB).";
    }

   if (empty($errors)) {
    // Generar nombre corto del archivo: ejemplo ENT240626_4832.pdf
    $prefix = 'ENT';
    $shortDate = date('ymd'); // Ej: 240626
    $rand = mt_rand(1000, 9999); // 4 dígitos aleatorios
    $shortName = "{$prefix}{$shortDate}_{$rand}.{$ext}";

    $destination = $uploadDir . $shortName;

    if (move_uploaded_file($file['tmp_name'], $destination)) {
        chmod($destination, 0644);
        $uploadedFilePath = $destination;

        // Elimina el archivo anterior si se sube uno nuevo
        if ($oldFilePath && file_exists($oldFilePath) && $oldFilePath !== $destination) {
            unlink($oldFilePath);
        }
    } else {
        $errors[] = "No se pudo guardar el nuevo archivo.";
    }
}

}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// Guardar en tabla entradas
try {
    $stmt = $pdo->prepare("
        INSERT INTO entradas 
        (NumRegistro, FechaRegistro, TipoDoc, Archivo, Descripcion, PalabrasClaves, FechaFirma, Importe, Referencia, Usuario)
        VALUES 
        (:numRegistro, :fechaRegistro, :tipoDoc, :archivo, :descripcion, :palabrasClaves, :fechaFirma, :importe, :referencia, :usuario)
    ");

    $stmt->execute([
        ':numRegistro'     => $NumRegistro,
        ':fechaRegistro'   => $FechaRegistro,
        ':tipoDoc'         => $TipoDoc,
        ':archivo'         => $uploadedFilePath,
        ':descripcion'     => $Descripcion,
        ':palabrasClaves'  => $PalabrasClaves,
        ':fechaFirma'      => $FechaFirma ?: null,
        ':importe'         => $Importe ?: null,
        ':referencia'      => $Referencia ?: null,
        ':usuario'         => $Usuario
    ]);

    $idEntrada = $pdo->lastInsertId();

    // Registrar remitente según procedencia
    if ($Procede === 'pf') {
        $stmtPF = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Entrada) VALUES (?, ?)");
        $stmtPF->execute([$NombrePersona, $idEntrada]);
    } elseif ($Procede === 'pj') {
        $stmtPJ = $pdo->prepare("INSERT INTO proviene (Entrada, Seccion) VALUES (?, ?)");
        $stmtPJ->execute([$idEntrada, $Institucion]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Entrada guardada correctamente.',
        'id' => $idEntrada,
        'numRegistro' => $NumRegistro
    ]);
} catch (PDOException $e) {
    error_log("Error en la base de datos: " . $e->getMessage());
    echo json_encode(['success' => false, 'messages' => ['Error al guardar en la base de datos.']]);
}
