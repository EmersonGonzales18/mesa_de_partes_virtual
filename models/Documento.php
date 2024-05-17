<?php
//TODO: Definicion de la clase Usuario que extiende de la clase padre
class Documento extends Conectar
{
    //TODO: Metodo para registrar una nuevo usario en la BD
    public function agregar_documento($area_id, $tram_id, $tipo_id, $doc_dni, $doc_nombres, $doc_descr, $doc_link, $doc_folios, $usu_id)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        $sql = "INSERT INTO tm_documento
                (area_id,tram_id,tipo_id,doc_dni,doc_nombres,doc_descr,doc_link,doc_folios,usu_id) 
                VALUES 
                (?,?,?,?,?,?,?,?,?)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $area_id);
        $sql->bindValue(2, $tram_id);
        $sql->bindValue(3, $tipo_id);
        $sql->bindValue(4, $doc_dni);
        $sql->bindValue(5, $doc_nombres);
        $sql->bindValue(6, $doc_descr);
        $sql->bindValue(7, $doc_link);
        $sql->bindValue(8, $doc_folios);
        $sql->bindValue(9, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        /*$sql1 = "SELECT last_insert_id() as 'doc_id'";*/
        $sql1 = "SELECT doc_id,doc_dni FROM tm_documento WHERE doc_id = (SELECT last_insert_id())";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll(pdo::FETCH_ASSOC);
    }

    public function insert_detalle_documento($doc_id, $detalle_nom, $usu_id, $detalle_tipo)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        $sql = "INSERT INTO td_documento_detalle (doc_id,detalle_nom,usu_id,detalle_tipo) VALUES(?,?,?,?)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $doc_id);
        $sql->bindValue(2, $detalle_nom);
        $sql->bindValue(3, $usu_id);
        $sql->bindValue(4, $detalle_tipo);
        //TODO: Ejecutar la consulta
        $sql->execute();
    }

    public function get_documento_x_id($doc_id)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        $sql = "CALL sp_l_documento_01(?)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $doc_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function get_documento_x_usu_id($usu_id)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        $sql = "CALL sp_l_documento_02(?)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function get_documento_x_area($area_id)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT
                A.doc_id,
                A.area_id, 
                B.area_nom, 
                B.area_correo, 
                A.doc_dni,
                A.doc_nombres,
                A.doc_descr,
                A.doc_link,
                A.doc_folios,
                C.tram_nom,
                A.tipo_id,
                D.tipo_nom,
                A.usu_id,
                A.doc_estado,
                E.usu_nombres,
                E.usu_correo,
                CONCAT(DATE_FORMAT(A.fecha_crea,'%m'),'-',DATE_FORMAT(A.fecha_crea,'%Y'),'-',A.doc_id) AS numero_tramite
                FROM tm_documento AS A
                INNER JOIN tm_area AS B
                ON A.area_id = B.area_id
                INNER JOIN tm_tramite AS C 
                ON A.tram_id = C.tram_id
                INNER JOIN tm_tipo AS D
                ON A.tipo_id = D.tipo_id
                INNER JOIN tm_usuario AS E
                ON A.usu_id = E.usu_id
                WHERE A.area_id = ?
                AND A.doc_estado = 'Pendiente'
                ";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $area_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function get_documento_x_usu_terminado($doc_usu_respuesta)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT
                A.doc_id,
                A.area_id, 
                B.area_nom, 
                B.area_correo, 
                A.doc_dni,
                A.doc_nombres,
                A.doc_descr,
                A.doc_link,
                A.doc_folios,
                C.tram_nom,
                A.tipo_id,
                D.tipo_nom,
                A.usu_id,
                A.doc_estado,
                E.usu_nombres,
                E.usu_correo,
                CONCAT(DATE_FORMAT(A.fecha_crea,'%m'),'-',DATE_FORMAT(A.fecha_crea,'%Y'),'-',A.doc_id) AS numero_tramite
                FROM tm_documento AS A
                INNER JOIN tm_area AS B
                ON A.area_id = B.area_id
                INNER JOIN tm_tramite AS C 
                ON A.tram_id = C.tram_id
                INNER JOIN tm_tipo AS D
                ON A.tipo_id = D.tipo_id
                INNER JOIN tm_usuario AS E
                ON A.usu_id = E.usu_id
                WHERE A.doc_usu_respuesta = ?
                ";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $doc_usu_respuesta);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    public function get_documento_detalle_x_doc_id($doc_id, $detalle_tipo)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT 
        A.detalle_id,
        A.doc_id,
        A.detalle_nom,
        A.usu_id,
        C.doc_dni,
        B.usu_nombres,
        B.usu_correo,
        B.usu_img,
        A.fecha_crea,
        A.detalle_tipo
         FROM 
         td_documento_detalle AS A 
         INNER JOIN tm_usuario AS B
         
         ON A.usu_id = B.usu_id
         INNER JOIN tm_documento AS C
         ON C.doc_id = A.doc_id
         WHERE A.doc_id = ? AND A.detalle_tipo = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $doc_id);
        $sql->bindValue(2, $detalle_tipo);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }


    public function actualizar_respuesta_documento($doc_id,$doc_respuesta,$doc_usu_respuesta)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        $sql = "UPDATE tm_documento
                SET doc_respuesta = ?, 
                    doc_usu_respuesta = ?,
                    fecha_terminado = NOW(),
                    doc_estado = 'Terminado'
                WHERE 
                    doc_id = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $doc_respuesta);
        $sql->bindValue(2, $doc_usu_respuesta);
        $sql->bindValue(3, $doc_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }

    

}
