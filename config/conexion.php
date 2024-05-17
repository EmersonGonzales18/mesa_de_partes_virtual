<?php
//TODO: Captura informacion de los inicios de sesion
session_start(); 

class Conectar
{
    //TODO: Variable protegida para almacenar la BF
    protected $db_host;

    //TODO: Metodo para establecer la conexion a la BD
    protected function conexion()
    {
        try {
            //TODO: Intenta conectarse con PDO
            $conectar = $this->db_host = new PDO("mysql:local=localhost;dbname=mesadepartes", "root", "");
            return $conectar;
        } catch (Exception $e) {
            //TODO: En caso de error devuelve un mensaje
            print "Error de la BD: " . $e->getMessage();
            die();
        }
    }

    //TODO: Metodo para establecer a utf-8
    public function set_names()
    {
        return $this->db_host->query("SET NAMES 'utf8'");
    }

    //TODO: Metodo para establecer la ruta base
    public static function rutas()
    {
        return "http://localhost/PERSONAL_MesaDePartes/";
    }
}
?>