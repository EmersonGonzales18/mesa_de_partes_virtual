<?php
    require_once ("../../config/config.php");
    require_once ("../../config/conexion.php");
    require_once ("../html/head.php");
    require_once ("../html/js.php");
?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Email Verification | Minia - Minimal Admin & Dashboard Template</title>
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
                                            <div class="avatar-lg mx-auto">
                                                <div class="avatar-title rounded-circle bg-light">
                                                    <i class="bx bxs-envelope h2 mb-0 text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="p-2 mt-4">
                                                <h4>Verifique su correo</h4>
                                                <p>Le hemos enviado un correo de verificacion<span class="fw-bold">, Por favor verifique su bandeja</p>
                                                <div class="mt-4">
                                                    <a href="https://accounts.google.com/AccountChooser/signinchooser?service=mail&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&flowName=GlifWebSignIn&flowEntry=AccountChooser&ec=asw-gmail-globalnav-signin&theme=glif"  class="btn btn-primary w-10">Verifica tu email</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 text-center">
                                            <p class="text-muted mb-0">Did't receive an email ? <a href="#" class="text-primary fw-semibold"> Resend </a> </p>
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
                    <!-- end col -->
                    <?php require_once("../html/carrusel.php")?>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>

    </body>
    <script src="verify.js"></script>
</html>