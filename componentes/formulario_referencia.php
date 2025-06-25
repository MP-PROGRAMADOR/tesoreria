

<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO DE REFERENCIAS</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_referencia.php">
                <div class="form-group">
                    <label for="nombre">NOMBRE DE LA REFERENCIA</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la Referencia" required>
                </div>
                <div class="form-group">
                    <label for="codigo">CÓDIGO</label>
                    <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código de la Referencia" required>
                </div>
                
                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
               <a href="../admin/miembros.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>