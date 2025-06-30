<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que la ruta es correcta

global $pdo;

$response = ['success' => false, 'message' => '', 'data' => []];

try {
    $query = "
        SELECT
            d.Id AS CodDpto,
            d.Nombre AS NomDpto,
            i.Nombre_Corto AS NomInsti
        FROM
            departementos d
        INNER JOIN
            instituciones i ON d.Institucion = i.Id
        ORDER BY i.Nombre ASC, d.Nombre ASC;
    ";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $response['data'] = $stmt->fetchAll();
    $response['success'] = true;
    $stmt->closeCursor();
} catch (PDOException $e) {
    $response['message'] = "Error al obtener instituciones y departamentos: " . $e->getMessage();
} finally {
    echo json_encode($response);
}
?>