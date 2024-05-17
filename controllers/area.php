<?php
    //TODO: Llamamos a la clase de conexion
    require_once("../config/conexion.php");
    //TODO: Llamamos al modelo usuario
    require_once("../models/Area.php");

    $area = new Area();

    switch($_GET["opcion"]){
        case "combo":
            $datos = $area->get_area();
            $html = "";
            $html.="<option value=''>Seleccionar</option>";   
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $html.="<option value='".$row['area_id']."'>".$row['area_nom']."</option>";
                }
                echo $html;
            }         
            break;
        case "listar":
            $datos = $area->get_area();
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]=$row["area_nom"];
                $sub_array[]=$row["area_correo"];
                $sub_array[]=$row["fecha_crea"];
                $sub_array[]=$row["fecha_modi"];
                $sub_array[]='<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm  ml-3" onClick="editar('.$row["area_id"].')"><i class="bx bx-edit-alt font-size-16 align-middle ml-3"></i></button> <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar('.$row["area_id"].')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
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
                $datos = $area->get_area_nombre($_POST["area_nom"]);
                if(is_array($datos)==true and count($datos)==0){
                    if(empty($_POST["area_id"])){
                        $area->insert_area($_POST["area_nom"],$_POST["area_correo"]);
                        echo "1";
                    }else{
                        $area->actualizar_area($_POST["area_id"], $_POST["area_nom"],$_POST["area_correo"]);
                        echo "2";
                    }
                }else{
                    echo "0";
                }
        break;
        case "mostrar":
            $datos = $area->get_area_x_id($_POST["area_id"]);
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    $ouput["area_id"] = $row["area_id"];
                    $ouput["area_nom"] = $row["area_nom"];
                    $ouput["area_correo"] = $row["area_correo"];
                }
                echo json_encode($ouput);
            }
            break;
    
        case "eliminar":
            $area->eliminar_area($_POST["area_id"]);
            echo "1";
        break;

        case "listar_permisos":
            $datos = $area->get_areas_permisos_usu_id($_POST["usu_id"]);
            $data = Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[]=$row["area_nom"];
                if($row["aread_permisos"]=="Si"){
                    $sub_array[]='<button type="button" class="btn btn-soft-success waves-effect waves-light btn-sm  ml-3" onClick="deshabilitar('.$row["aread_id"].')"><i class="bx bx-user-check font-size-16 align-middle ml-3"></i></button>';
                   
                }else{
                    $sub_array[]='<button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm  ml-3" onClick="habilitar('.$row["aread_id"].')"><i class="bx bx-user-x font-size-16 align-middle ml-3"></i></button>';
                }
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

        case "habilitar":
            $area->habilitar_area_usuario($_POST["aread_id"]);
            echo "1";
        break;

        case "deshabilitar":
            $area->deshabilitar_area_usuario($_POST["aread_id"]);
            echo "1";
        break;
    }

?>