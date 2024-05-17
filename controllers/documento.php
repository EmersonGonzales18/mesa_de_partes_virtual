<?php
//TODO: Llamamos a la clase de conexion
require_once("../config/conexion.php");
//TODO: Llamamos al modelo usuario
require_once("../models/Documento.php");
require_once("../models/Email.php");

//TODO: Crea un usario de la clase Usuario
$documento = new Documento();
$email = new Email();

//TODO: Determinar que operacion utilizar
switch ($_GET["opcion"]) {
        //TODO: Si la operacion es registrar
    case "registrar":
        //TODO: Evaluamos el metodo de acceder al usuario
        $datos = $documento->agregar_documento(
            $_POST["area_id"],
            $_POST["tram_id"],
            $_POST["tipo_id"],
            $_POST["doc_dni"],
            $_POST["doc_nombres"],
            $_POST["doc_descr"],
            $_POST["doc_link"],
            $_POST["doc_folios"],
            $_SESSION["usu_id"],
        );

        //TODO: Validar la informacion
        if (is_array($datos) == true and count($datos) == 0) {
            //TODO: Si no se ha guardado nada envia un 0

        } else {
            $anio = date("Y");
            $mes = date("m");
            echo $mes . "-" . $anio . "-" . $datos[0]['doc_id'];
            if (empty($_FILES['file']['name'])) {
            } else {

                $countfiles = count($_FILES['file']['name']);
                $ruta_guardado = "../documents/registro/" . "Trámite Registrado N° - DNI " . $datos[0]['doc_id'] . "-" . $datos[0]['doc_dni'] . "/";
                $file_array = array();
                if (!file_exists($ruta_guardado)) {
                    mkdir($ruta_guardado, 0777, true);
                }

                for ($index = 0; $index < $countfiles; $index++) {
                    $nombre = $_FILES['file']['tmp_name'][$index];
                    $destino = $ruta_guardado . $_FILES['file']['name'][$index];

                    $documento->insert_detalle_documento($datos[0]['doc_id'], $_FILES['file']['name'][$index], $_SESSION['usu_id'], 'Pendiente');
                    move_uploaded_file($nombre, $destino);
                }
            }
            //TODO: Enviar por correo la notificacion
            $email->enviar_not_tramite($datos[0]['doc_id']);
        }

        break;
    case "listar_documentos_usuario":
        $datos = $documento->get_documento_x_usu_id($_SESSION["usu_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["numero_tramite"];
            $sub_array[] = $row["area_nom"];
            $sub_array[] = $row["tram_nom"];
            $sub_array[] = $row["tipo_nom"];
            $sub_array[] = $row["doc_dni"];
            $sub_array[] = $row["doc_nombres"];
            if ($row["doc_estado"] == 'Pendiente') {
                $sub_array[] = "<span class='badge bg-warning'>Pendiente</span>";
            } else if ($row["doc_estado"] == 'Terminado') {
                $sub_array[] = "<span class='badge bg-success'>Terminado</span>";
            }

            $sub_array[] = '<button type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm" onClick="ver(' . $row["doc_id"] . ')"><i class="bx bx-search-alt font-size-16 align-middle"></i></button>';
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

    case "listar_documentos_area":
        $datos = $documento->get_documento_x_area($_POST["area_id"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["numero_tramite"];
            $sub_array[] = $row["area_nom"];
            $sub_array[] = $row["tram_nom"];
            $sub_array[] = $row["tipo_nom"];
            $sub_array[] = $row["doc_dni"];
            $sub_array[] = $row["doc_nombres"];
            if ($row["doc_estado"] == 'Pendiente') {
                $sub_array[] = "<span class='badge bg-warning'>Pendiente</span>";
            } else if ($row["doc_estado"] == 'Terminado') {
                $sub_array[] = "<span class='badge bg-success'>Terminado</span>";
            }
            $sub_array[] = '<button type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm" onClick="ver(' . $row["doc_id"] . ')"><i class="bx bx-message-alt-dots font-size-16 align-middle"></i></button>';
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
    case "mostrar_modal":
        $datos = $documento->get_documento_x_id($_POST["doc_id"]);
        if (is_array($datos) == true and count($datos) > 0) {
            foreach ($datos as $row) {
                $ouput["doc_id"] = $row["doc_id"];
                $ouput["area_id"] = $row["area_id"];
                $ouput["area_nom"] = $row["area_nom"];
                $ouput["area_correo"] = $row["area_correo"];
                $ouput["doc_dni"] = $row["doc_dni"];
                $ouput["doc_nombres"] = $row["doc_nombres"];
                $ouput["doc_descr"] = $row["doc_descr"];
                $ouput["doc_link"] = $row["doc_link"];
                $ouput["doc_folios"] = $row["doc_folios"];
                $ouput["tram_nom"] = $row["tram_nom"];
                $ouput["tipo_id"] = $row["tipo_id"];
                $ouput["tipo_nom"] = $row["tipo_nom"];
                $ouput["usu_id"] = $row["tipo_id"];
                $ouput["usu_nombres"] = $row["usu_nombres"];
                $ouput["usu_correo"] = $row["usu_correo"];
                $ouput["cantidad"] = $row["cantidad"];
                $ouput["numero_tramite"] = $row["numero_tramite"];
                $ouput["doc_estado"] = $row["doc_estado"];
                $ouput["doc_respuesta"] = $row["doc_respuesta"];
            }
            echo json_encode($ouput);
        }
        break;

    case "listar_documentos_detalles":
        $datos = $documento->get_documento_detalle_x_doc_id($_POST["doc_id"], $_POST["detalle_tipo"]);
        $data = array();
        foreach ($datos as $row) {
            $sub_array = array();
            $sub_array[] = $row["detalle_nom"];
            $sub_array[] = $row["usu_nombres"];
            $sub_array[] = "<div class='avatar-sm flex-shrink-0 me-3'><img src='" . $row["usu_img"] . "' alt='' class='img-thumbnail rounded-circle'></div>";
            $sub_array[] = $row["fecha_crea"];
            if ($row["detalle_tipo"] == 'Pendiente') {
                $sub_array[] = '<a type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm" href="../../documents/registro/Trámite Registrado N° - DNI '.$row["doc_id"].'-'.$row["doc_dni"].'/'.$row["detalle_nom"].'" target="_blank" download><i class="bx bxs-download font-size-16 align-middle"></i></a>';
            } else if ($row["detalle_tipo"] == 'Terminado') {
                $sub_array[] = '<a type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm" href="../../documents/respuesta/Respuesta Trámite N° - '.$row["doc_id"].'/'.$row["detalle_nom"].'" target="_blank" download ><i class="bx bxs-download font-size-16 align-middle"></i></a>';
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
    case "respuesta_documento":
        //TODO: Evaluamos el metodo de acceder al usuario
            $documento->actualizar_respuesta_documento($_POST["doc_id"],$_POST['doc_respuesta'],$_SESSION['usu_id']);
            $anio = date("Y");
            $mes = date("m");
            echo $mes . "-" . $anio . "-" . $_POST["doc_id"]; //Este es el numero de tramite
 
            if (empty($_FILES['file']['name'])) {

            } else {

                $countfiles = count($_FILES['file']['name']);
                $ruta_guardado = "../documents/respuesta/". "Respuesta Trámite N° - " . $_POST["doc_id"] . "/";
                $file_array = array();
                if (!file_exists($ruta_guardado)) {
                    mkdir($ruta_guardado, 0777, true);
                }

                for ($index = 0; $index < $countfiles; $index++) {
                    $nombre = $_FILES['file']['tmp_name'][$index];
                    $destino = $ruta_guardado . $_FILES['file']['name'][$index];

                    $documento->insert_detalle_documento($_POST["doc_id"], $_FILES['file']['name'][$index], $_SESSION['usu_id'], 'Terminado');
                    move_uploaded_file($nombre, $destino);
                }
            //TODO: Enviar por correo la notificacion
             }
             $email->respuesta_not_tramite($_POST["doc_id"]);
        break;

        case "listar_usu_terminado":
            $datos = $documento->get_documento_x_usu_terminado($_SESSION["usu_id"]);
            $data = array();
            foreach ($datos as $row) {
                $sub_array = array();
                $sub_array[] = $row["numero_tramite"];
                $sub_array[] = $row["area_nom"];
                $sub_array[] = $row["tram_nom"];
                $sub_array[] = $row["tipo_nom"];
                $sub_array[] = $row["doc_dni"];
                $sub_array[] = $row["doc_nombres"];
                if ($row["doc_estado"] == 'Pendiente') {
                    $sub_array[] = "<span class='badge bg-warning'>Pendiente</span>";
                } else if ($row["doc_estado"] == 'Terminado') {
                    $sub_array[] = "<span class='badge bg-success'>Terminado</span>";
                }
                $sub_array[] = '<button type="button" class="btn btn-soft-primary waves-effect waves-light btn-sm" onClick="ver(' . $row["doc_id"] . ')"><i class="bx bx-message-alt-dots font-size-16 align-middle"></i></button>';
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
}
