<div class="row">
    <div class="col-lg-6 mb-2">
        <a href="../admin/nuevoUsuario.php" class="btn btn-primary"> <i class="mdi mdi-account-plus"></i></a>
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
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>DEPARTAMENTOS</th>
                            <th>TIPO USUARIO</th>
                            <th>FOTO</th>
                            <th>EDITAR</th>
                            <!-- <th>ELIMINAR</th> -->
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row_pacientes = $pacientes->fetch_assoc()) {  ?>

                            <?php
                            $datos = $row_pacientes['Id'];

                            ?>

                            <tr>
                                <td> <?= $row_pacientes['Id']; ?></td>
                                <td> <?= $row_pacientes['Nombre']; ?></td>


                                <?php

                                $id_departamento = $row_pacientes['Dpto'];

                                $sql1 = "SELECT * FROM departementos WHERE Id=$id_departamento";

                                $resultado = mysqli_query($conn, $sql1);

                                $fila1 = mysqli_fetch_assoc($resultado);

                                $departamento = $fila1['Nombre'];

                                // ruta de la imagen 
                                $id_insert = $conn->insert_id;
                                $dir = '../php/files/';

                                ?>


                                <td> <?= $departamento; ?></td>
                                <?php
                                $usuario = $row_pacientes['Tipo_Usuario'];

                                if ($usuario == "ADMINISTRADOR") {
                                    $tipo_usuario = "Administrador";
                                    $clase_badge = "bg-danger"; // rojo para admin
                                } else {
                                    $tipo_usuario = "Usuario normal";
                                    $clase_badge = "bg-secondary"; // gris para usuario normal
                                }
                                ?>
                                <td><span class="badge <?= $clase_badge; ?>"><?= $tipo_usuario; ?></span></td>

                                <td><img src="data:image/*;base64,<?php echo base64_encode($row_pacientes['Foto']); ?> " alt="" height="50px"></td>
                                <td>
                                    <a href="../admin/editarUsuarios.php?id=<?php echo $row_pacientes['Id'];  ?>" class="btn btn-warning me-2" ">EDITAR</a>
                                </td>
                                <!-- <td>
                               
                                <a href=" #" onclick="agregarForm('<?php echo $datos; ?>');" class="btn btn-danger me-2" data-bs-toggle="modal" data-bs-target="#eliminaModal"><i class="mdi mdi-delete"></i></a>
                                </td> -->
                            </tr>


                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../admin/ModaleliminarUsuarios.php'   ?>





<script>
    // agregar datos al formulario
    function agregarForm(datos) {
        var d = datos.split('||');
        // alert("los datos son: "+d);
        // return false;
        $('#Id').val(d[0]);

    }
</script>