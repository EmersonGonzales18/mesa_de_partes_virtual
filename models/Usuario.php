<?php
//TODO: Definicion de la clase Usuario que extiende de la clase padre
class Usuario extends Conectar
{
    private $key = "MesaDePartes";
    private $cipher = "aes-256-cbc";

    //TODO: Metodo de logeo
    public function login()
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Si se presiona enviar
        if (isset($_POST["enviar"])) {
            //TODO: Almacenamos lo enviado del form en dos variables
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];

            //TODO: Si esta vacio los campos nos da una url
            if (empty($correo) and empty($pass)) {
                header("Location:" . Conectar::rutas() . "index.php?m=2");
                exit();
            } else {
                //TODO: Si no, ejecuta una consulta sql para traer toda la info con el correo
                $sql = "SELECT * 
                            FROM tm_usuario 
                            WHERE usu_correo=? AND rol_id=1";
                //TODO: Preparar la consulta
                $sql = $conectar->prepare($sql);
                //TODO: Vincular los parametros a la consulta
                $sql->bindValue(1, $correo);
                $sql->execute();
                //TODO: Trae toda la informacion
                $resultado = $sql->fetch();

                if ($resultado) {
                    //TODO: Almacenas en una variable la contraseña
                    $textoCifrado = $resultado["usu_pass"];

                    //TODO: LLamando a las librerias para decodoficar
                    $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIv = substr(base64_decode($textoCifrado),  openssl_cipher_iv_length($this->cipher));
                    //TODO: Texto descifrado almacena el id decodificado y procede a hacer el update
                    $textoDescifrado = openssl_decrypt($cifradoSinIv, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

                    //TODO: Si la contraseña descifrada coincide con lo que se envio
                    if ($textoDescifrado == $pass) {
                        //TODO: Si resultado trae informacion
                        if (is_array($resultado) and count($resultado) > 0) {

                            //TODO: Inicia sesiones
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["usu_nombres"] = $resultado["usu_nombres"];
                            $_SESSION["usu_correo"] = $resultado["usu_correo"];
                            $_SESSION["usu_img"] = $resultado["usu_img"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:" . Conectar::rutas() . "views/home/");
                            exit();
                        }
                    } else {
                        //TODO:Contraseña incorrecta
                        header("Location:" . Conectar::rutas() . "index.php?m=3");
                        exit();
                    }
                } else {
                    //TODO: Correo electronico incorrecto
                    header("Location:" . Conectar::rutas() . "index.php?m=1");
                    exit();
                }
            }
        }
    }


    public function login_personal()
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Si se presiona enviar
        if (isset($_POST["enviar"])) {
            //TODO: Almacenamos lo enviado del form en dos variables
            $correo = $_POST["usu_correo"];
            $pass = $_POST["usu_pass"];

            //TODO: Si esta vacio los campos nos da una url
            if (empty($correo) and empty($pass)) {
                header("Location:" . Conectar::rutas() . "views/personal_login/index.php?m=2");
                exit();
            } else {
                //TODO: Si no, ejecuta una consulta sql para traer toda la info con el correo
                $sql = "SELECT * 
                            FROM tm_usuario 
                            WHERE usu_correo=? AND rol_id IN (2,3)";
                //TODO: Preparar la consulta
                $sql = $conectar->prepare($sql);
                //TODO: Vincular los parametros a la consulta
                $sql->bindValue(1, $correo);
                $sql->execute();
                //TODO: Trae toda la informacion
                $resultado = $sql->fetch();

                if ($resultado) {
                    //TODO: Almacenas en una variable la contraseña
                    $textoCifrado = $resultado["usu_pass"];

                    //TODO: LLamando a las librerias para decodoficar
                    $iv_dec = substr(base64_decode($textoCifrado), 0, openssl_cipher_iv_length($this->cipher));
                    $cifradoSinIv = substr(base64_decode($textoCifrado),  openssl_cipher_iv_length($this->cipher));
                    //TODO: Texto descifrado almacena el id decodificado y procede a hacer el update
                    $textoDescifrado = openssl_decrypt($cifradoSinIv, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

                    //TODO: Si la contraseña descifrada coincide con lo que se envio
                    if ($textoDescifrado == $pass) {
                        //TODO: Si resultado tre informacion
                        if (is_array($resultado) and count($resultado) > 0) {

                            //TODO: Inicia sesiones
                            $_SESSION["usu_id"] = $resultado["usu_id"];
                            $_SESSION["usu_nombres"] = $resultado["usu_nombres"];
                            $_SESSION["usu_correo"] = $resultado["usu_correo"];
                            $_SESSION["usu_img"] = $resultado["usu_img"];
                            $_SESSION["rol_id"] = $resultado["rol_id"];
                            header("Location:" . Conectar::rutas() . "views/home_personal/");
                            exit();
                        }
                    } else {
                        //TODO:Contraseña incorrecta
                        header("Location:" . Conectar::rutas() . "views/personal_login/index.php?m=3");
                        exit();
                    }
                } else {
                    //TODO: Correo electronico incorrecto
                    header("Location:" . Conectar::rutas() . "views/personal_login/index.php?m=1");
                    exit();
                }
            }
        }
    }

    //TODO: Metodo para registrar una nuevo usario en la BD
    public function agregar_usuario($usu_nombres, $usu_correo, $usu_pass, $usu_img, $estado)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL

        //TODO: Encriptacion del id
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        //TODO: Texto cifrado almacenado el id encriptado
        $textoCifrado = base64_encode($iv . $cifrado);

        $sql = "INSERT INTO tm_usuario
                (usu_nombres,usu_correo,usu_pass,usu_img,rol_id,estado) 
                VALUES 
                (?,?,?,?,1,?)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_nombres);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $textoCifrado);
        $sql->bindValue(4, $usu_img);
        $sql->bindValue(5, $estado);
        //TODO: Ejecutar la consulta
        $sql->execute();
        $sql1 = "SELECT last_insert_id() as 'usu_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll();
    }

    public function get_usuario_correo($usu_correo)
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT * FROM tm_usuario 
                WHERE usu_correo=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_correo);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll();
    }

    public function get_usuario_id($usu_id)
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT * FROM tm_usuario 
                WHERE usu_id=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll();
    }

    public function activar_usuario($usu_id)
    {
        //TODO: LLamando a las librerias para decodoficar
        $iv_dec = substr(base64_decode($usu_id), 0, openssl_cipher_iv_length($this->cipher));
        $cifradoSinIv = substr(base64_decode($usu_id),  openssl_cipher_iv_length($this->cipher));
        //TODO: Texto descifrado almacena el id decodificado y procede a hacer el update
        $textoDescifrado = openssl_decrypt($cifradoSinIv, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv_dec);

        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "UPDATE tm_usuario 
                    SET estado=1,
                    fecha_acti = NOW()
                    WHERE usu_id=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $textoDescifrado);
        //TODO: Ejecutar la consulta
        $sql->execute();
    }

    public function recuperar_usuario($usu_correo, $usu_pass)
    {
        //TODO: Encriptacion del id
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
        $cifrado = openssl_encrypt($usu_pass, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
        //TODO: Texto cifrado almacenado el id encriptado
        $textoCifrado = base64_encode($iv . $cifrado);

        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "UPDATE tm_usuario 
                    SET usu_pass=?,
                    fecha_modi = NOW()
                    WHERE usu_correo=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $textoCifrado);
        $sql->bindValue(2, $usu_correo);
        //TODO: Ejecutar la consulta
        $sql->execute();
    }

    public function get_personal()
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT 
            A.usu_id,
            A.usu_nombres,
            A.usu_correo,
            A.rol_id,
            B.rol_nombre,
            A.fecha_crea
            FROM tm_usuario as A INNER JOIN
            tm_rol AS B ON A.rol_id = B.rol_id
                            WHERE A.estado=1
                            AND A.rol_id IN (2,3)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll();
    }

    public function insert_personal($usu_nombres, $usu_correo, $rol_id)
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "INSERT INTO tm_usuario
            (usu_nombres, usu_correo, usu_img, rol_id,estado) 
            VALUES 
            (?,?,'../../assets/picture/avatar.png',?,1)";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nombres);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $rol_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        $sql1 = "SELECT last_insert_id() as 'usu_id'";
        $sql1 = $conectar->prepare($sql1);
        $sql1->execute();
        return $sql1->fetchAll();
    }

    public function actualizar_personal($usu_id, $usu_nombres, $usu_correo, $rol_id)
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "UPDATE tm_usuario
                SET 
                    usu_nombres=?,
                    usu_correo=?,
                    rol_id=?,
                    fecha_modi=NOW()
                WHERE 
                    usu_id=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        $sql->bindValue(1, $usu_nombres);
        $sql->bindValue(2, $usu_correo);
        $sql->bindValue(3, $rol_id);
        $sql->bindValue(4, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
    }

    public function eliminar_personal($usu_id)
    {
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "UPDATE tm_usuario
            SET 
                estado=0,
                fecha_elimi=NOW()
            WHERE 
                usu_id=?";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
    }
    public function get_usuario_permiso_area($usu_id)
    {
        //TODO: Obtener la conexion mediante metodo de la clase padre
        $conectar = parent::conexion();
        //TODO: Juego a utf-8 mediante la clase padre
        parent::set_names();
        //TODO: Sentencia SQL
        $sql = "SELECT 
            A.aread_id,
            A.area_id,
            A.aread_permisos, 
            B.area_nom,
            B.area_correo
            FROM td_area_detalle AS A
            INNER JOIN tm_area AS B
            ON A.area_id = B.area_id
            WHERE
            A.usu_id = ? AND
            A.aread_permisos = 'Si' AND 
            B.estado = 1";
        //TODO: Preparar la consulta
        $sql = $conectar->prepare($sql);
        //TODO: Vincular los parametros a la consulta
        $sql->bindValue(1, $usu_id);
        //TODO: Ejecutar la consulta
        $sql->execute();
        return $sql->fetchAll(pdo::FETCH_ASSOC);
    }
}
?>