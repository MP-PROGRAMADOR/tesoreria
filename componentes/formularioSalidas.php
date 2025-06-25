<?php
// obteniendo el ultimo registro de la base de datos
$sql_numero="SELECT * FROM salidas ORDER BY id DESC LIMIT 1";
$sql_resultado= mysqli_query($conn, $sql_numero);
$fila_numero= mysqli_fetch_assoc($sql_resultado);



$numero_instituciones= mysqli_num_rows($sql_resultado);

if($numero_instituciones==0){
    $fech=date("Y");
    
  
   $ultimo_registro1= 1;
   $ultimo_registro="-".$fech;
}else{

    //sumando el primero numero del registro 1 ;
$ultimo_registro= substr($fila_numero['NumRegistro'],0,1);
$ultimo_registro1= $ultimo_registro +1;

$ultimo_registro= substr($fila_numero['NumRegistro'],1,6);

}

// //sumando el primero numero del registro 1 ;
// $ultimo_registro= substr($fila_numero['NumRegistro'],0,1);
// $ultimo_registro1= $ultimo_registro +1;

// $ultimo_registro= substr($fila_numero['NumRegistro'],1,6);
?> 

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <div class="row">
                <div class="col-lg-6">
                <h4 class="card-title">FORMULARIO DE REGISTRO DE SALIDAS</h4>
                </div>
                <div class="col-lg-6">
                <h4 class="card-title text-success">Siguiente Registro: <?php  echo $ultimo_registro1 . $ultimo_registro;   ?></h4>
                </div>
            </div>
            <form class="forms-sample" method="POST" action="../php/guardar_salidas.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="TipoDoc">Tipo de Documento</label>
                    <input type="text" class="form-control" id="TipoDoc" name="TipoDoc" placeholder="Ejemplo carta...">
                </div>
                <div class="form-group">
                    <label for="ckeditor">Descripción</label>
                    <textarea name="descripcion" id="ckeditor" class="form-control ckeditor" id="" cols="30" rows="15" placeholder="Descripcion del documento"></textarea>
                </div>
                <div class="form-group">
                    <label for="palabrasClaves">Palabras Claves del Documento</label>
                    <input type="text" class="form-control" id="palabrasClaves" name="palabrasClaves" placeholder="Ejemplo solicitud de...">
                </div>
                <div class="form-group">
                    <label for="fechaFirma">¿Cuando de Firmo el documento?</label>
                    <input type="date" class="form-control" id="fechaFirma" name="fechaFirma" placeholder="Ejemplo solicitud de...">
                </div>
                <div class="form-group">
                    <label for="importe">Importe</label>
                    <input type="text" class="form-control" id="importe" name="importe" placeholder="Ejemplo 1.000.000">
                </div>
                <div class="form-group" id="">
                    <label for="institucion"> Seleccione la Referencia</label>
                    <select class="form-control" id="ref" name="ref">
                        <option selected value="">seleccione una referencia.....</option>
                        <?php while ($referencia = mysqli_fetch_array($referencias)) { ?>
                            <option value="<?php echo $referencia['Id']; ?>"><?php echo $referencia['Codigo'] . " / " . $referencia['Nombre']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="archivo">Selecciona el Documento</label>
                    <input type="file" class="form-control" id="archivo" name="archivo" placeholder="Ejemplo solicitud de...">
                </div>
                <label for="institucion">Se envia a...</label>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="perFS" value="pf"> Una Persona Física<i class="input-helper rounded"></i>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="perJS" value="pj"> Una Persona Jurídica<i class="input-helper rounded"></i>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="procede" type="radio" id="vperJS" value="pj"> Varias Persona Jurídica<i class="input-helper rounded"></i>
                    </label>
                </div>

                <div class="form-group" id="pfs">
                    <label for="importe">Nombre Completo de la Persona</label>
                    <input type="text" class="form-control" id="persFisic" name="persFisic" placeholder="Ingrese el nombre completo de la persona">
                </div>
                <div class="form-group" id="pjs">
                    <label for="institucion"> Seleccione la Institucion</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="institucion" name="institucion">
                        <option selected value="">seleccione una Institucion.....</option>
                        <?php while ($institucion = mysqli_fetch_array($instituciones)) { ?>
                            <option value="<?php echo $institucion['Codigo']; ?>"><?php echo $institucion['Institucion'] . "/" . $institucion['Departamento']; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group" id="vpjs">
                    <?php
                    $queryDpto = "SELECT departementos.id AS CodDpto, departementos.Nombre AS NomDpto, instituciones.Nombre_Corto AS NomInsti 
                    FROM departementos INNER JOIN instituciones ON departementos.Institucion = instituciones.Id WHERE departementos.Institucion != 1 ORDER BY instituciones.Nombre ASC;";
                    $ResultDpto = $conn->query($queryDpto);
                    ?>
                    <label for="instiDepart"><h5>Institución y Sección</h5></label>
                    <?php while ($DptoInst = mysqli_fetch_array($ResultDpto)) { ?>
                        <div class="form-group">
                            <input type="checkbox" id="instiDepart<?php echo $DptoInst['CodDpto']; ?>" name="instiDepart[]" value="<?php echo $DptoInst['CodDpto']; ?>">
                            <label for="instiDepart<?php echo $DptoInst['CodDpto']; ?>"><?php echo $DptoInst['NomInsti'] . "/" . $DptoInst['NomDpto']; ?></label>
                        </div>
                    <?php } ?>
                </div>

                <label for="institucion">¿Tuvo una Entrada</label>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="entrada" type="radio" id="si" value=""> Sí<i class="input-helper rounded"></i>
                    </label>
                </div>
                <div class="form-group">
                    <label class="form-check-label">
                        <input class="checkbox" name="entrada" type="radio" id="no" value="No tuvo una entrada"> No<i class="input-helper rounded"></i>
                    </label>
                </div>

                <div class="form-group" id="entradas">
                    <label for="selectEntradas"> Seleccione la Entrada</label>
                    <select class="form-control" aria-label=".form-select-lg example" id="selectEntradas" name="selEntrada">
                        <?php
                        $qEntrad = "SELECT NumRegistro, TipoDoc FROM Entradas";
                        $resultEntr = mysqli_query($conn, $qEntrad);
                        ?>
                        <option selected value="No tuvo una entrada">seleccione una Entrada.....</option>
                        <?php while ($entra = mysqli_fetch_array($resultEntr)) { ?>
                            <option value="<?php echo $entra['NumRegistro']; ?>"><?php echo $entra['NumRegistro'] . "/" . $entra['TipoDoc']; ?></option>
                        <?php } ?>
                    </select>
                </div>



                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="./salidas.php" class="btn btn-light">CANCELAR</a>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#pfs").hide();
        $("#pjs").hide();
        $("#vpjs").hide();
        $("#entradas").hide();

        //    $("#ref").select2();

        $(function() {
            $("#perFS").change(function() {
                if (!$(this).prop('checked')) {
                    $("#pfs").hide();
                } else {
                    $("#pfs").show();
                    $("#persFisic").focus();
                    $("#pjs").hide();
                    $("#vpjs").hide();
                    $("#entradas").hide();
                }
            });
        });

        $(function() {
            $("#perJS").change(function() {
                if (!$(this).prop('checked')) {
                    $("#pjs").hide();
                } else {
                    $("#pjs").show();
                    $("#institucion").focus();
                    $("#pfs").hide();
                    $("#vpjs").hide();
                    $("#entradas").hide();
                }
            });
        });

        $(function() {
            $("#vperJS").change(function() {
                if (!$(this).prop('checked')) {
                    $("#vpjs").hide();
                } else {
                    $("#vpjs").show();
                    $("#pfs").hide();
                    $("#pjs").hide();
                    $("#entradas").hide();
                }
            });
        });

        $(function() {
            $("#si").change(function() {
                if (!$(this).prop('checked')) {
                    $("#entradas").hide();
                } else {
                    $("#entradas").show();
                    $("#selectEntradas").focus();
                    // $("#pfs").hide();
                    // $("#pjs").hide();
                    // $("#vpjs").hide();
                }
            });
        });

        $(function() {
            $("#no").change(function() {
                if (!$(this).prop('checked')) {
                    $("#entradas").hide();
                } else {
                    $("#entradas").hide();
                }
            });
        });


    });
</script>