<?php
    require_once ("../../config/config.php");
    require_once ("../../config/conexion.php");
    require_once("../../models/Rol.php");

    $rol = new Rol();
    $datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "mantenimientorol");

    if (isset($_SESSION["usu_id"]) and count($datos)>0) {
?>

<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <title>Mantenimiento Rol de Personal | Mesa de Partes Virtual - DREI</title>
        <?php require_once ("../html/head.php"); ?>
         <!-- DataTables -->
        <link href="<?php echo BASE_URL . 'assets/css/dataTables.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo BASE_URL . 'assets/css/buttons.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo BASE_URL . 'assets/css/sweetalert2.min.css'; ?>" rel="stylesheet" type="text/css">
        <!-- Responsive datatable examples -->
        
        <link href="<?php echo BASE_URL . 'assets/css/responsive.bootstrap4.min.css'; ?>" rel="stylesheet" type="text/css">
    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <?php require_once ("../html/header.php"); ?>

            <!-- ========== Left Sidebar Start ========== -->
            <?php require_once ("../html/menu.php"); ?>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Mantenimiento Rol</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starter Page</li>
                                        </ol>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">Listado de Tipos de Roles (Personal)</h4>
                                                <p class="card-title-desc">(*) Vista para listar, registrar, modificar y eliminar tipos de roles para el personal. </p>
                                            </div>
                                            <div class="card-body">
                                            <button type="button" id="btnuevo" class="btn btn-primary waves-effect waves-light">Nuevo Registro</button>
                                            <br></br>
                                                <div class="row">

                                                </div>
                                                <table id="listado_rol" class="table table-bordered dt-responsive nowrap w-100">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre</th>
                                                                <th>Fecha de Creación</th>
                                                                <th>Fecha de Modificación</th>
                                                                <th>Vistas</th>
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
                <?php require_once ("mntrol.php");?>
                <?php require_once ("mntpermiso.php");?>
                <?php require_once ("../html/footer.php");?>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    
        <!-- Right Sidebar -->
        <?php require_once ("../html/sidebar.php");?>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="<?php echo BASE_URL . 'assets/js/jquery.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/bootstrap.bundle.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/metisMenu.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/simplebar.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/waves.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/feather.min.js';?>"></script>
        <!-- pace js -->
        <script src="<?php echo BASE_URL . 'assets/js/pace.min.js';?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/app.js'; ?>"></script>
        <script src="<?php echo BASE_URL . 'assets/js/sweetalert2.min.js';?>"></script>
    
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
        <script src="mntrol.js"></script>
    </body>
</html>
<?php
    }else{
        header("Location:". Conectar::rutas()."index.php");
    }
?>