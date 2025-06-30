<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

if(session_status() === PHP_SESSION_NONE){
    session_start();
}
global $pdo;

$response = ['success' => false, 'message' => ''];

try {
    $pdo->beginTransaction();

    // No hay un "NumRegistro" en la tabla decretos.
    // Si necesitas un número de registro para decretos, tendrías que añadirlo a la tabla.
    // Por ahora, asumiré que no se necesita un NumRegistro autogenerado como en salidas.
    // Si lo necesitas, el campo 'NumRegistro' debe ser añadido a la tabla 'decretos'.
    // Para fines de ejemplo, asumiremos que no hay un NumRegistro para decretos, solo el ID autoincremental.

    $descripcion = $_POST['descripcion'] ?? '';
    $fecha = date('Y-m-d'); // La fecha de registro será la fecha actual
    $docEntrada = $_POST['entradaDoc'] ?? null;
    $procede = $_POST['procede'] ?? ''; // Valor del radio button: 'pf', 'pj', 'vpj' (asumiendo 'vpj' para el tercer caso)
    $personaFisicaNombre = $_POST['persFisic'] ?? null; // Si procede es 'pf' o 'vpj'
    $miembrosSeleccionados = isset($_POST['miembro']) && is_array($_POST['miembro']) ? $_POST['miembro'] : []; // Si procede es 'pj' o 'vpj'

    // Manejo de la subida de archivos PDF
    $nombreArchivo = null;
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedfileExtensions = array('pdf');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // RUTA DE SUBIDA: uploads/decretos/
            $uploadFileDir = 'uploads/decretos/';
            if (!is_dir($uploadFileDir)) {
                if (!mkdir($uploadFileDir, 0777, true)) {
                    throw new Exception('No se pudo crear el directorio de carga para decretos.');
                }
            }
            // Generar un nombre de archivo único para el decreto
            $newFileName = 'DECRETO_' . uniqid() . '_' . md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $nombreArchivo = $newFileName; // Guarda el nombre completo del archivo
            } else {
                throw new Exception('Hubo un error moviendo el archivo subido.');
            }
        } else {
            throw new Exception('Tipo de archivo no permitido. Solo se aceptan PDFs.');
        }
    }

    // Insertar en la tabla 'decretos'
    $stmt = $pdo->prepare("INSERT INTO decretos (Descripcion, Fecha, Archivo, DocEntrada) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $descripcion,
        $fecha,
        $nombreArchivo,
        $docEntrada
    ]);
    $decretoId = $pdo->lastInsertId();
    $stmt->closeCursor();

    // Manejar el destino del decreto (persona física o miembros)
    if ($procede === 'pf') {
        if ($personaFisicaNombre) {
            $stmt = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Decreto) VALUES (?, ?)");
            $stmt->execute([$personaFisicaNombre, $decretoId]);
            $stmt->closeCursor();
        }
    } elseif ($procede === 'pj') { // Solo miembros
        if (!empty($miembrosSeleccionados)) {
            $stmt = $pdo->prepare("INSERT INTO destino (Miembro, Decreto) VALUES (?, ?)");
            foreach ($miembrosSeleccionados as $miembroId) {
                $stmt->execute([$miembroId, $decretoId]);
            }
            $stmt->closeCursor();
        }
    } elseif ($procede === 'vpj') { // Miembros Y persona física
        if ($personaFisicaNombre) {
            $stmt = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Decreto) VALUES (?, ?)");
            $stmt->execute([$personaFisicaNombre, $decretoId]);
            $stmt->closeCursor();
        }
        if (!empty($miembrosSeleccionados)) {
            $stmt = $pdo->prepare("INSERT INTO destino (Miembro, Decreto) VALUES (?, ?)");
            foreach ($miembrosSeleccionados as $miembroId) {
                $stmt->execute([$miembroId, $decretoId]);
            }
            $stmt->closeCursor();
        }
    }

    $pdo->commit();
    $response['success'] = true;
    $response['message'] = 'Decreto registrado correctamente.';
    $response['decretoId'] = $decretoId;

} catch (PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error de base de datos: ' . $e->getMessage();
    if ($nombreArchivo && isset($dest_path) && file_exists($dest_path)) {
        unlink($dest_path);
    }
} catch (Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error: ' . $e->getMessage();
    if ($nombreArchivo && isset($dest_path) && file_exists($dest_path)) {
        unlink($dest_path);
    }
} finally {
    echo json_encode($response);
}
?>