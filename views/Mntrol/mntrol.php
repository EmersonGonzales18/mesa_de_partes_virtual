<div id="mnt_rol_modal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Todos los campos son obligatorios (*)</p>
                <form method="post" id="mnt_rol_form">
                <input type="hidden" id="rol_id" name="rol_id">
                <div class="mb-3">
                <label for="form-label" class="form-label">Nombre (*)</label>
                <input class="form-control" type="text" value="" name="rol_nombre" id="rol_nombre" required>
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


