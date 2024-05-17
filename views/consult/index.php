<?php
require_once("../../config/config.php");
require_once("../../config/conexion.php");

require_once("../../models/Rol.php");

$rol = new Rol();
$datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "consultartramite");

if (isset($_SESSION["usu_id"]) and count($datos)>0) {

?>

    <!doctype html>
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Consultar Trámites | Mesa de Partes Virtual - DREI</title>
        <?php require_once("../html/head.php"); ?>
        <!-- DataTables -->
        <link href="<?php echo BASE_URL . 'assets/css/dataTables.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo BASE_URL . 'assets/css/buttons.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">

        <!-- Responsive datatable examples -->
        <link href="<?php echo BASE_URL . 'assets/css/responsive.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">
        <style>
          .dt-buttons .btn-group{
            margin: 20px;
            }

        </style>
    </head>

    <body>

        <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <!-- Left Sidebar End -->

            <?php require_once("../html/header.php"); ?>

            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once("../html/menu.php"); ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div>
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18">Consultar Tramite</h4>
                                        <!-- Paginador -->
                                        <div class="page-title-right">
                                            <ol class="breadcrumb m-0">
                                                <li class="breadcrumb-item"><a href="<?php echo BASE_URL . 'views/home/index.php'; ?>">Inicio</a></li>
                                                <li class="breadcrumb-item active">Consultar Tramite</li>
                                            </ol>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Listado de Tramites</h4>
                                                <p class="card-title-desc">Tramites realizados por el usuario. </p>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                </div>
                                                <table id="listado_table" class="table table-bordered dt-responsive nowrap w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>Nª Tramite</th>
                                                                <th>Area</th>
                                                                <th>Tipo de Tramite</th>
                                                                <th>Razon Social</th>
                                                                <th>DNI/RUC</th>  
                                                                <th>Nombres</th>  
                                                                <th>Estado</th>  
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>


                                                        <tbody>
                                                        </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
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

        <?php require_once("../home/modal_video.php"); ?>
        <?php require_once("modal_documento.php"); ?>
        <!-- /Right-bar -->
        <?php require_once("../html/sidebar.php"); ?>
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

        <!-- Required datatable js -->
        <script src="<?php echo BASE_URL . 'assets/js/jquery.dataTables.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/dataTables.bootstrap4.min.js'; ?>"></script>

        <script src="<?php echo BASE_URL . 'assets/js/datatables.init.js'; ?>"></script>
        <!-- Buttons examples -->
        <script src="<?php echo BASE_URL . 'assets/js/dataTables.buttons.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/buttons.bootstrap4.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/jszip.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/pdfmake.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/vfs_fonts.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/buttons.html5.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/buttons.print.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/buttons.colVis.min.js'; ?>"></script>

        <!-- Responsive examples -->
        <script src="<?php echo BASE_URL . 'assets/js/dataTables.responsive.min.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/responsive.bootstrap4.min.js'; ?>"></script>

        


        <script src="ConsultarTr.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:" . Conectar::rutas() . "index.php");
}
?>