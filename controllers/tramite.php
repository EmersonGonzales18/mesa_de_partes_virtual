<?php
    //TODO: Llamamos a la clase de conexion
    require_once("../config/conexion.php");
    //TODO: Llamamos al modelo usuario
    require_once("../models/Tramite.php");

    $tramite = new Tramite();

    switch($_GET["opcion"]){
        case "combo":
            $datos = $tramite->get_tramites();
            $html = "";
            $html.="<option value=''>Seleccionar</option>";   
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<option value='".$row['tram_id']."'>".$row['tram_nom']."</option>";
                }
                echo $html;
            }         
            break;
            break;

        case "comboInformatica":
            $datos = $tramite->get_tramite_informatica();
            $html = "";
            $html.="<option value=''>Seleccionar</option>";   
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<option value='".$row['tram_id']."'>".$row['tram_nom']."</option>";
                }
                echo $html;
            }         
            break;
        case "comboRemuneraciones":
                $datos = $tramite->get_tramite_remuneraciones();
                $html = "";
                $html.="<option value=''>Seleccionar</option>";   
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row){
                        $html.="<option value='".$row['tram_id']."'>".$row['tram_nom']."</option>";
                    }
                    echo $html;
                }         
            break;
        case "listar":
                $datos = $tramite->get_tramites();
                $data = Array();
                foreach($datos as $row){
                    $sub_array = array();
                    $sub_array[]=$row["tram_nom"];
                    $sub_array[]=$row["tram_desc"];
                    $sub_array[]=$row["fecha_crea"];
                    $sub_array[]=$row["fecha_modi"];
                    $sub_array[]='<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm  ml-3" onClick="editar('.$row["tram_id"].')"><i class="bx bx-edit-alt font-size-16 align-middle ml-3"></i></button> <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar('.$row["tram_id"].')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
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
    
        case "guardaryeditar":
                    $datos = $tramite->get_tramite_nombre($_POST["tram_nom"]);
                    if(is_array($datos)==true and count($datos)==0){
                        if(empty($_POST["tram_id"])){
                            $tramite->insert_tramite($_POST["tram_nom"],$_POST["tram_desc"]);
                            echo "1";
                        }else{
                            $tramite->actualizar_tramite($_POST["tram_id"], $_POST["tram_nom"],$_POST["tram_desc"]);
                            echo "2";
                        }
                    }else{
                        echo "0";
                    }
            break;
        case "mostrar":
                $datos = $tramite->get_tramite_x_id($_POST["tram_id"]);
                if(is_array($datos)==true and count($datos)>0){
                    foreach($datos as $row){
                        $ouput["tram_id"] = $row["tram_id"];
                        $ouput["tram_nom"] = $row["tram_nom"];
                        $ouput["tram_desc"] = $row["tram_desc"];
                    }
                    echo json_encode($ouput);
                }
                break;
        
        case "eliminar":
                $tramite->eliminar_tramite($_POST["tram_id"]);
                echo "1";
            break;
    
    
    
    
        }

?>