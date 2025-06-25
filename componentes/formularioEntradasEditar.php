<div class="col-md-12 grid-margin stretch-card"> 
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">MODIFICAR LA ENTRADA NÚMERO: <?php echo $resultado['NumRegistro']; ?></h4>
            <form class="forms-sample" method="POST" action="../php/actualizar_entrada.php" enctype="multipart/form-data">
                <div class="form-group">                    
                    <input type="hidden" class="form-control" id="TipoDoc" name="cod" value="<?php echo $resultado['Id']; ?>">
                </div>
                <div class="form-group">
                    <label for="TipoDoc">Tipo de Documento</label>
                    <input type="text" class="form-control" id="TipoDoc" name="TipoDoc" value="<?php echo $resultado['TipoDoc']; ?>">
                </div>
                <div class="form-group">
                    <label for="ckeditor">Descripción</label>
                    <textarea name="descripcion" id="descrip ckeditor" class="form-control ckeditor"  cols="30" rows="15" ><?php echo $resultado['Descripcion']; ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="palabrasClaves">Palabras Claves del Documento</label>
                    <input type="text" class="form-control" id="palabrasClaves" name="palabrasClaves" value="<?php echo $resultado['PalabrasClaves']; ?>">
                </div>
                <div class="form-group">
                    <label for="fechaFirma">¿Cuando de Firmo el documento?</label>
                    <input type="date" class="form-control" id="fechaFirma" name="fechaFirma" value="<?php echo $resultado['FechaFirma']; ?>">
                </div>
                <div class="form-group">
                    <label for="importe">Importe</label>
                    <input type="text" class="form-control" id="importe" name="importe" value="<?php echo $resultado['Importe']; ?>">
                </div>
                <div class="form-group" id="">
                    <label for="institucion"> Seleccione la Referencia</label>
                    <select class="form-control" id="ref" name="ref">
                        <option selected value="">seleccione una referencia.....</option>
                        <?php while ($referencia = mysqli_fetch_array($referencias)) { ?>
                            <option value="<?php echo $referencia['Id']; ?>"><?php echo $referencia['Codigo']." / ".$referencia['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <!-- <div class="form-group">
                    <label for="archivo">Selecciona el Documento</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Ejemplo solicitud de...">
                </div> -->
                <!-- <label for="institucion"> Procede de una...</label>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="perF" value="pf"> Persona Física<i class="input-helper rounded"></i>
                    </label>
                </div> -->
                <!-- <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio"  id="perJ" value="pj"> Persona Jurídica<i class="input-helper rounded"></i>
                    </label>
                </div> -->

                <!-- <div class="form-group" id="pf">
                    <label for="importe">Nombre Completo de la Persona</label>
                    <input type="text" class="form-control" id="persFisic" name="persFisic" placeholder="Ingrese el nombre completo de la persona">
                </div> -->
                <!-- <div class="form-group" id="pj">
                    <label for="institucion"> Seleccione la Institucion</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="institucion" name="institucion">
                        <option selected value="">seleccione una Institucion.....</option>
                        <?php while ($institucion = mysqli_fetch_array($instituciones)) { ?>
                            <option value="<?php echo $institucion['Codigo']; ?>"><?php echo $institucion['Institucion']."/".$institucion['Departamento']; ?></option>
                        <?php } ?>
                    </select>
                </div> -->

                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="./entradas.php" class="btn btn-light">CANCELAR</a>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        document.getElementById("descrip").value("hola mundo")
       $("#pf").hide();
       $("#pj").hide();

       $(function (){
        $("#perF").change(function(){
            if (!$(this).prop('checked')) {
                $("#pf").hide();
            }else{
                $("#pf").show();
                $("#pj").hide();
            }
        });
       });

       $(function (){
        $("#perJ").change(function(){
            if (!$(this).prop('checked')) {
                $("#pj").hide();
            }else{
                $("#pj").show();
                $("#pf").hide();
            }
        });
       });
     

    });
</script>