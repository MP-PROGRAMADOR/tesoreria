<?php
// Activar logs solo en desarrollo
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once('../config/conexion.php');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

global $pdo;

$response = ['success' => false, 'message' => ''];

try {
    // --- Validación base ---
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception("Conexión a la base de datos no disponible.");
    }

    $Usuario = $_SESSION['usuario']['id'] ?? null;
    if (!$Usuario || !is_numeric($Usuario)) {
        throw new Exception("Sesión inválida o usuario no autenticado.");
    }

    // Sanitizar y validar campos obligatorios
    $tipoDoc = trim($_POST['TipoDoc'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $fechaFirma = $_POST['fechaFirma'] ?? null;
    $importe = $_POST['importe'] ?? null;
    $palabrasClaves = trim($_POST['palabrasClaves'] ?? '');
    $ref = $_POST['ref'] ?? null;
    $destinoTipo = $_POST['destinoTipo'] ?? '';
    $personaFisicaNombre = trim($_POST['persFisic'] ?? '');
    $departamentoInstitucion = $_POST['institucion'] ?? null;
    $entradaRelacionada = $_POST['entradaRelacionada'] ?? 'no';
    $numEntradaRelacionada = $_POST['selEntrada'] ?? null;

    if (!$tipoDoc || !$descripcion) {
        throw new Exception("Faltan campos obligatorios (Tipo de documento o Descripción).");
    }

    $pdo->beginTransaction();

    // Generar número de registro
    $stmt = $pdo->prepare("SELECT MAX(NumRegistro) AS last_reg FROM salidas WHERE NumRegistro LIKE 'SL-%'");
    $stmt->execute();
    $lastReg = $stmt->fetchColumn();

    $year = date('Y');
    $newNum = 1;
    if ($lastReg && preg_match('/SL-(\d{4})-(\d+)/', $lastReg, $matches)) {
        $lastYear = (int)$matches[1];
        $lastNum = (int)$matches[2];
        if ($lastYear == $year) {
            $newNum = $lastNum + 1;
        }
    }
    $newNumRegistro = "SL-$year-" . str_pad($newNum, 3, '0', STR_PAD_LEFT);

    // Subida de archivo
    $nombreArchivo = null;
    if (!empty($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            throw new Exception("Solo se aceptan archivos PDF.");
        }

        $uploadDir = 'uploads/salidas/';
        if (!is_dir($uploadDir) && !mkdir($uploadDir, 0777, true)) {
            throw new Exception("No se pudo crear el directorio de subida.");
        }

        if (!is_writable($uploadDir)) {
            throw new Exception("El directorio de subida no es escribible.");
        }

        $safeName = substr($newNumRegistro, 0, 7) . '_' . md5(uniqid($fileName, true)) . '.' . $ext;
        $destPath = $uploadDir . $safeName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            throw new Exception("Error al mover el archivo subido.");
        }

        $nombreArchivo = $safeName;
    }

    // Insertar en salidas
    $stmt = $pdo->prepare("INSERT INTO salidas (NumRegistro, FechaRegistro, TipoDoc, Descripcion, PalabrasClaves, FechaFirma, Importe, Entrada, Referencia, Archivo, Usuario)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $newNumRegistro,
        date('Y-m-d'),
        $tipoDoc,
        $descripcion,
        $palabrasClaves,
        $fechaFirma ?: null,
        $importe ?: null,
        ($entradaRelacionada === 'si') ? $numEntradaRelacionada : null,
        $ref ?: null,
        $nombreArchivo,
        $Usuario
    ]);

    $salidaId = $pdo->lastInsertId();

    // Destinos
    if ($destinoTipo === 'pf' && $personaFisicaNombre) {
        $stmt = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Salida) VALUES (?, ?)");
        $stmt->execute([$personaFisicaNombre, $salidaId]);
    } elseif ($destinoTipo === 'pj' && $departamentoInstitucion) {
        $stmt = $pdo->prepare("INSERT INTO ir (Salida, Seccion) VALUES (?, ?)");
        $stmt->execute([$salidaId, $departamentoInstitucion]);
    } elseif ($destinoTipo === 'vpj' && isset($_POST['instiDepart']) && is_array($_POST['instiDepart'])) {
        $stmt = $pdo->prepare("INSERT INTO ir (Salida, Seccion) VALUES (?, ?)");
        foreach ($_POST['instiDepart'] as $deptId) {
            if (is_numeric($deptId)) {
                $stmt->execute([$salidaId, $deptId]);
            }
        }
    }

    $pdo->commit();

    $response['success'] = true;
    $response['message'] = "Salida registrada correctamente con Nº $newNumRegistro";
    $response['newNumRegistro'] = $newNumRegistro;

} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    error_log("[PDO ERROR] " . $e->getMessage());

    if (isset($destPath) && file_exists($destPath)) {
        unlink($destPath);
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $response['message'] = 'Error general: ' . $e->getMessage();
    error_log("[GENERAL ERROR] " . $e->getMessage());

    if (isset($destPath) && file_exists($destPath)) {
        unlink($destPath);
    }
} finally {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>
