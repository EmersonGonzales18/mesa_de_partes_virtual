<div id="modal_documento" class="modal fade" tabindex="-1" aria-labelledby="exampleModalFullscreenLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="card-title" id="lblmodal"></h4>
                <h4 class="card-title" id="lblmodal"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Información General</h4>
                                <div class="row">
                                    <p class="card-title-desc col-lg-3"><strong>Usuario : </strong> <span id="nombre_usuario"></span></p>
                                    <p class="card-title-desc col-lg-3"><strong>Correo : </strong> <span id="correo_usuario"></span></p>
                                    <p class="card-title-desc col-lg-3"><strong>Documentos Adjuntos : </strong><span id="adjuntos"></span></p>
                                    <p class="card-title-desc col-lg-3"><strong>Estado : </strong><span id="estado_doc"></span></p>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Informacion del Solicitante</h4>
                                <p class="card-title-desc">Datos personales. </p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Tipo</label>
                                            <input class="form-control " type="text" value="" name="usu_tipo" id="usu_tipo" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">DNI / RUC</label>
                                            <input class="form-control" type="text" value="" name="doc_dni" id="doc_dni" readonly>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Nombre / Razon Social</label>
                                            <input class="form-control" type="text" value="" name="doc_nombres" id="doc_nombres" readonly>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Descripcion de la Solicitud</h4>
                                <p class="card-title-desc">Detalles de la petición. </p>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label" id="area">Area</label>
                                            <input class="form-control" type="text" value="" name="area_nom" id="area_nom" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Tipo de Tramite</label>
                                            <input class="form-control" type="text" value="" name="tram_nom" id="tram_nom" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Folios</label>
                                            <input class="form-control" type="text" value="" name="doc_folios" id="doc_folios" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Descripcion</label>
                                            <textarea class="form-control " type="text" value="" rows=2 name="doc_descr" id="doc_descr" readonly></textarea>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Documentos adjuntos</label>
                                            <table id="listado_detalle_documento" class="table table-bordered table-sm  dt-responsive nowrap w-100">

                                                <thead>
                                                    <tr>
                                                        <th>Nombre Documento</th>
                                                        <th>Usuario</th>
                                                        <th>Perfil</th>
                                                        <th>Fecha Creación</th>
                                                        <th>Descargar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Enlace para mas documentos </label>
                                            <input class="form-control" type="text" value="" name="doc_link" id="doc_link" readonly>
                                        </div>
                                    </div>



                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Respuesta al Usuario</h4>
                                <p class="card-title-desc">Dar respuesta al usuario según crea correspondiente. </p>
                            </div>
                            <input type="hidden" id="doc_id" name="doc_id" value="doc_id">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-2">
                                                <label for="form-label" class="form-label">Respuesta</label>
                                                <textarea class="form-control" type="text" placeholder="Escriba aquí la respuesta del trámite" value="" rows=2 name="doc_respuesta" id="doc_respuesta" readonly></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                        <div class="mb-2">
                                            <label for="form-label" class="form-label">Documentos adjuntos(Respuesta)</label>
                                            <table id="listado_detalle_documento_respuesta" class="table table-bordered table-sm  dt-responsive nowrap w-100">

                                                <thead>
                                                    <tr>
                                                        <th>Nombre Documento</th>
                                                        <th>Usuario</th>
                                                        <th>Perfil</th>
                                                        <th>Fecha Creación</th>
                                                        <th>Descargar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        </div>

                                        <div class="d-flex flex-wrap gap-2 mt-4 justify-content-end">
                                            <button type="button" id="btnlimpiar" class="btn btn-primary waves-effect waves-light">Cerrar</button>


                                        </div>
                                    </div>

                                </div>
                          
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>