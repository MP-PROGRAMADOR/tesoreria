<?php

$id=$_GET["id"];



include "../conexion/conexion.php";

$sqlReferencia="SELECT * FROM referencias WHERE Id=$id";
$ResultadosReferencia=mysqli_query($conn,$sqlReferencia);
$filaReferencia= mysqli_fetch_assoc($ResultadosReferencia);




?>


<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> ESTAS EDITANDO UNA REFERENCIA</h4>
            <form class="forms-sample" method="POST" action="../php/actualizar_referencias.php">
                <div class="form-group">
                    <input type="hidden" value="<?=   $filaReferencia['Id']   ?>" name="id">
                    <label for="nombre">NOMBRE DE LA REFERENCIA</label>
                    <input type="text" class="form-control" value="<?=   $filaReferencia['Nombre']   ?>" id="nombre" name="nombre" placeholder="Nombre de la Referencia" required>
                </div>
                <div class="form-group">
                    <label for="codigo">CÓDIGO</label>
                    <input type="text" class="form-control" id="codigo" value="<?=   $filaReferencia['Codigo']   ?>" name="codigo" placeholder="Código de la Referencia" required>
                </div>
                
                <button type="submit" class="btn btn-primary me-2">ACTUALIZAR</button>
               <a href="../admin/miembros.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>