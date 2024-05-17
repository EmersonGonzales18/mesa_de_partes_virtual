<?php
    require_once ("../../config/config.php");
    require_once ("../html/head.php");
    require_once ("../html/js.php");
?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Recover Password | Minia - Minimal Admin & Dashboard Template</title>
    </head>

    <body>

    <!-- <body data-layout="horizontal"> -->
        <div class="auth-page">
            <div class="container-fluid p-0">
                <div class="row g-0">
                    <div class="col-xxl-3 col-lg-4 col-md-5">
                        <div class="auth-full-page-content d-flex p-sm-5 p-4">
                            <div class="w-100">
                                <div class="d-flex flex-column h-100">
                                    <div class="mb-4 mb-md-5 text-center">
                                        <a href="index.html" class="d-block auth-logo">
                                            <img src="<?php echo BASE_URL . 'assets/picture/logo-sm.svg';?>" alt="" height="28"> <span class="logo-txt">Minia</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Recuperar Contraseña</h5>
                                            <p class="text-muted mt-2">Recuperar su Contraseña de Mesa de Partes</p>
                                        </div>
                                        <div class="alert alert-success text-center mb-4 mt-4 pt-2" role="alert">
                                            Ingrese su Correo Electronico y siga las instrucciones!
                                        </div>
                                        <form class="custom-form mt-4">
                                            <div class="mb-3">
                                                <label class="form-label">Correo Electronico</label>
                                                <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="alguien@gmail.com">
                                            </div>
                                            <div class="mb-3 mt-4">
                                                <a class="btn btn-primary w-100 waves-effect waves-light"  id="btn_recuperar">Recuperar</a>
                                            </div>
                                        </form>

                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">Regrsar a  <a href="<?php echo BASE_URL . 'index.php';?>" class="text-primary fw-semibold"> Acceder </a> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Minia   . Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    
                    <?php require_once("../html/carrusel.php")?>
                    
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

        
        <script type="text/javascript" src="recuperar.js"></script>
    </body>

</html>