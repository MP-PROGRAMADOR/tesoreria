<?php
// api/recent_activity.php
require '../conexion/conexion.php';

$activities = [];

try {
    // Obtener las últimas 5 entradas
    $stmt = $conn->prepare("SELECT e.NumRegistro, e.Descripcion, e.FechaRegistro, u.Nombre as UsuarioNombre
                           FROM entradas e
                           LEFT JOIN usuarios u ON e.Usuario = u.Id
                           ORDER BY e.FechaRegistro DESC LIMIT 2");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'tipo' => 'Documento de Entrada',
            'descripcion' => 'Registro de entrada: ' . htmlspecialchars($row['Descripcion']) . ' (# ' . htmlspecialchars($row['NumRegistro']) . ')',
            'fecha' => htmlspecialchars($row['FechaRegistro']),
            'usuario' => htmlspecialchars($row['UsuarioNombre'] ?: 'Desconocido'),
            'icon' => 'fas fa-file-alt',
            'color' => 'primary'
        ];
    }
    $stmt->close();

    // Obtener las últimas 5 salidas
    $stmt = $conn->prepare("SELECT s.NumRegistro, s.Descripcion, s.FechaRegistro, u.Nombre as UsuarioNombre
                           FROM salidas s
                           LEFT JOIN usuarios u ON s.Usuario = u.Id
                           ORDER BY s.FechaRegistro DESC LIMIT 2");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'tipo' => 'Documento de Salida',
            'descripcion' => 'Registro de salida: ' . htmlspecialchars($row['Descripcion']) . ' (# ' . htmlspecialchars($row['NumRegistro']) . ')',
            'fecha' => htmlspecialchars($row['FechaRegistro']),
            'usuario' => htmlspecialchars($row['UsuarioNombre'] ?: 'Desconocido'),
            'icon' => 'fas fa-paper-plane',
            'color' => 'info'
        ];
    }
    $stmt->close();

    // Obtener los últimos 3 pagos
    $stmt = $conn->prepare("SELECT p.NumRegistro, p.Concepto, p.FechaFirma, u.Nombre as UsuarioNombre
                           FROM pagos p
                           LEFT JOIN usuarios u ON p.Usuario = u.Id
                           ORDER BY p.FechaFirma DESC LIMIT 1");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $activities[] = [
            'tipo' => 'Pago',
            'descripcion' => 'Pago por: ' . htmlspecialchars($row['Concepto']) . ' (# ' . htmlspecialchars($row['NumRegistro']) . ')',
            'fecha' => htmlspecialchars($row['FechaFirma']),
            'usuario' => htmlspecialchars($row['UsuarioNombre'] ?: 'Desconocido'),
            'icon' => 'fas fa-credit-card',
            'color' => 'success'
        ];
    }
    $stmt->close();

    // Ordenar actividades por fecha de forma descendente
    usort($activities, function($a, $b) {
        return strtotime($b['fecha']) - strtotime($a['fecha']);
    });

    // Limitar a, por ejemplo, las últimas 5 actividades en total
    $activities = array_slice($activities, 0, 5);

    echo json_encode($activities);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["message" => "Error al obtener actividad reciente: " . $e->getMessage()]);
} finally {
    $conn->close();
}
?>