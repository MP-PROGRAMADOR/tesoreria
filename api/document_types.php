<?php
// api/document_types.php
require '../conexion/conexion.php';

$documentTypes = [];
$totalDocuments = 0;

try {
    // Contar tipos de documentos de entrada
    $result = $conn->query("SELECT TipoDoc, COUNT(Id) as count FROM entradas GROUP BY TipoDoc");
    while ($row = $result->fetch_assoc()) {
        $documentTypes[$row['TipoDoc']] = ($documentTypes[$row['TipoDoc']] ?? 0) + $row['count'];
        $totalDocuments += $row['count'];
    }
    $result->free();

    // Contar tipos de documentos de salida
    $result = $conn->query("SELECT TipoDoc, COUNT(Id) as count FROM salidas GROUP BY TipoDoc");
    while ($row = $result->fetch_assoc()) {
        $documentTypes[$row['TipoDoc']] = ($documentTypes[$row['TipoDoc']] ?? 0) + $row['count'];
        $totalDocuments += $row['count'];
    }
    $result->free();

    // Contar decretos (si los consideras un "tipo" de documento en el resumen)
    $result = $conn->query("SELECT COUNT(Id) as count FROM decretos");
    if ($result && $row = $result->fetch_assoc()) {
        $documentTypes['Decretos'] = ($documentTypes['Decretos'] ?? 0) + $row['count'];
        $totalDocuments += $row['count'];
    }
    $result->free();

    $response = [];
    foreach ($documentTypes as $type => $count) {
        $porcentaje = ($totalDocuments > 0) ? round(($count / $totalDocuments) * 100) : 0;
        $response[] = [
            'tipo' => htmlspecialchars($type),
            'cantidad' => $count,
            'porcentaje' => $porcentaje
        ];
    }

    // Opcional: ordenar por cantidad o porcentaje si lo deseas
    usort($response, function($a, $b) {
        return $b['cantidad'] - $a['cantidad'];
    });

    echo json_encode($response);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error al obtener tipos de documentos: " . $e->getMessage()]);
} finally {
    $conn->close();
}
?>