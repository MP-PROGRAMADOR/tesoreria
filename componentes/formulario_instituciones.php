


<div class="col-md-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">FORMULARIO DE REGISTRO</h4>
            <form class="forms-sample" method="POST" action="../php/guardar_institucion.php">
                <div class="form-group">
                    <label for="nombre">NOMBRE</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="NOMBRE" required>
                </div>
                <div class="form-group">
                    <label for="nombre">NOMBRE CORTO</label>
                    <input type="text" class="form-control" id="nombre_corto" name="nombre_corto" placeholder="NOMBRE CORTO" required>
                </div>
                <button type="submit" class="btn btn-primary me-2">GUARDAR</button>
                <a href="../admin/instituciones.php" class="btn btn-danger me-2">CANCELAR</a>
            </form>
        </div>
    </div>
</div>