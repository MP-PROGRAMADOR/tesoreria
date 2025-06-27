<?php

require '../conexion/conexion.php';

$sqlEntradas= " SELECT * FROM entradas";

$entradas= $conn->query($sqlEntradas);


?>









<?php

require '../conexion/conexion.php';
session_start();
if (!isset($_SESSION['usuario'])) {

    header('Location:../index.php');
}

$usuario = $_SESSION['usuario'];

$usuario_id = $_SESSION['codigo'];






// cogiendo los datos por meses
$sql_enero = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-01-01' AND '2023-01-31'";
$resultado_enero = mysqli_query($conn, $sql_enero);
$numero_enero = mysqli_num_rows($resultado_enero);

$sql_enero2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-01-01' AND '2023-01-31'";
$resultado_salidas2 = mysqli_query($conn, $sql_enero2);
$numero_enero2 = mysqli_num_rows($resultado_salidas2);

// febrero
$sql_febrero = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-02-01' AND '2023-02-31'";
$resultado_febrero = mysqli_query($conn, $sql_febrero);
$numero_febrero = mysqli_num_rows($resultado_febrero);

$sql_febrero2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-02-01' AND '2023-02-31'";
$resultado_febrero2 = mysqli_query($conn, $sql_febrero2);
$numero_febrero2 = mysqli_num_rows($resultado_febrero2);

// Marzo
$sql_marzo = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-03-01' AND '2023-03-31'";
$resultado_marzo = mysqli_query($conn, $sql_marzo);
$numero_marzo = mysqli_num_rows($resultado_marzo);

$sql_marzo2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-03-01' AND '2023-03-31'";
$resultado_marzo2 = mysqli_query($conn, $sql_marzo2);
$numero_marzo2 = mysqli_num_rows($resultado_marzo2);



// ABRIL
$sql_abril = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-04-01' AND '2023-04-31'";
$resultado_abril = mysqli_query($conn, $sql_abril);
$numero_abril = mysqli_num_rows($resultado_abril);

$sql_abril2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-04-01' AND '2023-04-31'";
$resultado_abril2 = mysqli_query($conn, $sql_abril2);
$numero_abril2 = mysqli_num_rows($resultado_abril2);

// MAYO
$sql_mayo = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-05-01' AND '2023-05-31'";
$resultado_mayo = mysqli_query($conn, $sql_mayo);
$numero_mayo = mysqli_num_rows($resultado_mayo);

$sql_mayo2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-05-01' AND '2023-05-31'";
$resultado_mayo2 = mysqli_query($conn, $sql_mayo2);
$numero_mayo2 = mysqli_num_rows($resultado_mayo2);

// JUNIO
$sql_junio = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-06-01' AND '2023-06-31'";
$resultado_junio = mysqli_query($conn, $sql_junio);
$numero_junio = mysqli_num_rows($resultado_junio);

$sql_junio2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-06-01' AND '2023-06-31'";
$resultado_junio2 = mysqli_query($conn, $sql_junio2);
$numero_junio2 = mysqli_num_rows($resultado_junio2);

// JULIO
$sql_julio = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-07-01' AND '2023-07-31'";
$resultado_julio = mysqli_query($conn, $sql_julio);
$numero_julio = mysqli_num_rows($resultado_julio);

$sql_julio2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-07-01' AND '2023-07-31'";
$resultado_julio2 = mysqli_query($conn, $sql_julio2);
$numero_julio2 = mysqli_num_rows($resultado_julio2);


// AGOSTO
$sql_agosto = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-08-01' AND '2023-08-31'";
$resultado_agosto = mysqli_query($conn, $sql_agosto);
$numero_agosto = mysqli_num_rows($resultado_agosto);

$sql_agosto2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-08-01' AND '2023-08-31'";
$resultado_agosto2 = mysqli_query($conn, $sql_agosto2);
$numero_agosto2 = mysqli_num_rows($resultado_agosto2);


// SEPTIEMBRE
$sql_septiembre = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-09-01' AND '2023-09-31'";
$resultado_septiembre = mysqli_query($conn, $sql_septiembre);
$numero_septiembre = mysqli_num_rows($resultado_septiembre);

$sql_septiembre2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-09-01' AND '2023-09-31'";
$resultado_septiembre2 = mysqli_query($conn, $sql_septiembre2);
$numero_septiembre2 = mysqli_num_rows($resultado_septiembre2);

// OCTUBRE
$sql_octubre = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-10-01' AND '2023-10-31'";
$resultado_octubre = mysqli_query($conn, $sql_octubre);
$numero_octubre = mysqli_num_rows($resultado_octubre);

$sql_octubre2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-10-01' AND '2023-10-31'";
$resultado_octubre2 = mysqli_query($conn, $sql_octubre2);
$numero_octubre2 = mysqli_num_rows($resultado_octubre2);

// NOVIEMBRE
$sql_noviembre = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-11-01' AND '2023-11-31'";
$resultado_noviembre = mysqli_query($conn, $sql_noviembre);
$numero_noviembre = mysqli_num_rows($resultado_noviembre);

$sql_noviembre2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-11-01' AND '2023-11-31'";
$resultado_noviembre2 = mysqli_query($conn, $sql_noviembre2);
$numero_noviembre2 = mysqli_num_rows($resultado_noviembre2);


// DICIEMBRE
$sql_diciembre = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-12-01' AND '2023-12-31'";
$resultado_diciembre = mysqli_query($conn, $sql_diciembre);
$numero_diciembre = mysqli_num_rows($resultado_diciembre);

$sql_diciembre2 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-12-01' AND '2023-12-31'";
$resultado_diciembre2 = mysqli_query($conn, $sql_diciembre2);
$numero_diciembre2 = mysqli_num_rows($resultado_diciembre2);






// filtrando los meses para cada usuario
$sql_enero4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-01-01' AND '2023-01-31' AND Usuario=$usuario_id";
$resultado_enero4 = mysqli_query($conn, $sql_enero4);
$numero_enero4 = mysqli_num_rows($resultado_enero4);

$sql_enero5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-01-01' AND '2023-01-31' AND Usuario=$usuario_id";
$resultado_salidas5 = mysqli_query($conn, $sql_enero5);
$numero_enero5 = mysqli_num_rows($resultado_salidas5);

// febrero
$sql_febrero4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-02-01' AND '2023-02-31' AND Usuario=$usuario_id";
$resultado_febrero4 = mysqli_query($conn, $sql_febrero4);
$numero_febrero4 = mysqli_num_rows($resultado_febrero4);

$sql_febrero5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-02-01' AND '2023-02-31' AND Usuario=$usuario_id";
$resultado_febrero5 = mysqli_query($conn, $sql_febrero5);
$numero_febrero5 = mysqli_num_rows($resultado_febrero5);

// Marzo
$sql_marzo4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-03-01' AND '2023-03-31' AND Usuario=$usuario_id";
$resultado_marzo4 = mysqli_query($conn, $sql_marzo4);
$numero_marzo4 = mysqli_num_rows($resultado_marzo4);

$sql_marzo5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-03-01' AND '2023-03-31' AND Usuario=$usuario_id";
$resultado_marzo5 = mysqli_query($conn, $sql_marzo5);
$numero_marzo5 = mysqli_num_rows($resultado_marzo5);



// ABRIL
$sql_abril4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-04-01' AND '2023-04-31' AND Usuario=$usuario_id";
$resultado_abril4 = mysqli_query($conn, $sql_abril4);
$numero_abril4 = mysqli_num_rows($resultado_abril4);

$sql_abril5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-04-01' AND '2023-04-31' AND Usuario=$usuario_id";
$resultado_abril5 = mysqli_query($conn, $sql_abril5);
$numero_abril5 = mysqli_num_rows($resultado_abril5);

// MAYO
$sql_mayo4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-05-01' AND '2023-05-31' AND Usuario=$usuario_id";
$resultado_mayo4 = mysqli_query($conn, $sql_mayo4);
$numero_mayo4 = mysqli_num_rows($resultado_mayo4);

$sql_mayo5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-05-01' AND '2023-05-31' AND Usuario=$usuario_id";
$resultado_mayo5 = mysqli_query($conn, $sql_mayo5);
$numero_mayo5 = mysqli_num_rows($resultado_mayo5);

// JUNIO
$sql_junio4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-06-01' AND '2023-06-31' AND Usuario=$usuario_id";
$resultado_junio4 = mysqli_query($conn, $sql_junio4);
$numero_junio4 = mysqli_num_rows($resultado_junio4);

$sql_junio5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-06-01' AND '2023-06-31' AND Usuario=$usuario_id";
$resultado_junio5 = mysqli_query($conn, $sql_junio5);
$numero_junio5 = mysqli_num_rows($resultado_junio5);

// JULIO
$sql_julio4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-07-01' AND '2023-07-31' AND Usuario=$usuario_id";
$resultado_julio4 = mysqli_query($conn, $sql_julio4);
$numero_julio4 = mysqli_num_rows($resultado_julio4);

$sql_julio5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-07-01' AND '2023-07-31' AND Usuario=$usuario_id";
$resultado_julio5 = mysqli_query($conn, $sql_julio5);
$numero_julio5 = mysqli_num_rows($resultado_julio5);


// AGOSTO
$sql_agosto4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-08-01' AND '2023-08-31' AND Usuario=$usuario_id";
$resultado_agosto4 = mysqli_query($conn, $sql_agosto4);
$numero_agosto4 = mysqli_num_rows($resultado_agosto4);

$sql_agosto5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-08-01' AND '2023-08-31' AND Usuario=$usuario_id";
$resultado_agosto5 = mysqli_query($conn, $sql_agosto5);
$numero_agosto5 = mysqli_num_rows($resultado_agosto5);


// SEPTIEMBRE
$sql_septiembre4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-09-01' AND '2023-09-31' AND Usuario=$usuario_id";
$resultado_septiembre4 = mysqli_query($conn, $sql_septiembre4);
$numero_septiembre4 = mysqli_num_rows($resultado_septiembre4);

$sql_septiembre5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-09-01' AND '2023-09-31' AND Usuario=$usuario_id";
$resultado_septiembre5 = mysqli_query($conn, $sql_septiembre5);
$numero_septiembre5 = mysqli_num_rows($resultado_septiembre5);

// OCTUBRE
$sql_octubre4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-10-01' AND '2023-10-31' AND Usuario=$usuario_id";
$resultado_octubre4 = mysqli_query($conn, $sql_octubre4);
$numero_octubre4 = mysqli_num_rows($resultado_octubre4);

$sql_octubre5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-10-01' AND '2023-10-31' AND Usuario=$usuario_id";
$resultado_octubre5 = mysqli_query($conn, $sql_octubre5);
$numero_octubre5 = mysqli_num_rows($resultado_octubre5);

// NOVIEMBRE
$sql_noviembre4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-11-01' AND '2023-11-31' AND Usuario=$usuario_id";
$resultado_noviembre4 = mysqli_query($conn, $sql_noviembre4);
$numero_noviembre4 = mysqli_num_rows($resultado_noviembre4);

$sql_noviembre5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-11-01' AND '2023-11-31' AND Usuario=$usuario_id";
$resultado_noviembre5 = mysqli_query($conn, $sql_noviembre5);
$numero_noviembre5 = mysqli_num_rows($resultado_noviembre5);


// DICIEMBRE
$sql_diciembre4 = "SELECT * FROM entradas WHERE FechaRegistro BETWEEN '2023-12-01' AND '2023-12-31' AND Usuario=$usuario_id";
$resultado_diciembre4 = mysqli_query($conn, $sql_diciembre4);
$numero_diciembre4 = mysqli_num_rows($resultado_diciembre4);

$sql_diciembre5 = "SELECT * FROM salidas WHERE FechaRegistro BETWEEN '2023-12-01' AND '2023-12-31' AND Usuario=$usuario_id";
$resultado_diciembre5 = mysqli_query($conn, $sql_diciembre5);
$numero_diciembre5 = mysqli_num_rows($resultado_diciembre5);




// eso en el grafico circular
$anio_actual = date("Y");

// Entradas del año actual
$sql_entradas_total = "SELECT * FROM entradas 
    WHERE YEAR(FechaRegistro) = $anio_actual AND Usuario = $usuario_id";
$resultado_entradas_total = mysqli_query($conn, $sql_entradas_total);
$numero_entradas_total = mysqli_num_rows($resultado_entradas_total);

// Salidas del año actual
$sql_salidas_total = "SELECT * FROM salidas 
    WHERE YEAR(FechaRegistro) = $anio_actual AND Usuario = $usuario_id";
$resultado_salidas_total = mysqli_query($conn, $sql_salidas_total);
$numero_salidas_total = mysqli_num_rows($resultado_salidas_total);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>TESORERIA </title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../vendors/feather/feather.css">
    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/typicons/typicons.css">
    <link rel="stylesheet" href="../vendors/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="../vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
    <link rel="stylesheet" href="../js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../css/vertical-layout-light/style.css">
    <!-- estilos personalizados -->
    <link rel="stylesheet" href="../css/estilosPersonalizados.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../images/favicon.png" />


    <!-- datatables -->
    <!-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">

    css de datatables 
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css"> -->


    <!-- css datables nuevo -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <script src="../ckeditor/ckeditor.js"></script>
    <script src="../js/jquery.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



    <!-- graficas  -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>




    <style>
  .table th, .table td {
    vertical-align: middle;
  }
  .table th {
    font-weight: 600;
  }
</style>
<style>
  .bg-light-subtle {
    background-color: #f8f9fa; /* más suave que blanco puro */
  }
</style>



<style>
  .info-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    transition: 0.3s ease;
  }

  .info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 25px rgba(0,0,0,0.08);
  }

  .info-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
    display: inline-block;
    padding: 15px;
    border-radius: 50%;
  }

  .bg-entrada {
    background: linear-gradient(135deg, #28a745, #218838);
    color: #fff;
  }

  .bg-salida {
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: #fff;
  }

  .bg-decreto {
    background: linear-gradient(135deg, #ffc107, #e0a800);
    color: #fff;
  }

  .bg-fecha {
    background: #eef0f4;
    color: #343a40;
  }

  .bg-hora {
    background: #f8f9fa;
    color: #495057;
  }

  .info-title {
    font-size: 0.9rem;
    color: #6c757d;
  }

  .info-value {
    font-size: 1.6rem;
    font-weight: 700;
    color: #212529;
  }
</style>



<style>
  .sidebar {
    background: #f8f9fa;
    border-right: 1px solid #dee2e6;
    padding-top: 1rem;
    height: 100vh;
  }

  .sidebar .nav-link {
    color: #495057;
    font-weight: 500;
    display: flex;
    align-items: center;
    padding: 0.75rem 1.25rem;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
    border-radius: 0 20px 20px 0;
    margin-bottom: 0.25rem;
  }

  .sidebar .nav-link:hover {
    background-color: #e9ecef;
    border-left: 4px solid #0d6efd;
    color: #0d6efd;
  }

  .sidebar .nav-link.active {
    background-color: #e2e6ea;
    border-left: 4px solid #0d6efd;
    color: #0d6efd;
  }

  .sidebar .menu-icon {
    font-size: 1.2rem;
    margin-right: 12px;
    color: inherit;
  }

  .sidebar .menu-title {
    font-size: 0.95rem;
  }

  @media (max-width: 992px) {
    .sidebar {
      position: fixed;
      z-index: 1050;
      width: 250px;
      transition: all 0.3s ease;
    }
  }
</style>



















<script type="text/javascript">
google.charts.load('current', {'packages': ['bar']});

$(document).ready(function () {
    $('.seleccionar-anio').click(function (e) {
        e.preventDefault();
        var anio = $(this).data('anio');

        $.ajax({
            url: 'grafico_anual.php',
            method: 'POST',
            data: { anio: anio },
            dataType: 'json',
            success: function (response) {
                google.charts.setOnLoadCallback(function () {
                    drawChart(response);
                });
            }
        });
    });

    function drawChart(datos) {
        var data = google.visualization.arrayToDataTable(datos);

        var options = {
            chart: {
                title: 'Entradas y Salidas por mes'
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
});
</script>



    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['bar']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Meses', 'Entradas', 'Salidas'],
                ['Enero', <?= $numero_enero4;   ?>, <?= $numero_enero5;   ?>],
                ['Febrero', <?= $numero_febrero4;   ?>, <?= $numero_febrero5;   ?>],
                ['Marzo', <?= $numero_marzo4;   ?>, <?= $numero_marzo5;   ?>],
                ['Abril', <?= $numero_abril4;   ?>, <?= $numero_abril5;   ?>],
                ['Mayo', <?= $numero_mayo4;   ?>, <?= $numero_mayo5;   ?>],
                ['Junio', <?= $numero_junio4;   ?>, <?= $numero_junio5;   ?>],
                ['Julio', <?= $numero_julio4;   ?>, <?= $numero_julio5;   ?>],
                ['Agosto', <?= $numero_agosto4;   ?>, <?= $numero_agosto5;   ?>],
                ['Septiembre', <?= $numero_septiembre4;   ?>, <?= $numero_septiembre5;   ?>],
                ['Octubre', <?= $numero_octubre4;   ?>, <?= $numero_octubre5;   ?>],
                ['Noviembre', <?= $numero_noviembre4;   ?>, <?= $numero_noviembre5;   ?>],
                ['Diciembre', <?= $numero_diciembre4;   ?>, <?= $numero_diciembre5;   ?>]
            ]);

            var options = {
                chart: {
                    // title: 'Company Performance',
                    // subtitle: 'Sales, Expenses, and Profit: 2014-2017',
                }
            };

            var chart = new google.charts.Bar(document.getElementById('columnchart_material2'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    </script>





    <!-- grafico circular -->




<script type="text/javascript">
google.charts.load("current", {
    packages: ["corechart"]
});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var data = google.visualization.arrayToDataTable([
        ['Tipo', 'Cantidad'],
        ['Entradas', <?= $numero_entradas_total; ?>],
        ['Salidas', <?= $numero_salidas_total; ?>]
    ]);

    var options = {
        legend: 'none',
        pieSliceText: 'label',
        pieStartAngle: 100,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));
    chart.draw(data, options);
}
</script>








</head>

<body>








<div class="container-scroller">
    <!-- partial:../../partials/_navbar.html -->








<?php  

// obteniendo la hora acyaual
date_default_timezone_set('Africa/Malabo');

 
$hora_actual = date("H");



$hora = date("H:i:s");
$hora2 = 13;
$hora3 = 20;
 
if($hora_actual < $hora2){
    $saludo= "Buenos días";
}
else if($hora_actual > $hora2 AND $hora_actual < $hora3){
    $saludo ="Buenas Tardes";
}
else{
    $saludo= "Buenas Noches";
}



// obteniendo los dias del mes
$fecha_actual="";#date("d-m-y");


    $vector = array(
        1 => $fecha_actual . " Nada nuevo hay bajo el sol, pero cuántas cosas viejas hay que no conocemos.",
        2 => $fecha_actual . " El verdadero amigo es aquel que está a tu lado cuando preferiría estar en otra parte.",
        3 => $fecha_actual . " La sabiduría es la hija de la experiencia.",
        4 => $fecha_actual . " Nunca hay viento favorable para el que no sabe hacia dónde va.",
        6 => $fecha_actual . " El único modo de hacer un gran trabajo es amar lo que haces - Steve Jobs",
        5 => $fecha_actual . " La felicidad es el verdadero sentimiento de plenitud que se consigue con el trabajo duro",
        7 => $fecha_actual . " Sé un punto de referencia de calidad. Algunas personas no están acostumbradas a un ambiente donde la excelencia es aceptada",
        8 => $fecha_actual . " La felicidad es el verdadero sentimiento de plenitud que se consigue con el trabajo duro",
        9 => $fecha_actual . " Si no haces que ocurran  cosas, las cosas te ocurrirán a ti",
        10 => $fecha_actual . " Trabajar en lo correcto es mucho más importante que trabajar duro",
        11 => $fecha_actual . " Los líderes son encantadores, generan mucha empatía, se ponen en el lugar del resto para saber cómo piensa y que le deben decir, utilizan bastante su inteligencia emocional",
        12 => $fecha_actual . " El trabajo obsesivo produce la locura, tanto como la pereza completa, pero con esta combinación se puede vivir",
        13 => $fecha_actual . " En medio de la dificultad yace la oportunidad",
        14 => $fecha_actual . " Los obstáculos son esas cosas espantosas que ves cuando quitas la mirada de tus metas",
        15 => $fecha_actual . " El hombre que mueve montañas comienza cargando pequeñas piedras",
        16 => $fecha_actual . " El fracaso no es lo opuesto al éxito: es parte del éxito",
        17 => $fecha_actual . " La habilidad es lo que eres capaz de hacer. La motivación determina lo que haces. La actitud determina qué tan bien lo haces",
        18 => $fecha_actual . " Somos lo que hacemos repetidamente. La excelencia, entonces, no es un acto, sino un hábito",
        19 => $fecha_actual . " No tienes que mirar toda la escalera. Para empezar, solo concéntrate en dar el primer paso",
        20 => $fecha_actual . " La felicidad no está en la mera posesión del dinero; radica en la alegría del logro, en la emoción del esfuerzo creativo",
        21 => $fecha_actual . " Haz lo único que crees que no puedes hacer. Falla en eso. Intenta otra vez. Hazlo mejor la segunda vez. Las únicas personas que nunca se caen son aquellas que nunca se suben a la cuerda floja",
        22 => $fecha_actual . " Nunca hay tiempo suficiente para hacerlo bien, pero siempre hay tiempo suficiente para hacerlo de nuevo",
        23 => $fecha_actual . " Enfócate en ser productivo en vez de enfocarte en estar ocupado",
        24 => $fecha_actual . " Trabajar en lo correcto es probablemente más importante que trabajar duro",
        25 => $fecha_actual . " El hombre no puede descubrir nuevos océanos a menos que tenga el coraje de perder de vista la costa",
        26 => $fecha_actual . " No aprendes a caminar siguiendo reglas. Aprendes haciendo y cayéndote",
        27 => $fecha_actual . " Los obstáculos no tienen por qué detenerte. Si te topas con una pared, no te des la vuelta y te rindas. Descubre cómo escalarla, atravesarla o sortearla",
        28 => $fecha_actual . " Nadie puede descubrirte hasta que tú lo hagas. Explota tus talentos, habilidades y fortalezas y haz que el mundo se siente y se dé cuenta",
        29 => $fecha_actual . " Si hay algo que te asusta, entonces podría significar que vale la pena intentarlo",
        30 => $fecha_actual . " El trabajo en equipo es el secreto que hace que gente común consiga resultados poco comunes",
        );
        $numero= rand(1,30);





?>



<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div class="">
            <a class="navbar-brand brand-logo" href="index.php">
                <img src="../images/LOGO-GRANDE.png" alt="logo" /> 
            </a>
           
        </div>
    </div>
    
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text"><?php echo $saludo;    ?> <span class="text-black fw-bold"> <?=  $usuario;   ?></span></h1>
                <h3 class="welcome-sub-text"><?php echo $fecha_actual;    ?> <?php echo "$vector[$numero] "; ?></h3>
            </li>
        </ul>
        
        <ul class="navbar-nav ms-auto">
        <a href="../php/cerrar_sesion.php" class="btn btn-success">Cerrar Sesión</i></a>
               
          
            <li class="nav-item dropdown">
               
            </li>
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <img class="img-xs rounded-circle" src="../images/faces/profile/foto1.jpg" alt="Profile image"> </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <img class="img-md rounded-circle" src="../images/faces/face8.jpg" alt="Profile image">
                        <p class="mb-1 mt-3 font-weight-semibold"><?php  echo $usuario;     ?></p>
                        <p class="fw-light text-muted mb-0">allenmoreno@gmail.com</p>
                    </div>
                    <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My
                        Profile <span class="badge badge-pill badge-danger">1</span></a>
                    <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-message-text-outline text-primary me-2"></i>
                        Messages</a>
                    <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-calendar-check-outline text-primary me-2"></i> Activity</a>
                    <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-help-circle-outline text-primary me-2"></i>
                        FAQ</a>
                    <a href="../php/cerrar_sesion.php" class="dropdown-item"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Cerrar Sesion</a>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>










    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_settings-panel.html -->
        <!-- <div class="theme-setting-wrapper">
            <div id="settings-trigger"><i class="ti-settings"></i></div>
            <div id="theme-settings" class="settings-panel">
                <i class="settings-close ti-close"></i>
                <p class="settings-heading">SIDEBAR SKINS</p>
                <div class="sidebar-bg-options selected" id="sidebar-light-theme">
                    <div class="img-ss rounded-circle bg-light border me-3"></div>Light
                </div>
                <div class="sidebar-bg-options" id="sidebar-dark-theme">
                    <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
                </div>
                <p class="settings-heading mt-2">HEADER SKINS</p>
                <div class="color-tiles mx-0 px-4">
                    <div class="tiles success"></div>
                    <div class="tiles warning"></div>
                    <div class="tiles danger"></div>
                    <div class="tiles info"></div>
                    <div class="tiles dark"></div>
                    <div class="tiles default"></div>
                </div>
            </div>
        </div> -->
        <div id="right-sidebar" class="settings-panel">
            <i class="settings-close ti-close"></i>
            <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                </li>
            </ul>
            <div class="tab-content" id="setting-content">
                <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                    <div class="add-items d-flex px-3 mb-0">
                        <form class="form w-100">
                            <div class="form-group d-flex">
                                <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="list-wrapper px-3">
                        <ul class="d-flex flex-column-reverse todo-list">
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Team review meeting at 3.00 PM
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Prepare for presentation
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox">
                                        Resolve all the low priority tickets due today
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Schedule meeting for next week
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                            <li class="completed">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="checkbox" type="checkbox" checked>
                                        Project review
                                    </label>
                                </div>
                                <i class="remove ti-close"></i>
                            </li>
                        </ul>
                    </div>
                    <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
                    <div class="events pt-4 px-3">
                        <div class="wrapper d-flex mb-2">
                            <i class="ti-control-record text-primary me-2"></i>
                            <span>Feb 11 2018</span>
                        </div>
                        <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
                        <p class="text-gray mb-0">The total number of sessions</p>
                    </div>
                    <div class="events pt-4 px-3">
                        <div class="wrapper d-flex mb-2">
                            <i class="ti-control-record text-primary me-2"></i>
                            <span>Feb 7 2018</span>
                        </div>
                        <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
                        <p class="text-gray mb-0 ">Call Sarah Graves</p>
                    </div>
                </div>
                <!-- To do section tab ends -->
                <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
                    <div class="d-flex align-items-center justify-content-between border-bottom">
                        <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
                        <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 fw-normal">See All</small>
                    </div>
                    <ul class="chat-list">
                        <li class="list active">
                            <div class="profile"><img src="../images/faces/face1.jpg" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Thomas Douglas</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">19 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="../images/faces/face2.jpg" alt="image"><span class="offline"></span></div>
                            <div class="info">
                                <div class="wrapper d-flex">
                                    <p>Catherine</p>
                                </div>
                                <p>Away</p>
                            </div>
                            <div class="badge badge-success badge-pill my-auto mx-2">4</div>
                            <small class="text-muted my-auto">23 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="../images/faces/face3.jpg" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Daniel Russell</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">14 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="../images/faces/face4.jpg" alt="image"><span class="offline"></span></div>
                            <div class="info">
                                <p>James Richardson</p>
                                <p>Away</p>
                            </div>
                            <small class="text-muted my-auto">2 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="../images/faces/face5.jpg" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Madeline Kennedy</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">5 min</small>
                        </li>
                        <li class="list">
                            <div class="profile"><img src="../images/faces/face6.jpg" alt="image"><span class="online"></span></div>
                            <div class="info">
                                <p>Sarah Graves</p>
                                <p>Available</p>
                            </div>
                            <small class="text-muted my-auto">47 min</small>
                        </li>
                    </ul>
                </div>
                <!-- chat tab ends -->
            </div>
        </div>
        <!-- partial -->
        <!-- partial:../../partials/_sidebar.html -->









<nav class="sidebar sidebar-offcanvas shadow-sm" id="sidebar">
  <ul class="nav flex-column">
    <li class="nav-item">
      <a class="nav-link <?= $page == 'inicio' ? 'active' : '' ?>" href="index.php">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Inicio</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'entradas' ? 'active' : '' ?>" href="entradas.php">
        <i class="mdi mdi-folder-open menu-icon"></i>
        <span class="menu-title">Entradas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'salidas' ? 'active' : '' ?>" href="salidas.php">
        <i class="mdi mdi-folder menu-icon"></i>
        <span class="menu-title">Salidas</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'decretos' ? 'active' : '' ?>" href="decretos.php">
        <i class="mdi mdi-tag menu-icon"></i>
        <span class="menu-title">Decretos</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link <?= $page == 'reportes' ? 'active' : '' ?>" href="reportes.php">
        <i class="mdi mdi-chart-bar menu-icon"></i>
        <span class="menu-title">Reportes</span>
      </a>
    </li>
  </ul>
</nav>






        <!-- partial sidebar final -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">                  
                
                







                <?php
// obteniendo el ultimo registro de la base de datos
$sql_numero="SELECT * FROM entradas ORDER BY id DESC LIMIT 1";
$sql_resultado= mysqli_query($conn, $sql_numero);
$fila_numero= mysqli_fetch_assoc($sql_resultado);

$numero_instituciones= mysqli_num_rows($sql_resultado);

if($numero_instituciones==0){
    $fech=date("Y");
    echo $fech;
  
   $ultimo_registro1= 1;
   $ultimo_registro="-".$fech;
}else{

    //sumando el primero numero del registro 1 ;
$ultimo_registro= substr($fila_numero['NumRegistro'],0,1);
$ultimo_registro1= $ultimo_registro +1;

$ultimo_registro= substr($fila_numero['NumRegistro'],1,6);

}

?>

<div class="row">
    <div class="col-lg-6 mb-2">
        <a href="../users/nuevaEntrada.php" class="btn btn-primary"><i class="mdi mdi-folder-plus"></i></a>
        <a href="../fpdf/entradas.php" target="__blanck" class="btn btn-success"><i class="mdi mdi-printer"></i></a>
    </div>
    <div class="col-lg-6 mb-2">
                <h4 class="card-title text-success">Siguiente Registro: <?php  echo $ultimo_registro1 . $ultimo_registro;   ?></h4>
    </div>
</div>



<!-- alerta -->

<?php
if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'insertado') {
?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong> Hola!</strong> su registro ha tenido Exito.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php

}

?>

<!-- alerta -->

<?php
if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'actualizado') {
?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong> Hola!</strong> su Actualizacion ha tenido Exito.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php

}

?>

<!-- alerta -->

<?php
if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'error') {
?>

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong> ERROR!</strong> Hubo un error.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php

}

?>


<!-- alerta -->

<?php
if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado') {
?>

    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong> Hola!</strong> Su Registro se ha Eliminado.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php

}

?>



<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nº Registro</th>
                            <th>Fecha Registro</th>
                            <th>Tipo de Documento</th>
                            <th>Descripción</th>
                            <th>Referencia</th>
                            <th>Fecha Firma</th>
                            <th>Importe</th>
                            <th>Archivo</th>
                            <td>Ver</td>
                            <td>Editar</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row_entradas = $entradas->fetch_assoc()) {  ?>

                            <?php
                            $datos = $row_entradas['Id'];

                            ?>

                            <tr>
                                <td> <?= $row_entradas['NumRegistro']; ?></td>
                                <td> <?= $row_entradas['FechaRegistro']; ?></td>
                                <td> <?= $row_entradas['TipoDoc']; ?></td>
                                <td> <?= $row_entradas['Descripcion']; ?></td>
                                <?php
                                $procedencia = $row_entradas['Referencia']; 
                                $buscarProcedencia = "SELECT * FROM referencias WHERE Id = '$procedencia'";
                                $Resultprocedencia = $conn->query($buscarProcedencia);

                                while ($filasEntradas = $Resultprocedencia->fetch_assoc()) {

                                ?>
                                    <td> <?= $filasEntradas['Codigo']; ?></td>
                                <?php  } ?>  

                                <td> <?= $row_entradas['FechaFirma']; ?></td>
                                <td> <?= $row_entradas['Importe']; ?></td>
                                <td> <a class="btn btn-primary me-2" href="../documentos/entradas/<?= $row_entradas['Archivo']; ?>" download="Entrada-<?= $row_entradas['NumRegistro'].".pdf"; ?>"><i class="mdi mdi-download"></i></a></td>
                                <td>

                                    <a class="btn btn-success me-2" href="../users/detallesEntradas.php?id=<?php echo $row_entradas['Id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-eye"></i></a>
                                </td>

                                <td>
                                    <a class="btn btn-warning me-2" href="../users/editarEntrada.php?id=<?php echo $row_entradas['Id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                                </td>
                                <!-- <td>
                                    <a class="btn btn-danger me-2" href=" #" onclick="agregarForm('<?php echo $datos; ?>');" data-bs-toggle="modal" data-bs-target="#eliminaModalInstitucion"><i class="mdi mdi-delete"></i></a>
                                </td> -->
                            </tr>


                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/ModaleliminarInstitucion.php'    ?>






<script>
    // boton eliminar codigo del modal..

    // agregar datos al formulario
    function agregarForm(datos) {
        var d = datos.split('||');
        // alert("los datos son: "+d);
        // return false;
        $('#Id').val(d[0]);

    }
</script>











                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
          



            <footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block"><a href="https://mpmarketingsolution.net/" target="_blank">MP Marketing & Solutions</a>.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2023. Todos los derechos reservados..</span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<script src="../vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<!-- plugins:js -->
<script src="../vendors/js/vendor.bundle.base.js"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="../vendors/chart.js/Chart.min.js"></script>
<script src="../vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="../vendors/progressbar.js/progressbar.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="../js/off-canvas.js"></script>
<script src="../js/todolist.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="../js/jquery.cookie.js" type="text/javascript"></script>
<script src="../js/dashboard.js"></script>
<script src="../js/Chart.roundedBarCharts.js"></script>


<!-- Page specific script -->
<script>
  // $(document).ready( function () {
  //   $('#myTable').DataTable();
  // } );

  $(document).ready(function() {
    $('#myTable').DataTable({
      "language": {
        "lengthMenu": "Mostrar" +
          `<select>
                  <option values="10">10</option>
                  <option values="25">25</option>
                  <option values="50">50</option>
                  <option values="100">100</option>
                  <option values="-1">Todos</option>
                  </select>` +
          "Registros por páginas",
        "zeroRecords": "No hay coincidencia con la insertado - Lo siento ):",
        "info": "Mostrando la página _PAGE_ de _PAGES_",
        "infoEmpty": "No records available",
        "infoFiltered": "(Filtrado de _MAX_ Registros Totales)",
        'search': "Buscar:",
        'paginate ': {
          'next': "Siguente",
          'previous': "Anterior _MENU_"
        }
      }
    });
  });
</script>




<!-- datatables -->

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>






</body>

</html>