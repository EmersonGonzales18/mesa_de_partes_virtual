<?php
    class Area extends Conectar{
        public function get_area(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_area
                WHERE estado=1
                ORDER BY area_nom";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }
        
        public function insert_area($area_nom,$area_correo){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="INSERT INTO tm_area(area_nom,area_correo) VALUES (?,?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$area_nom);
            $sql->bindValue(2,$area_correo);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function actualizar_area($area_id,$area_nom,$area_correo){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_area
                SET 
                    area_nom=?,
                    area_correo=?,
                    fecha_modi=NOW()
                WHERE 
                    area_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$area_nom);
            $sql->bindValue(2,$area_correo);
            $sql->bindValue(3,$area_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }
        public function get_area_nombre($area_nom){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_area 
                WHERE area_nom=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$area_nom);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }
        public function get_area_x_id($area_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_area 
                WHERE area_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$area_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }
        public function eliminar_area($area_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_area
            SET 
                estado=0,
                fecha_elim=NOW()
            WHERE 
                area_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$area_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function get_areas_permisos_usu_id($usu_id){
            //TODO: Obtener la conexion mediante metodo de la clase padre
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="CALL sp_i_area_01(?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$usu_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll(pdo::FETCH_ASSOC);
       }
       
       public function habilitar_area_usuario($aread_id){
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="UPDATE td_area_detalle
            SET aread_permisos = 'Si', 
                fecha_modi = NOW()
            WHERE aread_id = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$aread_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
       }

       public function deshabilitar_area_usuario($aread_id){
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="UPDATE td_area_detalle
        SET aread_permisos = 'No', 
        fecha_modi = NOW()
            WHERE aread_id = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$aread_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
       }
    }
?>