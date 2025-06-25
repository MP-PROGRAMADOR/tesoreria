<!-- Modal -->
<div class="modal fade" id="eliminaModalInstitucion" tabindex="-1" aria-labelledby="eliminaModalInstitucionLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eliminaModalInstitucionLabel">AVISO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Desea eliminar este Registro?
                
            </div>

            <div class="modal-footer">

            <form action="../php/eliminar_Instituciones.php" method="POST" >

            <input type="hidden" name="Id" id="Id">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">CANCELAR</button>
             <button type="submit" class="btn btn-primary btn-sm">ACEPTAR</button>

                </form>


            </div>

        </div>
    </div>
</div>