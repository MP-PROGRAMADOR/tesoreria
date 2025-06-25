<div class="col-lg-4">
    
    <div class="card shadow">
        <div class="card-body">
        <p class="text-center"> <b>REPORTES DE ENTRADA</b> </p>

            <form class="forms-sample" method="POST" action="../fpdf/entradas_filtro.php" enctype="multipart/form-data" target="__blanck">

                <div class=" form-group  mt'2">
                    <label for="fecha">Por Dia</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="form-group mt'2">
                    <label for="fecha">Por Mes</label>
                    <select id="mes" name="mes" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>

                <div class="form-group mt'2">
                    <label for="ano">Por Año</label>
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="Pon el Año aqui">
                </div>

                <button type="submit" class="btn btn-warning me-2"> <i class="mdi mdi-printer"></i></button>
            <a href="./entradas.php" class="btn btn-danger">CANCELAR</a>

            </form>


        </div>
    </div>
</div>


<div class="col-lg-4">
    
    <div class="card shadow">
        <div class="card-body">
        <p class="text-center"> <b>REPORTES DE SALIDAS</b> </p>

            <form class="forms-sample" method="POST" action="../fpdf/salidas_filtro.php" enctype="multipart/form-data" target="__blanck">

                <div class=" form-group  mt'2">
                    <label for="fecha">Por Dia</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="form-group mt'2">
                    <label for="fecha">Por Mes</label>
                    <select id="mes" name="mes" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>


                <div class="form-group mt'2">
                    <label for="ano">Por Año</label>
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="Pon el Año aqui">
                </div>

                <button type="submit" class="btn btn-warning me-2"> <i class="mdi mdi-printer"></i></button>
            <a href="./entradas.php" class="btn btn-danger">CANCELAR</a>

            </form>


        </div>
    </div>
</div>

<div class="col-lg-4">
    
    <div class="card shadow">
        <div class="card-body">

        <p class="text-center"> <b>REPORTES DE DECRETOS</b> </p>

            <form class="forms-sample" method="POST" action="../fpdf/decretos_filtro.php" enctype="multipart/form-data" target="__blanck">

                <div class=" form-group  mt'2">
                    <label for="fecha">Por Dia</label>
                    <input type="date" class="form-control" id="fecha" name="fecha">
                </div>
                <div class="form-group mt'2">
                    <label for="fecha">Por Mes</label>
                    <select id="mes" name="mes" class="form-select">
                        <option value="">--Seleccione--</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SEPTIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>


                <div class="form-group mt'2">
                    <label for="ano">Por Año</label>
                    <input type="text" class="form-control" id="ano" name="ano" placeholder="Pon el Año aqui">
                </div>

                <button type="submit" class="btn btn-warning me-2"> <i class="mdi mdi-printer"></i></button>
            <a href="./entradas.php" class="btn btn-danger">CANCELAR</a>

            </form>


        </div>
    </div>
</div>







<script>
    $(document).ready(function() {
        $("#pf").hide();
        $("#pj").hide();

        $(function() {
            $("#perF").change(function() {
                if (!$(this).prop('checked')) {
                    $("#pf").hide();
                } else {
                    $("#pf").show();
                    $("#persFisic").focus();
                    $("#pj").hide();
                }
            });
        });

        $(function() {
            $("#perJ").change(function() {
                if (!$(this).prop('checked')) {
                    $("#pj").hide();
                } else {
                    $("#pj").show();
                    $("#institucion").focus();
                    $("#pf").hide();
                }
            });
        });


    });
</script>