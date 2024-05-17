<?php
//TODO: Llamamos a la clase de conexion
require_once("../config/conexion.php");
//TODO: Llamamos al modelo usuario
require_once("../models/Rol.php");

$rol = new Rol();

switch ($_GET["opcion"]) {
    case "combo":
        $datos = $rol->get_rol();
        $html = "";
        $html .= "<option value=''>Seleccionar</option>";
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $html .= "<option value='" . $row['rol_id'] . "'>" . $row['rol_nombre'] . "</option>";
            }
            echo $html;
        }
        break;
    case "listar":
        $datos = $rol->get_rol();
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["rol_nombre"];
            $sub_array[] = $row["fecha_crea"];
            $sub_array[] = $row["fecha_modi"];
            $sub_array[] = '<button type="button" class="btn btn-soft-info waves-effect waves-light btn-sm  ml-3" onClick="permiso(' . $row["rol_id"] . ')"><i class="bx bx-shield-quarter font-size-16 align-middle ml-3"></i></button>';
            $sub_array[] = '<button type="button" class="btn btn-soft-warning waves-effect waves-light btn-sm  ml-3" onClick="editar(' . $row["rol_id"] . ')"><i class="bx bx-edit-alt font-size-16 align-middle ml-3"></i></button> <button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm" onClick="eliminar(' . $row["rol_id"] . ')"><i class="bx bx-trash-alt font-size-16 align-middle"></i></button>';
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

        $datos = $rol->get_rol_nombre($_POST["rol_nombre"]);
        if (is_array($datos) == true and count($datos) == 0) {
            if (empty($_POST["rol_id"])) {
                $rol->insert_rol($_POST["rol_nombre"]);
                echo "1";
            } else {
                $rol->actualizar_rol($_POST["rol_id"], $_POST["rol_nombre"]);
                echo "2";
            }
        } else {
            echo "0";
        }
        break;
    case "mostrar":
        $datos = $rol->get_rol_x_id($_POST["rol_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $ouput["rol_id"] = $row["rol_id"];
                $ouput["rol_nombre"] = $row["rol_nombre"];
            }
            echo json_encode($ouput);
        }
        break;
    case "eliminar":
        $rol->eliminar_rol($_POST["rol_id"]);
        echo "1";
        break;

    case "listar_permisos":
        $datos = $rol->get_rol_permisos_menu($_POST["rol_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["menu_nombre_vista"];
            if ($row["menud_permiso"] == "Si") {
                $sub_array[] = '<button type="button" class="btn btn-soft-success waves-effect waves-light btn-sm  ml-3" onClick="deshabilitar(' . $row["menud_id"] . ')"><i class="bx bx-user-check font-size-16 align-middle ml-3"></i></button>';
            } else {
                $sub_array[] = '<button type="button" class="btn btn-soft-danger waves-effect waves-light btn-sm  ml-3" onClick="habilitar(' . $row["menud_id"] . ')"><i class="bx bx-user-x font-size-16 align-middle ml-3"></i></button>';
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
        $rol->habilitar_rol_menu($_POST["menud_id"]);
        echo "1";
        break;

    case "deshabilitar":
        $rol->deshabilitar_rol_menu($_POST["menud_id"]);
        echo "1";
        break;
}
