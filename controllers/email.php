<?php
    //TODO: Llamamos a la clase de conexion
    require_once("../config/conexion.php");
    //TODO: Llamamos al modelo usuario
    require_once("../models/Usuario.php");
    require_once("../models/Email.php");

    //TODO: Crea un usario de la clase Usuario
    $usuario = new Usuario();
    $email = new Email();

    //TODO: Determinar que operacion utilizar
    switch($_GET["opcion"]){
        //TODO: Si la operacion es recuperar
        case "recuperar":
            //TODO: Evaluamos el metodo de recuperar email
            $datos = $usuario->get_usuario_correo($_POST["usu_correo"],$_POST["rol_id"]);
            if(is_array($datos)==true and count($datos)==0){
                echo "0";
            }else{
                $email->recuperar($_POST["usu_correo"],$_POST["rol_id"]);
                echo "1";
            }
        break;
    }
    
?>