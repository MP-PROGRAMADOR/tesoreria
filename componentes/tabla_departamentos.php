<div class="row">
    <div class="col-lg-6 mb-2">
        <a href="../admin/nuevoDepartamento.php" class="btn btn-primary"><i class="mdi mdi-account-plus"></i></a>
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


<!-- alerta de emilinar -->
<?php
if (isset($_GET['mensaje']) and $_GET['mensaje'] == 'eliminado') {
?>

    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="fas fa-info-circle"></i>
        <strong> Hola!</strong> Se Elimino su Registro.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php

}

?>





<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <h4 class="card-title">Todos los Departamentos</h4>
                </div>


            </div>


            <div class="table-responsive">
                <table id="myTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>TELEFONO</th>
                            <th>EMAIL</th>
                            <th>INSTITUCION</th>
                            <td>ACCIONES</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row_departamentos = $departamentos->fetch_assoc()) {  ?>

                            <?php
                            $datos = $row_departamentos['Id'];

                            ?>
                            <tr>
                                <td> <?= $row_departamentos['Id']; ?></td>
                                <td> <?= $row_departamentos['Nombre']; ?></td>
                                <td> <?= $row_departamentos['Telefono']; ?></td>
                                <td> <?= $row_departamentos['Email']; ?></td>


                                <?php

                                $id_institucion = $row_departamentos['Institucion'];

                                $sql1 = "SELECT * FROM instituciones WHERE Id=$id_institucion";

                                $resultado = mysqli_query($conn, $sql1);

                                $fila1 = mysqli_fetch_assoc($resultado);

                                $institucion = $fila1['Nombre'];

                                ?>


                                <td><?= $institucion ?></td>
                                <td>
                                    <a href="../admin/editarDepartamentos.php?id=<?php echo $row_departamentos['Id'];  ?>" class="btn btn-warning me-2" ">EDITAR</a>
                              
                                    <!-- <a href=" #" onclick="agregarForm('<?php echo $datos; ?>');" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="mdi mdi-archive"></i></a> -->
                                </td>


                            </tr>


                        <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/ModaleliminarDepartamento.php';         ?>




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