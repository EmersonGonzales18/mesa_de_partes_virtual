<?php
    class Tipo extends Conectar{
        public function get_tipo(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tipo
                WHERE estado=1";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }


        public function insert_tipo($tipo_nom){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="INSERT INTO tm_tipo(tipo_nom) VALUES (?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$tipo_nom);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function actualizar_tipo($tipo_id,$tipo_nom){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_tipo
                SET 
                    tipo_nom=?,
                    fecha_modi=NOW()
                WHERE 
                    tipo_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$tipo_nom);
            $sql->bindValue(2,$tipo_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function get_tipo_nombre($tipo_nom){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tipo 
                WHERE tipo_nom=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tipo_nom);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_tipo_x_id($tipo_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tipo 
                WHERE tipo_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tipo_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function eliminar_tipo($tipo_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_tipo
            SET 
                estado=0,
                fecha_elim=NOW()
            WHERE 
                tipo_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tipo_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }
    }
?>