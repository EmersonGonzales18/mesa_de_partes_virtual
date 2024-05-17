<style>
    textarea {
                resize: none;
    }
</style>
<div id="mnt_tramite_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Todos los campos son obligatorios (*)</p>
                <form method="post" id="mnt_tramite_form">
                <input type="hidden" id="tram_id" name="tram_id">
                <div class="mb-2">
                <label for="form-label" class="form-label">Nombre (*)</label>
                <input class="form-control" type="text" value="" name="tram_nom" id="tram_nom" required>
                </div>
                <div class="mb-2">
                <label for="form-label" class="form-label">Descripcion (*)</label>
                <textarea class="form-control" type="text" value="" name="tram_desc" id="tram_desc" rows="3" required></textarea>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
        
    </div>
</div>
