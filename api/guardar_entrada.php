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

// 1. Recolección y saneamiento de datos del formulario para CREACIÓN
$Descripcion    = clean_input($_POST['Descripcion'] ?? '');
$Fecha          = clean_input($_POST['Fecha'] ?? '');
$DocEntrada     = clean_input($_POST['DocEntrada'] ?? ''); // ID de la entrada relacionada
$DestinoTipo    = clean_input($_POST['DestinoTipo'] ?? ''); // 'pf' para Persona Fisica, 'm' para Miembros
$NombrePersona  = clean_input($_POST['NombrePersona'] ?? ''); // Usado si DestinoTipo es 'pf'
$Miembros       = isset($_POST['Miembros']) && is_array($_POST['Miembros']) ? $_POST['Miembros'] : []; // Array de IDs de miembros
$file           = $_FILES['Archivo'] ?? null;

$Usuario        = $_SESSION['usuario']['id'] ?? null; // ID del usuario logueado

$errors = [];

// 2. Validaciones específicas para la CREACIÓN
if (empty($Descripcion)) {
    $errors[] = "La descripción del decreto es obligatoria.";
}
if (empty($Fecha) || !DateTime::createFromFormat('Y-m-d', $Fecha)) {
    $errors[] = "La fecha del decreto es obligatoria y debe tener un formato válido (YYYY-MM-DD).";
}
if (!empty($DocEntrada) && !ctype_digit($DocEntrada)) {
    $errors[] = "El ID del documento de entrada es inválido.";
}

// Validar el tipo de destino y sus campos asociados
if ($DestinoTipo === 'pf' && empty($NombrePersona)) {
    $errors[] = "Debe especificar el nombre de la persona física de destino.";
} elseif ($DestinoTipo === 'm' && empty($Miembros)) {
    $errors[] = "Debe seleccionar al menos un miembro de destino.";
} elseif ($DestinoTipo !== 'pf' && $DestinoTipo !== 'm') {
    $errors[] = "Tipo de destino inválido. Debe ser 'pf' (Persona Física) o 'm' (Miembro/s).";
}

// Para la creación, podrías querer que el archivo sea obligatorio
if (!$file || $file['error'] === UPLOAD_ERR_NO_FILE) {
    $errors[] = "Se requiere un archivo adjunto para un nuevo decreto.";
}

// Verificar si hay errores de validación iniciales
if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// 3. Manejo de archivos adjuntos para CREACIÓN
$uploadedFilePath = null;
if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/decretos/';
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $mime = mime_content_type($file['tmp_name']);
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($mime, $allowedTypes)) {
        $errors[] = "Tipo de archivo no permitido. Solo PDF, JPG, PNG.";
    }
    if ($file['size'] > $maxSize) {
        $errors[] = "Archivo muy grande (máx. 5MB).";
    }

    if (empty($errors)) {
        $prefix = 'DEC';
        $shortDate = date('ymd');
        $rand = mt_rand(1000, 9999);
        $shortName = "{$prefix}{$shortDate}_{$rand}.{$ext}";

        $destination = $uploadDir . $shortName;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            chmod($destination, 0644);
            $uploadedFilePath = $destination;
        } else {
            $errors[] = "No se pudo guardar el archivo adjunto.";
        }
    }
}

if (!empty($errors)) {
    http_response_code(400); // Bad Request
    echo json_encode(['success' => false, 'messages' => $errors]);
    exit;
}

// 4. Inserción en la base de datos (Transacción)
try {
    $pdo->beginTransaction();

    // Insertar en la tabla 'decretos'
    $stmt = $pdo->prepare("
        INSERT INTO decretos (Descripcion, Fecha, Archivo, DocEntrada, Usuario)
        VALUES (:descripcion, :fecha, :archivo, :docEntrada, :usuario)
    ");
    $stmt->execute([
        ':descripcion' => $Descripcion,
        ':fecha'       => $Fecha,
        ':archivo'     => $uploadedFilePath,
        ':docEntrada'  => $DocEntrada ?: null,
        ':usuario'     => $Usuario
    ]);
    $decretoId = $pdo->lastInsertId(); // Obtener el ID del nuevo decreto

    // 5. Manejo de tablas relacionadas (personafisica, destino)
    if ($decretoId) {
        if ($DestinoTipo === 'pf') {
            $stmtPF = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Decreto) VALUES (?, ?)");
            $stmtPF->execute([$NombrePersona, $decretoId]);
        } elseif ($DestinoTipo === 'm' && !empty($Miembros)) {
            $stmtDestino = $pdo->prepare("INSERT INTO destino (Decreto, Miembro) VALUES (?, ?)");
            foreach ($Miembros as $miembroId) {
                if (ctype_digit((string)$miembroId)) {
                    $stmtDestino->execute([$decretoId, (int)$miembroId]);
                }
            }
        }
    }

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Decreto creado correctamente.';
    $response['id'] = $decretoId;

} catch (PDOException $e) {
    $pdo->rollBack();
    error_log("Error de base de datos al crear decreto: " . $e->getMessage());
    $response['messages'][] = 'Error al crear el decreto en la base de datos.';
    http_response_code(500);
} catch (Exception $e) {
    $pdo->rollBack();
    error_log("Error inesperado al crear decreto: " . $e->getMessage());
    $response['messages'][] = 'Error inesperado al procesar la creación del decreto.';
    http_response_code(500);
}

echo json_encode($response);
?>