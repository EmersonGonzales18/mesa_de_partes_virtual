<?php
require_once("../../config/config.php");
require_once("../html/head.php");
require_once("../html/js.php");
?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Registrar | Mesa de Partes Virtual - DREI</title>

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
                                <div class="mb-4 mb-md-4 text-center">
                                    <a href="index.html" class="d-block auth-logo">
                                        <img src="<?php echo BASE_URL . 'assets/picture/logo-sm.svg'; ?>" alt="" height="28"> <span class="logo-txt">Minia</span>
                                    </a>
                                </div>
                                <div class="auth-content my-auto">
                                    <div class="text-center">
                                        <h5 class="mb-0">Registrar Cuenta</h5>
                                        <p class="text-muted mt-2">Consigue tu cuenta gratuita ahora.</p>
                                    </div>
                                    <form id="mnt_form" class="needs-validation custom-form mt-4 pt-2" novalidate="" action="index.html">
                                        <div class="mb-3">
                                            <label for="usu_correo" class="form-label">Correo Electronico</label>
                                            <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="alguien@gmail.com" required="">
                                            <div class="validation-error text-danger"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="usu_nombres" class="form-label">Nombres y Apellidos</label>
                                            <input type="text" class="form-control" id="usu_nombres" name="usu_nombres" placeholder="Nombres" required="">
                                            <div class="validation-error text-danger"></div>
                                        </div>



                                        <div class="mb-3">
                                            <label for="usu_pass" class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="Contraseña" required="">
                                            <div class="validation-error text-danger"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="usu_passmatch" class="form-label">Confirmar Contraseña</label>
                                            <input type="password" class="form-control" id="usu_passmatch" name="usu_passmatch" placeholder="Repetir Contraseña" required="">
                                            <div class="validation-error text-danger"></div>
                                        </div>

                                        <div class="mb-4">
                                            
                                        </div>
                                        <div class="mb-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light" id="registroButton" type="submit">Registrarse</button>
                                        </div>
                                    </form>
                                    <div class="mt-4 text-center">
                                        <p class="text-muted mb-0">Ya tiene una cuenta ? <a href="<?php echo BASE_URL . 'index.php'; ?>" class="text-primary fw-semibold"> Acceder </a> </p>
                                    </div>
                                </div>
                                <div class="mt-4 mt-md-4 text-center">
                                    <p class="mb-0">© <script>
                                            document.write(new Date().getFullYear())
                                        </script> Informática. <i class="mdi mdi-heart text-danger"></i> Teams</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end auth full page content -->
                </div>
                <!-- end col -->
                <?php require_once("../html/carrusel.php") ?>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container fluid -->
        <?php require_once("terminos.php") ?>
    </div>


    <!-- validation init -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/validator/13.6.0/validator.min.js"></script>
    <script type="text/javascript" src="register.js"></script>
</body>

</html>