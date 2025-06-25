<div class="row">
    <div class="col-lg-6 mb-2">
        <a href="../users/nuevoInforme.php" class="btn btn-primary"><i class="mdi mdi-account-plus"></i></a>
        <a href="#../users/nuevoInforme.php" class="btn btn-success"><i class="mdi mdi-printer"></i></a>
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
                <table id="tablaEntrada" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Descripcion del Informe</th>
                            <th>Departamento</th>
                            <th>Decreto</th>
                            <th>Estado</th>
                            <th>Archivo</th>
                            <td>ACCIONES</td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row_entradas = $entradas->fetch_assoc()) {  ?>

                            <?php
                            $datos = $row_entradas['Id'];

                            ?>

                            <tr>
                                <td> <?= $row_entradas['Descripcion']; ?></td>

                                <?php
                                $dpto = $row_entradas['Dpto'];
                                $buscarDpto = "SELECT * FROM departementos WHERE Id = '$dpto'";
                                $ResultDpto = $conn->query($buscarDpto);

                                while ($filasEntradas = $ResultDpto->fetch_assoc()) {

                                ?>
                                    <td> <?= $filasEntradas['Nombre']; ?></td>
                                <?php  } ?>

                                <?php
                                $procedencia = $row_entradas['Decreto'];
                                $buscarProcedencia = "SELECT * FROM decretos WHERE Id = '$procedencia'";
                                $Resultprocedencia = $conn->query($buscarProcedencia);

                                while ($filasEntradas = $Resultprocedencia->fetch_assoc()) {

                                ?>
                                    <td> <?= $filasEntradas['Descripcion']; ?></td>
                                <?php  } ?>

                                <td> <?= $row_entradas['Estado']; ?></td>

                                <td> <a class="btn btn-primary me-2" href="../entradas/<?= $row_entradas['Archivo']; ?>" download="Entrada-<?= $row_entradas['Archivo']; ?>"><i class="mdi mdi-download"></i></a></td>
                                <!-- <td>
                                    <a class="btn btn-success me-2" href="../admin/editarInstitucion.php?id=<?php echo $row_entradas['Id']; ?>" class="btn btn-sm btn-warning"><i class="mdi mdi-eye"></i></a>
                                </td> -->
                                <td>
                                    <a class="btn btn-warning me-2" href="../admin/editarInstitucion.php?id=<?php echo $row_entradas['Id'];  ?>"><i class="mdi mdi-pencil"></i></a>
                                </td>
                                <!-- <td>
                                    <a class="btn btn-danger me-2" href=" #" onclick="agregarForm('<?php echo $datos; ?>');" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#eliminaModalInstitucion"><i class="mdi mdi-delete"></i></a>
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