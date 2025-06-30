<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => ''];

try {
    $pdo->beginTransaction();

    $decretoId = $_POST['id'] ?? null;
    if (!$decretoId) {
        throw new Exception("ID de decreto no proporcionado para la actualización.");
    }

    $descripcion = $_POST['descripcion'] ?? '';
    // La fecha no se actualiza en este esquema, si quieres actualizarla, añade un campo de fecha en el form.
    $docEntrada = $_POST['entradaDoc'] ?? null;
    $procede = $_POST['procede'] ?? ''; // Valor del radio button: 'pf', 'pj', 'vpj'
    $personaFisicaNombre = $_POST['persFisic'] ?? null;
    $miembrosSeleccionados = isset($_POST['miembro']) && is_array($_POST['miembro']) ? $_POST['miembro'] : [];

    // Obtener el nombre del archivo actual antes de una posible subida nueva
    $stmt = $pdo->prepare("SELECT Archivo FROM decretos WHERE Id = ?");
    $stmt->execute([$decretoId]);
    $currentFileName = $stmt->fetchColumn();
    $stmt->closeCursor();

    $nombreArchivo = $currentFileName; // Mantener el nombre actual por defecto

    // Manejar la subida de un nuevo archivo PDF si se proporciona
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['archivo']['tmp_name'];
        $fileName = $_FILES['archivo']['name'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedfileExtensions = array('pdf');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = 'uploads/decretos/';
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // Eliminar el archivo antiguo si existe
            if ($currentFileName && file_exists($uploadFileDir . $currentFileName)) {
                unlink($uploadFileDir . $currentFileName);
            }

            // Generar un nuevo nombre de archivo único
            $newFileName = 'DECRETO_' . uniqid() . '_' . md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $nombreArchivo = $newFileName; // Almacenar el nuevo nombre de archivo
            } else {
                throw new Exception('Hubo un error moviendo el nuevo archivo subido.');
            }
        } else {
            throw new Exception('Tipo de archivo no permitido. Solo se aceptan PDFs.');
        }
    } else if (isset($_POST['remove_current_file']) && $_POST['remove_current_file'] === 'true') {
        // Lógica para eliminar el archivo existente sin subir uno nuevo
        $uploadFileDir = 'uploads/decretos/';
        if ($currentFileName && file_exists($uploadFileDir . $currentFileName)) {
            unlink($uploadFileDir . $currentFileName);
            $nombreArchivo = null; // Establecer a NULL en la DB
        }
    }


    // Actualizar la tabla 'decretos'
    $stmt = $pdo->prepare("UPDATE decretos SET Descripcion = ?, Archivo = ?, DocEntrada = ? WHERE Id = ?");
    $stmt->execute([
        $descripcion,
        $nombreArchivo,
        $docEntrada,
        $decretoId
    ]);
    $stmt->closeCursor();

    // --- Actualizar la lógica de destino ---
    // Primero, eliminar los destinos existentes para este decreto
    $stmt = $pdo->prepare("DELETE FROM personafisica WHERE Decreto = ?");
    $stmt->execute([$decretoId]);
    $stmt->closeCursor();

    $stmt = $pdo->prepare("DELETE FROM destino WHERE Decreto = ?");
    $stmt->execute([$decretoId]);
    $stmt->closeCursor();

    // Luego, insertar los nuevos destinos según el tipo
    if ($procede === 'pf') {
        if ($personaFisicaNombre) {
            $stmt = $pdo->prepare("INSERT INTO personafisica (NombreCompleto, Decreto) VALUES (?, ?)");
            $stmt->execute([$personaFisicaNombre, $decretoId]);
            $stmt->closeCursor();
        }
    } elseif ($procede === 'pj') {
        if (!empty($miembrosSeleccionados)) {
            $stmt = $pdo->prepare("INSERT INTO destino (Miembro, Decreto) VALUES (?, ?)");
            foreach ($miembrosSeleccionados as $miembroId) {
                $stmt->execute([$miembroId, $decretoId]);
            }
            $stmt->closeCursor();
        }
    } elseif ($procede === 'vpj') {
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
    $response['message'] = 'Decreto actualizado correctamente.';

} catch (PDOException $e) {
    $pdo->rollBack();
    $response['message'] = 'Error de base de datos al actualizar el decreto: ' . $e->getMessage();
    if (isset($newFileName) && isset($dest_path) && file_exists($dest_path)) {
        unlink($dest_path); // Limpia el archivo recién subido si falla la DB
    }
} catch (Exception $e) {
    $pdo->rollBack();
    $response['message'] = 'Error inesperado al actualizar el decreto: ' . $e->getMessage();
    if (isset($newFileName) && isset($dest_path) && file_exists($dest_path)) {
        unlink($dest_path); // Limpia el archivo recién subido si falla el script
    }
} finally {
    echo json_encode($response);
}
?>