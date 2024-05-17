<?php
    //TODO: Llamamos a la clase de conexion
    require_once("../config/conexion.php");
    //TODO: Llamamos al modelo usuario
    require_once("../models/Tipo.php");

    $tipo = new Tipo();

    switch($_GET["opcion"]){
        case "combo":
            $datos = $tipo->get_tipo();
            $html = "";
            $html.="<option value=''>Seleccionar</option>";   
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<option value='".$row['tipo_id']."'>".$row['tipo_nom']."</option>";
                }
                echo $html;
            }         
            break;

        case "listar":
            $datos = $tipo->get_tipo();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]=$row["tipo_nom"];
                $sub_array[]=$row["fecha_crea"];
                $sub_array[]=$row["fecha_modi"];
                $sub_array[]='<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm  ml-3" onClick="editar('.$row["tipo_id"].')"><i class="bx bx-edit-alt font-size-16 align-middle ml-3"></i></button> <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar('.$row["tipo_id"].')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
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

            $datos = $tipo->get_tipo_nombre($_POST["tipo_nom"]);
            if(is_array($datos)==true and count($datos)==0){
                if(empty($_POST["tipo_id"])){
                    $tipo->insert_tipo($_POST["tipo_nom"]);
                    echo "1";
                }else{
                    $tipo->actualizar_tipo($_POST["tipo_id"], $_POST["tipo_nom"]);
                    echo "2";
                }
            }else{
                echo "0";
            }
            break;
        case "mostrar":
            $datos = $tipo->get_tipo_x_id($_POST["tipo_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $ouput["tipo_id"] = $row["tipo_id"];
                    $ouput["tipo_nom"] = $row["tipo_nom"];
                }
                echo json_encode($ouput);
            }
            break;
        case "eliminar":
            $tipo->eliminar_tipo($_POST["tipo_id"]);
            echo "1";
            break;
        
        }

?>