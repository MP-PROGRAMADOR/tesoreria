<?php



require '../conexion/conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {

    header('Location:../index.php');
}



$usuario_id = $_SESSION['codigo'];



$anio = $_POST['anio'];
$meses = [
    'Enero' => '01', 'Febrero' => '02', 'Marzo' => '03', 'Abril' => '04',
    'Mayo' => '05', 'Junio' => '06', 'Julio' => '07', 'Agosto' => '08',
    'Septiembre' => '09', 'Octubre' => '10', 'Noviembre' => '11', 'Diciembre' => '12'
];

$datos = [['Meses', 'Entradas', 'Salidas']];

foreach ($meses as $mes_nombre => $mes_numero) {
    $inicio = "$anio-$mes_numero-01";
    $fin = "$anio-$mes_numero-31";

    $sql_entradas = "SELECT COUNT(*) as total FROM entradas WHERE FechaRegistro BETWEEN '$inicio' AND '$fin' AND Usuario = $usuario_id";
    $sql_salidas = "SELECT COUNT(*) as total FROM salidas WHERE FechaRegistro BETWEEN '$inicio' AND '$fin' AND Usuario = $usuario_id";

    $entradas = mysqli_fetch_assoc(mysqli_query($conn, $sql_entradas))['total'];
    $salidas = mysqli_fetch_assoc(mysqli_query($conn, $sql_salidas))['total'];

    $datos[] = [$mes_nombre, (int)$entradas, (int)$salidas];
}

header('Content-Type: application/json');
echo json_encode($datos);
