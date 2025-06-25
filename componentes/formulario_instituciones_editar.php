
<?php 



require '../conexion/conexion.php';

$id=$_GET['id'];


$sqlPacientes= " SELECT * FROM instituciones WHERE Id=$id";

$pacientes= $conn->query($sqlPacientes);
$fila=mysqli_fetch_assoc($pacientes);



?>



<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">ESTAS EDITANDO UN REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/actualizar_institucion.php">
                <input type="hidden" value="<?php  echo $id;   ?>" name="id" id="id">
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" value="<?php  echo $fila['Nombre'];      ?>" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE" required>
                </div>
                <button type="submit" class="btn btn-primary me-2">ACTUALIZAR</button>
                <a href="../admin/instituciones.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>