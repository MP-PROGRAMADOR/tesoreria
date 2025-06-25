<?php

require '../conexion/conexion.php';

$sqlDepartamentos = " SELECT * FROM departementos";

$departamentos1 = $conn->query($sqlDepartamentos);



?>

<?php

require '../conexion/conexion.php';

$sqlUsuarios = " SELECT * FROM usuarios";

$usuarios = $conn->query($sqlUsuarios);


$id = $_GET['id'];

$sqlusuarios = " SELECT * FROM usuarios WHERE Id=$id";

$usuarios = $conn->query($sqlusuarios);
$fila2 = mysqli_fetch_assoc($usuarios);
$id_insert= $id;

?>





<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/actualizar_usuarios.php" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" value="<?php echo $fila2['Id']; ?>" name="id" id="id">
                    <label for="nombre">NOMBRE DE USUARIO</label>
                    <input type="text" class="form-control" value="<?php echo $fila2['Nombre']; ?>" id="nombre" name="nombre" placeholder="NOMBRE DE USUARIO" required>
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" class="form-control" value="<?php //echo $fila2['Pass']; ?>" id="password" name="password" placeholder="PASSWORD" required>
                </div>
                <div class="form-group">
                    <label for="Tipo_Usuario">TIPO DE USUARIO</label>
                    <select name="Tipo_Usuario" id="Tipo_Usuario" class="form-control" aria-label=".form-select-lg example">
                    <option selected value="<?php echo $fila2['Tipo_Usuario']; ?>"><?php echo $fila2['Tipo_Usuario']; ?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="institucion"> DEPARTAMENTO</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="departamento" name="departamento" required>
                        <option selected value="">seleccione una Institucion.....</option>
                        <?php while ($departamentos = mysqli_fetch_array($departamentos1)) { ?>
                            <option value="<?php echo $departamentos['Id']; ?>"><?php echo $departamentos['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="archivo">FOTO</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" accept="image/*" required>

                    <?php

                  



                    ?>

<img src="data:image/jpg;base64,<?php echo base64_encode($fila2['Foto']); ?> " alt=""  height="60px" class="mt-2">







                </div>
                <button type="submit" class="btn btn-primary me-2">ACTUALIZAR</button>
                <a href="../admin/usuarios.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>