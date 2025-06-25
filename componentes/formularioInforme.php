<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO DE INFORMES</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_informe.php" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="ckeditor">Descripción del Informe</label>
                    <textarea name="descripcion" id="ckeditor" class="form-control ckeditor" id="" cols="30" rows="15" placeholder="Descripcion del documento"></textarea>
                </div>
                <div class="form-group">
                    <label for="dpto"> Departamentos</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="dpto" name="dpto" required>
                        <option selected value="">seleccione el departamento.....</option>
                        <?php while ($entradas = mysqli_fetch_array($ResultDpto)) { ?>
                            <option value="<?php echo $entradas['Id']; ?>"><?php echo $entradas['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="decreto"> Decretos</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="decreto" name="decreto" required>
                        <option selected value="">seleccione un decreto.....</option>
                        <?php while ($entradas = mysqli_fetch_array($ResultDecretos)) { ?>
                            <option value="<?php echo $entradas['Id']; ?>"><?php echo $entradas['Descripcion']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            

                <div class="form-group">
                    <label for="archivo">Selecciona el Documento</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Ejemplo solicitud de...">
                </div>
                <!-- <div class="form-group">
                    <label for="estado">¿?</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="estado" name="estado" required>
                        <option selected value="si">Sí</option>
                        <option value="no">No</option>                        
                    </select>
                </div> -->

                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="./informes.php" class="btn btn-light">CANCELAR</a>
            </form>
        </div>
    </div>
</div>