<?php
    require_once ("../../config/config.php");
    require_once ("../../config/conexion.php");
    require_once("../../models/Rol.php");

    $rol = new Rol();
    $datos = $rol->validar_menu_x_rol($_SESSION["rol_id"], "iniciopersonal");

    if (isset($_SESSION["usu_id"]) and count($datos)>0) {
?>

<!doctype html>
<html lang="en">

    <head>
        
        <meta charset="utf-8">
        <title>Inicio Personal | Mesa de Partes Virtual - DREI</title>
        <?php require_once ("../html/head.php"); ?>

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
                                    <h4 class="mb-sm-0 font-size-18">Inicio Personal</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                                            <li class="breadcrumb-item active">Starter Page</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->

                
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
        <?php require_once ("../html/js.php");?>

    </body>
</html>
<?php
    }else{
        header("Location:". Conectar::rutas()."index.php");
    }
?>