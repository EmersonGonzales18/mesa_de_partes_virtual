<?php
require_once("../../config/config.php");
require_once("../../config/conexion.php");
require_once("../../models/Rol.php");

$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "nuevotramite");

if (isset($_SESSION["usu_id"]) and count($datos)>0) {
?>

    <!doctype html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Nuevo Trámite | Mesa de Partes Virtual - DREI</title>
        <?php require_once("../html/head.php"); ?>
        <link href="<?php echo BASE_URL . 'assets/css/dropzone.min.css'; ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo BASE_URL . 'assets/css/sweetalert2.min.css'; ?>" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            textarea {
                resize: none;
            }

            .dropzone {
                border: 2px dashed #6f6f6f;
            }
        </style>
    </head>

    <body>

        <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">


            <?php require_once("../html/header.php"); ?>

            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once("../html/menu.php"); ?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <form method="post" id="document_form">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Nuevo Tramite</h4>
                                        <!-- Paginador -->
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . 'views/home/index.php'; ?>">Inicio</a></li>
                                                <li class="breadcrumb-item active">Nuevo Tramite</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Informacion del Solicitante</h4>
                                                <p class="card-title-desc">(*) Datos obligatorios. </p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">Tipo (*)</label>
                                                            <select class="form-select" data-trigger="" name="tipo_id" id="tipo_id" placeholder="Seleccionar" required>
                                                                <option value="">Seleccionar</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">DNI / RUC (*)</label>
                                                            <input class="form-control" type="text" value="" name="doc_dni" id="doc_dni" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">Nombre / Razon Social (*)</label>
                                                            <input class="form-control" type="text" value="" name="doc_nombres" id="doc_nombres" required>
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
                                                <p class="card-title-desc">(*) Campos Obligatorios.
                                                </p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label" id="area">Area (*)</label>
                                                            <select class="form-select" data-trigger="" name="area_id" id="area_id" placeholder="Seleccione" required>
                                                                <option value="">Seleccionar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">Tipo de Tramite (*)</label>
                                                            <select class="form-select" data-trigger="" name="tram_id" id="tram_id" placeholder="Seleccione" required>
                                                                <option value="">Seleccionar</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">Folios (*)</label>
                                                            <input class="form-control" type="number" value="" name="doc_folios" id="doc_folios" min="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-2">
                                                            <label for="form-label" class="form-label">Descripcion (*)</label>
                                                            <textarea class="form-control" type="text" value="" rows=3 name="doc_descr" id="doc_descr" required></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div>
                                                            <div class="mb-2">
                                                                <label for="form-label" class="form-label">Documentos de Sustento</label>
                                                                <p class="card-title-desc">Solo se aceptan documentos en formato pdf. Peso máximo: 10 MB. </p>
                                                            </div>

                                                            <div action="#" class="dropzone">
                                                                <div class="fallback">
                                                                    <input name="file" type="file" multiple="multiple">
                                                                </div>
                                                                <div class="dz-message needsclick">
                                                                    <div class="mb-2">
                                                                        <i class="display-4 text-muted bx bx-cloud-upload"></i>
                                                                    </div>

                                                                    <h5>Arrastrar archivos aquí o hacer click para subir.</h5>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-2 mt-3">
                                                            <label for="form-label" class="form-label">Si tus archivos pesan más de 10 MB, puedes dejarnos un link de descarga (Opcional)</label>
                                                            <input class="form-control" type="text" value="" name="doc_link" id="doc_link">
                                                        </div>

                                                        <div class="d-flex flex-wrap gap-2 mt-4">
                                                            <button type="button" id="btnlimpiar" class="btn btn-secondary waves-effect waves-light">Limpiar</button>
                                                            <button type="submit" id="btnenviar" class="btn btn-primary waves-effect waves-light">Enviar</button>

                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>
                            </form>
                        </div>
                        <!-- end page title -->
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


                <?php require_once("../html/footer.php"); ?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <?php require_once("../html/sidebar.php"); ?>
        <!-- /Right-bar -->
        <?php require_once("../home/modal_video.php"); ?>
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo BASE_URL . 'assets/js/jquery.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/bootstrap.bundle.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/metisMenu.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/simplebar.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/waves.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/feather.min.js'; ?>"></script>
        <!-- pace js -->
        <script src="<?php echo BASE_URL . 'assets/js/pace.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/sweetalert2.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/app.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/dropzone.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/choices.min.js'; ?>"></script>

        <script type="text/javascript" src="nuevoTr.js"></script>

        <!-- <script>
                window.onload = function() {
                // Obtenemos la fecha y hora actual
                var now = new Date();
                var dayOfWeek = now.getDay(); // 0 para domingo, 1 para lunes, ..., 6 para sábado
                var hour = now.getHours();
                var min = now.getMinutes();
                //Falta poner los minutos
                // Verificamos si es un día laborable (lunes a viernes) y está dentro del horario de atención (8 am a 4 pm)
                if (dayOfWeek >= 1 && dayOfWeek <= 5 && hour >= 8 && hour < 16 ) {
                    // Habilitamos el formulario
                    document.getElementById("document_form").removeAttribute("disabled");
                } else {
                    // Deshabilitamos el formulario
                    Swal.fire({
                        title: "El horario de atención es de",
                        text: "Lunes-Viernes 08:00 AM - 04:30 PM",
                        icon: "info"
                    });
                    var myForm = document.getElementById("document_form");

                    // Para deshabilitar todo el formulario
                    myForm.style.pointerEvents = "none";
                    myForm.style.opacity = "0.5";
                }
            }
        </script> -->
    </body>

    </html>
<?php
} else {
    header("Location:" . Conectar::rutas() . "index.php");
}
?>