<?php
    require_once ("config/config.php");
    require_once ("config/conexion.php");
    require_once ("views/html/head.php");
    require_once ("views/html/js.php");
    //TODO: Si es diferente de vacio
    if(isset($_POST["enviar"]) and $_POST["enviar"]=="si" ){
        require_once ("models/Usuario.php");
        $usuario = new Usuario();
        $usuario->login();
    }
?>
<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <title>Iniciar Sesión | Mesa de Partes Virtual - DREI</title>

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
                                        <a href="" class="d-block auth-logo">
                                            <img src="<?php echo BASE_URL . 'assets/picture/logo-sm-1.svg';?>" alt="" height="28"> <span class="logo-txt">Minia</span>
                                        </a>
                                    </div>
                                    <div class="auth-content my-auto">
                                        <div class="text-center">
                                            <h5 class="mb-0">Mesa de Partes</h5>
                                            <p class="text-muted mt-2">Ingrese sus credenciales.</p>
                                        </div>
                                        <form class="custom-form mt-4 pt-2" action="" method="post">
                                            <?php
                                            if(isset($_GET["m"])){
                                                switch($_GET["m"]){
                                                    case "1":
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <i class="mdi mdi-block-helper me-2"></i>
                                                            Correo electronico invalido!
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <?php
                                                        break;
                                                    case "2":
                                                        ?>
                                                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                                        <i class="mdi mdi-alert-outline me-2"></i>
                                                        Rellene los campos!
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <?php
                                                        break;
                                                    case "3":
                                                        ?>
                                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                            <i class="mdi mdi-block-helper me-2"></i>
                                                            Contraseña incorrecta!
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>
                                                        <?php
                                                        break;
                                                }
                                            }

                                            ?>
                                            <div class="mb-3">
                                                <label class="form-label">Correo Electronico</label>
                                                <input type="email" class="form-control" id="usu_correo" name="usu_correo" placeholder="example@gmail.com">
                                            </div>
                                            <div class="mb-3">
                                                <div class="d-flex align-items-start">
                                                    <div class="flex-grow-1">
                                                        <label class="form-label">Contraseña</label>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <div class="">
                                                            <a href="<?php echo BASE_URL . 'views/recover/index.php';?>" class="text-muted">Olvidaste tu contraseña?</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="input-group auth-pass-inputgroup">
                                                    <input type="password" class="form-control" id="usu_pass" name="usu_pass" placeholder="******" aria-label="Password" aria-describedby="password-addon">
                                                    <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                                </div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="remember-check">
                                                        <label class="form-check-label" for="remember-check">
                                                            Recuerdame
                                                        </label>
                                                    </div>  
                                                </div>
                                                
                                            </div>
                                            <div class="mb-3">
                                                <input type="hidden" name="enviar" value="si" id="enviar">
                                                <button class="btn btn-primary w-100 waves-effect waves-light" type="submit">Acceder</button>
                                            </div>
                                        </form>

                                        <div class="mt-4 pt-2 text-center">
                                            <div class="signin-other-title">
                                                <h5 class="font-size-14 mb-3 text-muted fw-medium">- Ingresar con -</h5>
                                            </div>

                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <!-- Parametros para el boton de inicio de sesion de google-->
                                                    <div    id="g_id_onload" 
                                                            data-client_id="1063275048175-9fs6t4o90i8itq7160s112spko47mkkv.apps.googleusercontent.com" 
                                                            data-context="signin"
                                                            data-ux_mode="popup"
                                                            data-callback="handleCredentialResponse"
                                                            data-auto_prompt="false">
                                                        </div>
                                                    <!-- Parametros para la configuracion del boton de inicio de sesion de google-->
                                                <div    class="g_id_signin" 
                                                            data-type="standard"
                                                            data-shape="circle"
                                                            data-theme="outline"
                                                            data-size="medium"
                                                            data-text="signin_with"
                                                            data-logo_alignment="left"
                                                            
                                                            >
                                                </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="text-muted mb-0">No tienes una cuenta ? <a href="<?php echo BASE_URL . 'views/register/index.php';?>" class="text-primary fw-semibold"> Registrate ahora </a> </p>
                                        </div>
                                    </div>
                                    <div class="mt-4 mt-md-5 text-center">
                                        <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Informática. <i class="mdi mdi-heart text-danger"></i> Teams</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end auth full page content -->
                    </div>
                    <!-- end col -->
                    <?php require_once("views/html/carrusel.php")?>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container fluid -->
        </div>


        
        <!-- password addon init -->
        <script src="<?php echo BASE_URL . 'assets/js/pass-addon.init-1.js';?>"></script>
        <!-- API de Google Sign-In de manera asincrona-->
        <script src="https://accounts.google.com/gsi/client"></script>

        <script src="google_login.js"></script>
    </body>

</html>