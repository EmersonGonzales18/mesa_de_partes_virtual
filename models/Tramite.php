<?php
    class Tramite extends Conectar{

        public function get_tramites(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tramite
                WHERE estado=1
                ORDER BY tram_nom";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_tramite_informatica(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tramite
                WHERE estado=1 AND tram_id IN (1,5,9)
                ORDER BY tram_nom";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_tramite_remuneraciones(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tramite
                WHERE estado=1 AND tram_id IN (1,5)
                ORDER BY tram_nom";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function insert_tramite($tram_nom,$tram_desc){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="INSERT INTO tm_tramite(tram_nom,tram_desc) VALUES (?,?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$tram_nom);
            $sql->bindValue(2,$tram_desc);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function actualizar_tramite($tram_id,$tram_nom,$tram_desc){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_tramite
                SET 
                    tram_nom=?,
                    tram_desc=?,
                    fecha_modi=NOW()
                WHERE 
                    tram_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$tram_nom);
            $sql->bindValue(2,$tram_desc);
            $sql->bindValue(3,$tram_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }
        public function get_tramite_nombre($tram_nom){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tramite 
                WHERE tram_nom=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tram_nom);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }
        public function get_tramite_x_id($tram_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_tramite 
                WHERE tram_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tram_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }
        public function eliminar_tramite($tram_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_tramite
            SET 
                estado=0,
                fecha_elim=NOW()
            WHERE 
                tram_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$tram_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }
    }
?>