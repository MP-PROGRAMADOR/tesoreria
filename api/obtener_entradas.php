<?php
header('Content-Type: application/json');
require_once('../config/conexion.php'); // Asegúrate de que esta ruta sea correcta

$response = ['success' => false, 'message' => ''];

try {
    // Consulta SQL para obtener todas las entradas
    // Se realiza un LEFT JOIN con personafisica y instituciones para obtener los nombres si existen.
    // Asumo que 'Referencia' en 'entradas' se relaciona con 'Id' en 'referencias' (que no proporcionaste, pero se asume).
    // Y que 'Entrada' en 'personafisica' se relaciona con 'Id' en 'entradas'.
    // Y 'InstitucionOrigen' (un nuevo campo que podrías necesitar en 'entradas' o en una tabla de relación)
    // se relacionaría con 'Id' en 'instituciones'.
    // Para simplificar, asumiré que 'personafisica.Entrada' y 'proviene.Entrada' pueden darte el origen,
    // pero para un campo directo de origen de institución en 'entradas', podrías necesitar ajustar tu DB o un join más complejo.
    // Por ahora, incluyo un campo 'InstitucionOrigen' en 'entradas' para un manejo más directo si lo agregas.
    // Si no lo tienes, la lógica JS de editEntry para 'procede de' necesitará ajustes para buscar en 'personafisica' o 'proviene'.

    // **** Importante: Si 'NombrePersona' e 'InstitucionOrigen' no están directamente en la tabla 'entradas',
    // necesitas un JOIN más complejo o un campo en 'entradas' que indique el ID de la persona/institución de origen.
    // Basándome en tu esquema, 'personafisica.Entrada' y 'proviene.Entrada' sugieren que el origen
    // se registra en tablas separadas. Mi JS frontend asume que `entry.NombrePersona` y `entry.InstitucionOrigen`
    // pueden venir directamente en el objeto de la entrada. Para que esto funcione, podrías necesitar:
    // 1. Añadir campos `id_persona_fisica` e `id_institucion_origen` a tu tabla `entradas`.
    // 2. O realizar JOINs más complejos para traer `NombreCompleto` y `Nombre` de `instituciones` condicionalmente.
    // A continuación, una consulta que intenta anticipar eso, asumiendo que `entradas` podría tener un `OrigenTipo` y un `OrigenId`.
    // Si no es el caso, esta consulta puede necesitar ser adaptada.

    $stmt = $pdo->prepare("
        SELECT
            e.Id,
            e.NumRegistro,
            e.FechaRegistro,
            e.TipoDoc,
            e.Archivo,
            e.Descripcion,
            e.PalabrasClaves,
            e.FechaFirma,
            e.Importe,
            e.Referencia,
            e.Usuario,
            pf.NombreCompleto AS NombrePersona, -- Nombre de la persona física si aplica
            inst.Nombre AS InstitucionOrigen -- Nombre de la institución si aplica
        FROM
            entradas e
        LEFT JOIN
            personafisica pf ON pf.Entrada = e.Id
        LEFT JOIN
            proviene p ON p.Entrada = e.Id
        LEFT JOIN
            instituciones inst ON inst.Id = p.Seccion -- Esto asume que p.Seccion es el ID de la institución
        ORDER BY
            e.FechaRegistro DESC, e.Id DESC
    ");
    $stmt->execute();
    $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['success'] = true;
    $response['data'] = $entries;

} catch (PDOException $e) {
    $response['message'] = "Error de base de datos al obtener entradas: " . $e->getMessage();
    error_log("Error al obtener entradas: " . $e->getMessage());
} catch (Exception $e) {
    $response['message'] = "Error inesperado: " . $e->getMessage();
    error_log("Error inesperado en obtener_entradas.php: " . $e->getMessage());
}

echo json_encode($response);
?>