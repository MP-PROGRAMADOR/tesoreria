<?php
// obteniendo el ultimo registro de la base de datos
$sql_numero="SELECT * FROM salidas ORDER BY id DESC LIMIT 1";
$sql_resultado= mysqli_query($conn, $sql_numero);
$fila_numero= mysqli_fetch_assoc($sql_resultado);



$numero_instituciones= mysqli_num_rows($sql_resultado);

if($numero_instituciones==0){
    $fech=date("Y");
    
  
   $ultimo_registro1= 1;
   $ultimo_registro="-".$fech;
}else{

    //sumando el primero numero del registro 1 ;
$ultimo_registro= substr($fila_numero['NumRegistro'],0,1);
$ultimo_registro1= $ultimo_registro +1;

$ultimo_registro= substr($fila_numero['NumRegistro'],1,6);

}

// //sumando el primero numero del registro 1 ;
// $ultimo_registro= substr($fila_numero['NumRegistro'],0,1);
// $ultimo_registro1= $ultimo_registro +1;

// $ultimo_registro= substr($fila_numero['NumRegistro'],1,6);
?> 



<div class="row">
    <div class="col-lg-6 mb-2">
        <a href="../users/nuevaSalida.php" class="btn btn-primary"><i class="mdi mdi-folder-plus"></i></a>
        <a href="../fpdf/salidas.php" target="__blanck" class="btn btn-success"><i class="mdi mdi-printer"></i></a>
    </div>
    <div class="col-lg-6">
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
                            <th>Entrada</th>
                            <th>Archivo</th>
                            <th>Ver</th>
                            <th>Editar</th>
                          
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row_entradas = $salidas->fetch_assoc()) {  ?>

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
                                <td> <?= $row_entradas['Entrada']; ?></td>
                                <td> <a class="btn btn-primary me-2" href="../documentos/salidas/<?= $row_entradas['Archivo']; ?>" download="Salida-<?= $row_entradas['NumRegistro']; ?>"><i class="mdi mdi-download"></i></a></td>
                                <td>
                                    <a class="btn btn-success me-2" href="../users/detallesSalidas.php?id=<?php echo $row_entradas['Id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-eye"></i></a>
                                </td>
                                <td>
                                    <a class="btn btn-warning me-2" href="../users/editarSalida.php?id=<?php echo $row_entradas['Id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-pencil"></i></a>
                                </td>
                               
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
    $('#tablaEntrada').DataTable();
</script>


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