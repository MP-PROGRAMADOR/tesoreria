<?php
// api/config.php

// Constantes de la base de datos
// ¡¡¡IMPORTANTE!!! CAMBIA ESTOS VALORES POR LOS DE TU BASE DE DATOS REAL
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // Por ejemplo: 'root'
define('DB_PASS', ''); // Por ejemplo: '' (vacío si no tienes contraseña)
define('DB_NAME', 'tesoreria');   // Por ejemplo: 'sistema_gestion_documental'

/**
 * Establece las cabeceras HTTP necesarias para las respuestas JSON y CORS.
 * Permite que tu frontend (servido desde un dominio diferente, si es el caso)
 * pueda comunicarse con estos scripts PHP.
 */
function setApiHeaders() {
    header("Access-Control-Allow-Origin: *"); // Permite cualquier origen. En producción, especifica tus dominios.
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    // Manejar las solicitudes OPTIONS para pre-vuelo CORS
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }
}

/**
 * Establece la conexión a la base de datos MySQLi.
 *
 * @return mysqli Un objeto de conexión MySQLi.
 * @throws Exception Si la conexión a la base de datos falla.
 */
function getDbConnection() {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if ($conn->connect_error) {
        throw new Exception("Error de conexión a la base de datos: " . $conn->connect_error);
    }
    $conn->set_charset("utf8mb4"); // Asegura que los caracteres especiales se manejen correctamente
    return $conn;
}

/**
 * Devuelve una respuesta JSON estandarizada.
 *
 * @param array $data Los datos a incluir en la respuesta.
 * @param int $statusCode El código de estado HTTP (por defecto 200).
 */
function sendJsonResponse($data, $statusCode = 200) {
    setApiHeaders(); // Asegura que las cabeceras se establezcan antes de cualquier salida
    http_response_code($statusCode);
    echo json_encode($data);
    exit(); // Termina la ejecución después de enviar la respuesta
}

/**
 * Maneja los errores internos del servidor y envía una respuesta JSON.
 *
 * @param string $message El mensaje de error.
 * @param int $statusCode El código de estado HTTP (por defecto 500).
 */
function sendErrorResponse($message, $statusCode = 500) {
    sendJsonResponse(['success' => false, 'message' => $message], $statusCode);
}

// Configuración para FPDF (si la usas) - asegúrate de que FPDF esté accesible
// define('FPDF_FONTPATH', 'ruta/a/tus/fuentes'); // O deja que FPDF la resuelva si está en la misma carpeta
require_once  '../fpdf/fpdf.php'; // Asegúrate de que esta ruta sea correcta a tu librería FPDF
