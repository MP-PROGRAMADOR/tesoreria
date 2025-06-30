<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => '', 'data' => null];

$decretoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$decretoId) {
    $response['message'] = 'ID de decreto no proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $query = "
        SELECT
            d.Id,
            d.Descripcion,
            DATE_FORMAT(d.Fecha, '%Y-%m-%d') AS Fecha,
            d.Archivo AS NombreArchivo,
            d.DocEntrada,
            pf.NombreCompleto AS PersonaFisicaDestino,
            GROUP_CONCAT(DISTINCT m.Id) AS MiembrosDestinoIds
        FROM
            decretos d
        LEFT JOIN
            personafisica pf ON d.Id = pf.Decreto
        LEFT JOIN
            destino dt ON d.Id = dt.Decreto
        LEFT JOIN
            miembros m ON dt.Miembro = m.Id
        WHERE
            d.Id = :decretoId
        GROUP BY d.Id;
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':decretoId', $decretoId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();

    if ($data) {
        // Determinar el tipo de destino para la lógica del frontend
        if ($data['PersonaFisicaDestino'] && $data['MiembrosDestinoIds']) {
            $data['DestinoTipo'] = 'vpj'; // Varios miembros y Persona Física
            $data['MiembrosDestinoIds'] = explode(',', $data['MiembrosDestinoIds']); // Convertir a array
        } elseif ($data['PersonaFisicaDestino']) {
            $data['DestinoTipo'] = 'pf'; // Solo Persona Física
            $data['MiembrosDestinoIds'] = []; // Asegurar que sea un array vacío
        } elseif ($data['MiembrosDestinoIds']) {
            $data['DestinoTipo'] = 'pj'; // Solo Miembros
            $data['MiembrosDestinoIds'] = explode(',', $data['MiembrosDestinoIds']); // Convertir a array
        } else {
            $data['DestinoTipo'] = 'none'; // Ninguno
            $data['MiembrosDestinoIds'] = []; // Asegurar que sea un array vacío
        }

        $response['data'] = $data;
        $response['success'] = true;
    } else {
        $response['message'] = 'Decreto no encontrado.';
    }
    $stmt->closeCursor();

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener los detalles del decreto: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>