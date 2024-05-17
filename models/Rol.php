<?php
    class Rol extends Conectar{
        public function get_rol(){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_rol
                WHERE estado=1
                AND rol_id IN (1,2,3)
                ORDER BY rol_nombre";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function insert_rol($rol_nombre){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="INSERT INTO tm_rol(rol_nombre) VALUES (?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$rol_nombre);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function actualizar_rol($rol_id,$rol_nombre){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_rol
                SET 
                    rol_nombre=?,
                    fecha_modi=NOW()
                WHERE 
                    rol_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1,$rol_nombre);
            $sql->bindValue(2,$rol_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }

        public function get_rol_nombre($rol_nombre){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_rol 
                WHERE rol_nombre=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$rol_nombre);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function get_rol_x_id($rol_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="SELECT * FROM tm_rol 
                WHERE rol_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$rol_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll();
        }

        public function eliminar_rol($rol_id){
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="UPDATE tm_rol
            SET 
                estado=0,
                fecha_elim=NOW()
            WHERE 
                rol_id=?";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$rol_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
        }
        public function get_rol_permisos_menu($rol_id){
            //TODO: Obtener la conexion mediante metodo de la clase padre
            $conectar = parent::conexion();
            //TODO: Juego a utf-8 mediante la clase padre
            parent::set_names();
            //TODO: Sentencia SQL
            $sql="CALL sp_i_rol_01(?)";
            //TODO: Preparar la consulta
            $sql = $conectar->prepare($sql);
            //TODO: Vincular los parametros a la consulta
            $sql->bindValue(1,$rol_id);
            //TODO: Ejecutar la consulta
            $sql->execute();
            return $sql->fetchAll(pdo::FETCH_ASSOC);
       }

       public function habilitar_rol_menu($menud_id){
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="UPDATE td_menu_detalle
            SET menud_permiso = 'Si', 
                fecha_modi = NOW()
            WHERE menud_id = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$menud_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
       }

       public function deshabilitar_rol_menu($menud_id){
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="UPDATE td_menu_detalle
        SET menud_permiso = 'No', 
            fecha_modi = NOW()
        WHERE menud_id = ?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$menud_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
       }


       public function get_menu_x_rol($rol_id){
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="SELECT 
            A.menud_id,
            B.menu_nombre, B.menu_nombre_vista, B.menu_icon,
            B.menu_ruta
            FROM td_menu_detalle  AS A
            INNER JOIN tm_menu AS B
            ON A.menu_id = B.menu_id
            WHERE 
            A.rol_id = ? AND B.estado = 1 
            AND A.menud_permiso = 'Si'
            ";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$rol_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
     }

     public function validar_menu_x_rol($rol_id,$menu_nombre){
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql="SELECT 
            A.menud_id,
            B.menu_nombre, B.menu_nombre_vista, B.menu_icon,
            B.menu_ruta
            FROM td_menu_detalle  AS A
            INNER JOIN tm_menu AS B
            ON A.menu_id = B.menu_id
            WHERE 
            A.rol_id = ? AND B.estado = 1
            AND B.menu_nombre = ?
            AND A.menud_permiso = 'Si'
            ";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1,$rol_id);
        $sql->bindValue(2,$menu_nombre);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
     }








    }
?>