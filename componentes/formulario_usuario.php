<?php

require '../conexion/conexion.php';

$sqlDepartamentos= " SELECT * FROM departementos";

$departamentos1= $conn->query($sqlDepartamentos);


?>



<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_usuarios.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nombre">NOMBRE DE USUARIO</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE DE USUARIO" required>
                </div>
                <div class="form-group">
                    <label for="password">PASSWORD</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="PASSWORD" required>
                </div>
                <div class="form-group">
                    <label for="Tipo_Usuario">TIPO DE USUARIO</label>
                    <select name="Tipo_Usuario" id="Tipo_Usuario" class="form-control" aria-label=".form-select-lg example">
                    <option selected value="">Selecciona....</option>
                    <option selected value="ADMINISTRADOR">ADMINISTRADOR</option>
                    <option selected value="USUARIO">USUARIO</option>
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
                </div>
                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
               <a href="../admin/usuarios.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>