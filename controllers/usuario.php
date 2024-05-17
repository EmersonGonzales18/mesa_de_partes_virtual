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
        //TODO: Si la operacion es registrar
        case "registrar":
            //TODO: Evaluamos el metodo de acceder al usuario
            $datos = $usuario->get_usuario_correo($_POST["usu_correo"]);
            if(is_array($datos)==true and count($datos)==0){
                //TODO: Llama al metodo agregar usuario con los datos del formulario
                $datos1 = $usuario ->agregar_usuario($_POST["usu_nombres"],$_POST["usu_correo"],$_POST["usu_pass"],"../../assets/picture/avatar.png",2);
                $email->registrar($datos1[0]['usu_id']);
                echo "1";
            }else{
                echo "0";
            }
            
            break;
        //TODO: Si la operacion es activar
        case "activar":
            //TODO: Accedemos al metodo pasandole el id decodificado
            $usuario ->activar_usuario($_POST["usu_id"]);
            break;
        case "registrarGoogle":
            if($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["CONTENT_TYPE"] == "application/json"){
                //TODO: Recuperar el cuerpo del JSON
                $jsonCadena = file_get_contents('php://input');
                $jsonObjeto = json_decode($jsonCadena);

                if(!empty($jsonObjeto-> request_type) && $jsonObjeto-> request_type == 'user_auth'){
                    $credential = !empty($jsonObjeto->credential) ? $jsonObjeto->credential : '';
                    //TODO: Decodificar el payload de la respuesta desde JWT
                    $partes = explode(".", $credential);

                    $headers = base64_decode($partes[0]);

                    $payload = base64_decode($partes[1]);

                    $signature = base64_decode($partes[2]);

                    $responsePayload = json_decode($payload);

                    if(!empty($responsePayload)){
                        //TODO: Informacion del perfil de google
                        $nombre = !empty($responsePayload-> name) ? $responsePayload-> name : '';
                        $email = !empty($responsePayload-> email) ? $responsePayload-> email : '';
                        $imagen = !empty($responsePayload-> picture) ? $responsePayload-> picture : '';
                    }
                    //TODO: Obtenemos la informacion del correo
                    $datos = $usuario->get_usuario_correo($email);
                    //TODO: Si no trae nada se registra
                    if(is_array($datos)==true and count($datos)==0){
                        $datos1= $usuario ->agregar_usuario($nombre,$email,"",$imagen,1);
                        
                        $usu_id = $datos1[0]["usu_id"];
                        $_SESSION["usu_id"] = $usu_id;
                        $_SESSION["usu_nombres"] = $nombre;
                        $_SESSION["usu_correo"] = $email;
                        $_SESSION["usu_img"] = $imagen;
                        $_SESSION["rol_id"] = 1;
                        echo "1";
                    }else{
                        //TODO: Caso contrario inicia sesion
                        $usu_id = $datos[0]['usu_id'];
                        $_SESSION["usu_id"] = $usu_id;
                        $_SESSION["usu_nombres"] = $nombre;
                        $_SESSION["usu_correo"] = $email;
                        $_SESSION["usu_img"] = $imagen;
                        $_SESSION["rol_id"] = $datos[0]["rol_id"];
                        echo "0";
                    }
                }else{
                    echo json_encode(['error' =>'Datos de la cuenta no disponibles']);
                }

            }
            break;
        case "registrarGooglePersonal": 
            if($_SERVER["REQUEST_METHOD"] === "POST" && $_SERVER["CONTENT_TYPE"] == "application/json"){
                //TODO: Recuperar el cuerpo del JSON
                $jsonCadena = file_get_contents('php://input');
                $jsonObjeto = json_decode($jsonCadena);

                if(!empty($jsonObjeto-> request_type) && $jsonObjeto-> request_type == 'user_auth'){
                    $credential = !empty($jsonObjeto->credential) ? $jsonObjeto->credential : '';
                    //TODO: Decodificar el payload de la respuesta desde JWT
                    $partes = explode(".", $credential);

                    $headers = base64_decode($partes[0]);

                    $payload = base64_decode($partes[1]);

                    $signature = base64_decode($partes[2]);

                    $responsePayload = json_decode($payload);

                    if(!empty($responsePayload)){
                        //TODO: Informacion del perfil de google
                        $nombre = !empty($responsePayload-> name) ? $responsePayload-> name : '';
                        $email = !empty($responsePayload-> email) ? $responsePayload-> email : '';
                        $imagen = !empty($responsePayload-> picture) ? $responsePayload-> picture : '';
                    }
                    //TODO: Obtenemos la informacion del correo
                    $datos = $usuario->get_usuario_correo($email);
                    //TODO: Si no trae nada se registra
                    if(is_array($datos)==true and count($datos)==0){
                        echo "1";
                    }else{
                        //TODO: Caso contrario inicia sesion
                        $usu_id = $datos[0]['usu_id'];
                        $_SESSION["usu_id"] = $usu_id;
                        $_SESSION["usu_nombres"] = $nombre;
                        $_SESSION["usu_correo"] = $email;
                        $_SESSION["usu_img"] = $imagen;
                        $_SESSION["rol_id"] = $datos[0]['rol_id'];
                        echo "0";
                    }
                }else{
                    echo json_encode(['error' =>'Datos de la cuenta no disponibles']);
                }

            }
            break;
        case "listar":
            $datos = $usuario->get_personal();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]=$row["usu_nombres"];
                $sub_array[]=$row["usu_correo"];
                $sub_array[]=$row["rol_nombre"];
                $sub_array[]=$row["fecha_crea"];
                $sub_array[]='<button type="button" class="btn btn-soft-info waves-effect waves-light btn-sm  ml-3" onClick="permiso('.$row["usu_id"].')"><i class="bx bx-shield-quarter font-size-16 align-middle ml-3"></i></button>';
                $sub_array[]='<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm  ml-3" onClick="editar('.$row["usu_id"].')"><i class="bx bx-edit-alt font-size-16 align-middle ml-3"></i></button> <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar('.$row["usu_id"].')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
                $data[] = $sub_array;
            }
            $results = array(
                "sEcho" => 1,
                "iTotalRecords" => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData" => $data
            );
            echo json_encode($results);
            break;
        case "guardaryeditar_personal":
                //TODO: Evaluamos el metodo de acceder al usuario
                $datos = $usuario->get_usuario_correo($_POST["usu_nombres"]);
                
                if(is_array($datos)==true and count($datos)==0){
                    //TODO: Llama al metodo agregar usuario con los datos del formulario
                    if(empty($_POST["usu_id"])){
                        $datos1=$usuario ->insert_personal($_POST["usu_nombres"],$_POST["usu_correo"],$_POST["rol_id"]);
                        $email ->nuevo_personal($datos1[0]["usu_id"]);
                        echo "1";
                    }else{
                        $usuario -> actualizar_personal($_POST["usu_id"],$_POST["usu_nombres"],$_POST["usu_correo"],$_POST["rol_id"]);
                        echo "2";
                    }
                    /*$email->registrar($datos1[0]['usu_id']);*/
                }else{
                    echo "0";
                }
                
                break;
        case "mostrar":
            $datos = $usuario->get_usuario_id($_POST["usu_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $ouput["usu_id"] = $row["usu_id"];
                    $ouput["usu_nombres"] = $row["usu_nombres"];
                    $ouput["usu_correo"] = $row["usu_correo"];
                    $ouput["rol_id"] = $row["rol_id"];
                }
                echo json_encode($ouput);
            }
            break;
    
        case "eliminar":
            $usuario->eliminar_personal($_POST["usu_id"]);
            echo "1";
            break;
        case "combo_area":
            $datos = $usuario->get_usuario_permiso_area($_SESSION["usu_id"]);
            $html = "";
            $html.="<option value=''>Seleccionar</option>";   
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<option value='".$row['area_id']."'>".$row['area_nom']."</option>";
                }
                echo $html;
            }         
            break;
        }
    
?>