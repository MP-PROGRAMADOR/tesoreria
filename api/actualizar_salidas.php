<?php
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
    if (!isset($pdo) || !$pdo instanceof PDO) {
        throw new Exception("Conexión no disponible.");
    }

    $Usuario = $_SESSION['usuario']['id'] ?? null;
    if (!$Usuario || !is_numeric($Usuario)) {
        throw new Exception("Usuario no autenticado o inválido.");
    }

    // Validar ID de la salida
    $salidaId = $_POST['id'] ?? null;
    if (!$salidaId || !is_numeric($salidaId)) {
        throw new Exception("ID de salida no válido.");
    }

    // Campos del formulario
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

    // Validación básica
    if (!$tipoDoc || !$descripcion) {
        throw new Exception("Tipo de documento y descripción son obligatorios.");
    }

    $pdo->beginTransaction();

    // Verificar si existe la salida
    $stmt = $pdo->prepare("SELECT Archivo FROM salidas WHERE Id = ?");
    $stmt->execute([$salidaId]);
    $salida = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$salida) {
        throw new Exception("Salida no encontrada.");
    }

    $nombreArchivo = $salida['Archivo'];
    $destPath = null;

    // Subida de nuevo archivo si aplica
    if (!empty($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($ext !== 'pdf') {
            throw new Exception("Solo se permiten archivos PDF.");
        }

        $uploadDir = 'uploads/salidas/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (!is_writable($uploadDir)) {
            throw new Exception("Directorio de subida no escribible.");
        }

        $safeName = 'edit_' . md5(uniqid($fileName, true)) . '.' . $ext;
        $destPath = $uploadDir . $safeName;

        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            throw new Exception("Error al mover el archivo subido.");
        }

        // Eliminar el archivo anterior si existía
        if ($nombreArchivo && file_exists($uploadDir . $nombreArchivo)) {
            unlink($uploadDir . $nombreArchivo);
        }

        $nombreArchivo = $safeName;
    }

    // Actualizar salida
    $stmt = $pdo->prepare("UPDATE salidas SET
        TipoDoc = ?, Descripcion = ?, PalabrasClaves = ?, FechaFirma = ?, Importe = ?, Entrada = ?, Referencia = ?, Archivo = ?, Usuario = ?
        WHERE Id = ?");
    $stmt->execute([
        $tipoDoc,
        $descripcion,
        $palabrasClaves,
        $fechaFirma ?: null,
        $importe ?: null,
        ($entradaRelacionada === 'si') ? $numEntradaRelacionada : null,
        $ref ?: null,
        $nombreArchivo,
        $Usuario,
        $salidaId
    ]);

    // Limpiar datos previos
    $pdo->prepare("DELETE FROM personafisica WHERE Salida = ?")->execute([$salidaId]);
    $pdo->prepare("DELETE FROM ir WHERE Salida = ?")->execute([$salidaId]);

    // Insertar nuevos destinos
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
    $response['message'] = 'Salida actualizada correctamente.';

} catch (PDOException $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    error_log("PDO ERROR: " . $e->getMessage());

    if (isset($destPath) && file_exists($destPath)) {
        unlink($destPath);
    }
} catch (Exception $e) {
    if ($pdo->inTransaction()) $pdo->rollBack();
    $response['message'] = 'Error general: ' . $e->getMessage();
    error_log("GENERAL ERROR: " . $e->getMessage());

    if (isset($destPath) && file_exists($destPath)) {
        unlink($destPath);
    }
} finally {
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
}
?>
