<?php



require '../conexion/conexion.php';

$id = $_GET['id'];

$sqlPacientes = " SELECT * FROM departementos WHERE Id=$id";

$pacientes = $conn->query($sqlPacientes);
$fila = mysqli_fetch_assoc($pacientes);

?>



<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">EDITANDO REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/actualizar_departamentos.php">
                <input type="hidden" value="<?php echo $fila['Id']    ?>" name="id" id="id">
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control" value="<?php echo $fila['Nombre']    ?>" id="nombre" name="nombre" placeholder="NOMBRE">
                </div>
                <div class="form-group">
                    <label for="telefono">TELEFONO</label>
                    <input type="number" class="form-control" value="<?php echo $fila['Telefono']    ?>" id="telefono" name="telefono" placeholder="TELEFONO">
                </div>
                <div class="form-group">
                    <label for="correo">EMAIL</label>
                    <input type="email" class="form-control" value="<?php echo $fila['Email']    ?>" id="correo" name="correo" placeholder="EMAIL">
                </div>


                <?php

                $id_institucion = $fila['Institucion'];

              

                ?>


                <div class="form-group">
                    <label for="institucion"> INTITUCION</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="institucion" name="institucion" required>

                        <?php



                        $sql1 = "SELECT * FROM instituciones WHERE Id= $id_institucion";
                        $resultado = mysqli_query($conn, $sql1);
                        $fila2 = mysqli_fetch_assoc($resultado);

                        ?>


                        <option value="<?php echo $fila2['Id']; ?>"><?php echo $fila2['Nombre']; ?></option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary me-2">ACTUALIZAR</button>
                <a href="../admin/departamentos.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>