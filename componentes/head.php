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