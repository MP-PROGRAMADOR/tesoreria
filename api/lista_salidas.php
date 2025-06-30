<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => '', 'data' => null];

$salidaId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$salidaId) {
    $response['message'] = 'ID de salida no proporcionado.';
    echo json_encode($response);
    exit();
}

try {
    $query = "
        SELECT
            s.Id,
            s.NumRegistro,
            DATE_FORMAT(s.FechaRegistro, '%Y-%m-%d') AS FechaRegistro,
            s.TipoDoc,
            s.Descripcion,
            s.PalabrasClaves,
            DATE_FORMAT(s.FechaFirma, '%Y-%m-%d') AS FechaFirma,
            s.Importe,
            s.Referencia,
            s.Entrada AS EntradaRelacionadaNum,
            s.Archivo AS NombreArchivo,
            pf.NombreCompleto AS PersonaFisicaDestino,
            GROUP_CONCAT(DISTINCT ir.Seccion) AS DepartamentosMultiplesIds
        FROM
            salidas s
        LEFT JOIN
            personafisica pf ON s.Id = pf.Salida
        LEFT JOIN
            ir ON s.Id = ir.Salida
        WHERE
            s.Id = :salidaId
        GROUP BY s.Id;
    ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':salidaId', $salidaId, PDO::PARAM_INT);
    $stmt->execute();
    $data = $stmt->fetch();

    if ($data) {
        // Determine DestinoTipo for the frontend logic
        if ($data['PersonaFisicaDestino']) {
            $data['DestinoTipo'] = 'pf';
        } elseif ($data['DepartamentosMultiplesIds']) {
            $departmentCount = count(explode(',', $data['DepartamentosMultiplesIds']));
            if ($departmentCount > 1) {
                $data['DestinoTipo'] = 'vpj';
            } else {
                $data['DestinoTipo'] = 'pj';
                $data['InstitucionDestino'] = $data['DepartamentosMultiplesIds'];
            }
        } else {
            $data['DestinoTipo'] = 'none';
        }

        $data['EntradaRelacionada'] = $data['EntradaRelacionadaNum'] ? 'si' : 'no';

        $response['data'] = $data;
        $response['success'] = true;
    } else {
        $response['message'] = 'Salida no encontrada.';
    }
    $stmt->closeCursor();

} catch (PDOException $e) {
    $response['message'] = 'Error al obtener los detalles de la salida: ' . $e->getMessage();
} catch (Exception $e) {
    $response['message'] = 'Error inesperado: ' . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>