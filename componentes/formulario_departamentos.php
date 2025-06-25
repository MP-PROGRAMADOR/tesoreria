<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_departamento.php">
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE">
                </div>
                <div class="form-group">
                    <label for="telefono">TELEFONO</label>
                    <input type="number" class="form-control" id="telefono" name="telefono" placeholder="TELEFONO">
                </div>
                <div class="form-group">
                    <label for="correo">EMAIL</label>
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="EMAIL">
                </div>
                <div class="form-group">
                    <label for="institucion"> INTITUCIÓN</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="institucion" name="institucion" required>
                        <option selected value="">seleccione una Institucion.....</option>
                        <?php while ($institucion = mysqli_fetch_array($instituciones)) { ?>
                            <option value="<?php echo $institucion['Id']; ?>"><?php echo $institucion['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="../admin/departamentos.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $("#institucion").select2();
    });
</script>