<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO DE DECRETOS</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_decreto.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="ckeditor">Descripción del Decreto</label>
                    <textarea name="descripcion" id="ckeditor" class="form-control ckeditor" id="" cols="30" rows="15" placeholder="Descripcion del documento"></textarea>
                </div>
                <label for="institucion">Decreto para...</label>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="perFS" value="pf"> Una Persona Física<i class="input-helper rounded"></i>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="perJS" value="pj"> Miembros<i class="input-helper rounded"></i>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="MPF" value="pj"> Miembros y una Persona Física<i class="input-helper rounded"></i>
                    </label>
                </div>

                <div class="form-group" id="miembros">
                    <?php
                    $queryMiembros = "SELECT * FROM miembros";
                    $ResultMiembros = $conn->query($queryMiembros);
                    ?>
                    <h6 class="card-title">Selecciona Miembros</h6>
                    <?php while ($miembros = mysqli_fetch_array($ResultMiembros)) { ?>
                        <div class="form-group">
                            <input type="checkbox" id="miembro<?php echo $miembros['Id']; ?>" name="miembro[]" value="<?php echo $miembros['Id']; ?>">
                            <label for="miembro<?php echo $miembros['Id']; ?>"><?php echo $miembros['Nombre']; ?></label>
                        </div>
                    <?php } ?>
                </div>


                <div class="form-group" id="pfs">
                    <label for="importe">Nombre Completo de la Persona</label>
                    <input type="text" class="form-control" id="persFisic" name="persFisic34" placeholder="Ingrese el nombre completo de la persona">
                </div>

                <div class="form-group" id="miembrosPF">
                    <?php
                    $queryMiembros = "SELECT * FROM miembros";
                    $ResultMiembros = $conn->query($queryMiembros);
                    ?>
                    <h6 class="card-title">Selecciona Miembros</h6>
                    <?php while ($miembros = mysqli_fetch_array($ResultMiembros)) { ?>
                        <div class="form-group">
                            <input type="checkbox" id="miembro<?php echo $miembros['Id']; ?>" name="miembro[]" value="<?php echo $miembros['Id']; ?>">
                            <label for="miembro<?php echo $miembros['Id']; ?>"><?php echo $miembros['Nombre']; ?></label>
                        </div>
                    <?php } ?>

                    <div class="form-group" id="pfs">
                        <label for="importe">Nombre Completo de la Persona23</label>
                        <input type="text" class="form-control" id="persFisic" name="persFisic" placeholder="Ingrese el nombre completo de la persona">
                    </div>
                </div>

                <div class="form-group">
                    <label for="archivo">Selecciona el Documento</label>
                    <input type="file" class="form-control" id="archivo" name="archivo">
                </div>
                <div class="form-group">
                    <label for="entradaDoc"> Entrada...</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="entradaDoc" name="entradaDoc" required>
                        <option selected value="">seleccione el numero de registro del documento de entrada.....</option>
                        <?php while ($entradas = mysqli_fetch_array($ResultEntradas)) { ?>
                            <option value="<?php echo $entradas['Id']; ?>"><?php echo $entradas['NumRegistro'] . " / " . $entradas['TipoDoc']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="./decretos.php" class="btn btn-light">CANCELAR</a>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#pfs").hide();
        $("#miembros").hide();
        $("#miembrosPF").hide();

        //    $("#ref").select2();

        $(function() {
            $("#perFS").change(function() {
                if (!$(this).prop('checked')) {
                    $("#pfs").hide();
                } else {
                    $("#pfs").show();
                    $("#persFisic").focus();
                    $("#miembros").hide();
                    $("#miembrosPF").hide();
                }
            });
        });

        $(function() {
            $("#perJS").change(function() {
                if (!$(this).prop('checked')) {
                    $("#miembros").hide();
                } else {
                    $("#miembros").show();
                    $("#pfs").hide();
                    $("#miembrosPF").hide();
                }
            });
        });

        $(function() {
            $("#MPF").change(function() {
                if (!$(this).prop('checked')) {
                    $("#miembrosPF").hide();
                } else {
                    $("#miembrosPF").show();
                    $("#pfs").hide();
                    $("#miembros").hide();
                }
            });
        });
    });
</script>