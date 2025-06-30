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

function clean_input($value) {
    return htmlspecialchars(strip_tags(trim($value)));
}

// CAMBIO DE NOMBRES DE CAMPOS ALINEADOS AL FORMULARIO HTML
$idEntrada       = clean_input($_POST['editId'] ?? '');
$TipoDoc         = clean_input($_POST['editTipoDoc'] ?? '');
$Descripcion     = clean_input($_POST['editDescripcion'] ?? '');
$PalabrasClaves  = clean_input($_POST['editPalabrasClaves'] ?? '');
$FechaFirma      = clean_input($_POST['editFechaFirma'] ?? '');
$Importe         = clean_input($_POST['editImporte'] ?? '');
$Referencia      = clean_input($_POST['editReferencia'] ?? '');
$Procede         = clean_input($_POST['editProcede'] ?? '');
$NombrePersona   = clean_input($_POST['editNombrePersona'] ?? '');
$Institucion     = clean_input($_POST['editInstitucion'] ?? '');
$file            = $_FILES['editArchivo'] ?? null;



$errors = [];

// Validate the ID is present and valid
if (empty($idEntrada) || !ctype_digit($idEntrada)) {
    $errors[] = "ID de entrada inválido o ausente. Necesario para la actualización.";
}

// Validaciones del resto de los campos
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
 
if ($Procede === 'pf' && empty($NombrePersona)) {
    $errors[] = "Debe indicar el nombre completo.";
}
if ($Procede === 'pj' && empty($Institucion)) {
    $errors[] = "Debe seleccionar una institución.";
}

$Usuario         = $_SESSION['usuario']['id'] ?? null;

// If there are initial validation errors, stop execution
if (!empty($errors)) {
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// Fetch current file path to handle updates or deletions
$oldFilePath = null;
try {
    $stmt = $pdo->prepare("SELECT Archivo, NumRegistro FROM entradas WHERE id = ?");
    $stmt->execute([$idEntrada]);
    $entryData = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$entryData) {
        $errors[] = "No se encontró la entrada con el ID proporcionado.";
    } else {
        $oldFilePath = $entryData['Archivo'];
        $numRegistroResponse = $entryData['NumRegistro']; // Keep existing NumRegistro
    }
} catch (PDOException $e) {
    error_log("Error al obtener la ruta del archivo existente o NumRegistro: " . $e->getMessage());
    $errors[] = "Error al verificar la entrada existente.";
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// File upload handling for updates
$uploadedFilePath = $oldFilePath; // Default to the old path if no new file is uploaded
if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/entradas/';
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

    $mime = mime_content_type($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($mime, $allowedTypes)) {
        $errors[] = "Tipo de archivo no permitido. Solo PDF, JPG, PNG.";
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

// Update database
try {
    $pdo->beginTransaction();

    // Update 'entradas' table
    $stmt = $pdo->prepare("
        UPDATE entradas SET
        TipoDoc = :tipoDoc,
        Archivo = :archivo,
        Descripcion = :descripcion,
        PalabrasClaves = :palabrasClaves,
        FechaFirma = :fechaFirma,
        Importe = :importe,
        Referencia = :referencia,
        Usuario = :usuario
        WHERE id = :idEntrada
    ");

    $stmt->execute([
        ':tipoDoc'          => $TipoDoc,
        ':archivo'          => $uploadedFilePath,
        ':descripcion'      => $Descripcion,
        ':palabrasClaves'   => $PalabrasClaves,
        ':fechaFirma'       => $FechaFirma ?: null,
        ':importe'          => $Importe ?: null,
        ':referencia'       => $Referencia ?: null,
        ':usuario'          => $Usuario,
        ':idEntrada'        => $idEntrada
    ]);

    // Handle related tables (personafisica, proviene) for updates
    // Delete existing related records for this entry first
    $pdo->prepare("DELETE FROM personafisica WHERE Entrada = ?")->execute([$idEntrada]);
    $pdo->prepare("DELETE FROM proviene WHERE Entrada = ?")->execute([$idEntrada]);

    // Insert new related record based on 'Procede'
    if ($Procede === 'pf') {
        $stmtPF = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Entrada) VALUES (?, ?)");
        $stmtPF->execute([$NombrePersona, $idEntrada]);
    } elseif ($Procede === 'pj') {
        $stmtPJ = $pdo->prepare("INSERT INTO proviene (Entrada, Seccion) VALUES (?, ?)");
        $stmtPJ->execute([$idEntrada, $Institucion]);
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Entrada actualizada correctamente.',
        'id' => $idEntrada,
        'numRegistro' => $numRegistroResponse // Return the existing NumRegistro
    ]);

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error en la base de datos durante la actualización: " . $e->getMessage());
    echo json_encode(['success' => false, 'messages' => ['Error al actualizar en la base de datos.']]);
}
?>