<?php
    //TODO: Llamada al archivo de phpmailer desde composer
    require "../include/vendor/autoload.php";
    //TODO: LLamando a las librerias
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    //TODO: Conexiones para instanciar las clases de conexion y usuario
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    require_once("../models/Documento.php");

    class Email extends PHPMailer{
        //TODO: Credenciales del webmailer de cpanel (hosting)
        protected $gCorreo = 'mesadepartes@dreica.gob.pe';
        protected $gContrasena = 'Ariasmedina4020';

        //TODO: LLave para desencriptar
        private $key = "MesaDePartes";
        //TODO: Tipo de enctriptado
        private $cipher = "aes-256-cbc";

        //TODO: Metodo que registra a un usuario por su id
        public function registrar($usu_id){
            //TODO: Instanciamos las clases para acceder a los metodos
            $conexion = new Conectar();
            $usuario = new Usuario();

            //TODO: Variable que almacena el id usando el metodo del modelo Usuario
            $datos = $usuario->get_usuario_id($usu_id);

            //TODO: Encriptacion del id
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));
            $cifrado = openssl_encrypt($usu_id, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
            //TODO: Texto cifrado almacenado el id encriptado
            $textoCifrado = base64_encode($iv . $cifrado);

            //TODO: Configuraciones basicas del phpmailer
            $this->IsSMTP();
            $this-> Host = 'mail.dreica.gob.pe';
            $this-> SMTPAuth =true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this-> Port = 587;
            $this-> SMTPSecure = 'tls';

            //TODO: Agregar el asunto y titulo del correo
            $this->setFrom($this->gCorreo,"Registro en mesa de partes");

            //TODO: Codificacion del texto
            $this->CharSet = 'UTF8';

            //TODO: Se le enviara a todos lo que se registraron usando el id
            $this->addAddress($datos[0]["usu_correo"]);
            //TODO: Habilitamos html para enviar un contenido
            $this->IsHTML(true);
            //TODO: Agregamos un sujeto al correo
            $this->Subject = 'Mesa de Partes';

            //TODO: Variable que almacena la concatenacion de la cadena con el id cifrado
            $url = $conexion->rutas() . "views/confirm/?id=" . $textoCifrado;

            //TODO: Agrega un cuerpo html al mensaje
            $cuerpo = file_get_contents("../assets/email/registrar.html");
            //TODO: Reemplaza todos los href en el html con la cadena concatenada en el cuerpo 
            $cuerpo = str_replace("xlinkcorreourl", $url, $cuerpo);
            //TODO: Agregar al mensaje el cuerpo
            $this->Body = $cuerpo;
            //TODO: Boton
            $this->AltBody = strip_tags('Confirmar registro');

            //TODO: Validacion de envio
            try {
                $this->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        }

        public function recuperar($usu_correo,$rol_id){
            //TODO: Instanciamos las clases para acceder a los metodos
            $conexion = new Conectar();
            $usuario = new Usuario();

            //TODO: Variable que almacena el id usando el metodo del modelo Usuario
            $datos = $usuario->get_usuario_correo($usu_correo);

            //TODO: Configuraciones basicas del phpmailer
            $this->IsSMTP();
            $this-> Host = 'mail.dreica.gob.pe';
            $this-> SMTPAuth =true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this-> Port = 587;
            $this-> SMTPSecure = 'tls';

            //TODO: Agregar el asunto y titulo del correo
            $this->setFrom($this->gCorreo,"Reestablecer Contraseña");

            //TODO: Codificacion del texto
            $this->CharSet = 'UTF8';

            //TODO: Se le enviara a todos lo que se registraron usando el id
            $this->addAddress($datos[0]["usu_correo"]);
            //TODO: Habilitamos html para enviar un contenido
            $this->IsHTML(true);
            //TODO: Agregamos un sujeto al correo
            $this->Subject = 'Mesa de Partes';

            if($rol_id == 1 ){
                $url = $conexion->rutas();
            }elseif($rol_id == 2){
                $url = $conexion->rutas()."views/personal_login/";
            }

            //TODO: Variable que almacena la concatenacion de la cadena con el id cifrado
            $url = $conexion->rutas();
            $xusupass = $this->generar_xusupass();

            $usuario -> recuperar_usuario($usu_correo, $xusupass);


            //TODO: Agrega un cuerpo html al mensaje
            $cuerpo = file_get_contents("../assets/email/recuperar.html");
            //TODO: Reemplaza todos los href en el html con la cadena concatenada en el cuerpo 
            $cuerpo = str_replace("xusupass", $xusupass, $cuerpo);
            $cuerpo = str_replace("xlinksistema", $url, $cuerpo);
            //TODO: Agregar al mensaje el cuerpo
            $this->Body = $cuerpo;
            //TODO: Boton
            $this->AltBody = strip_tags('Recuperar Contraseña');

            //TODO: Validacion de envio
            try {
                $this->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        }

        private function generar_xusupass(){
            $parteAlfanumerica = substr(md5(rand()),0,3);
            $parteNumerica =  str_pad(floor(rand()*1000),3,'0', STR_PAD_LEFT);
            $resultado = $parteAlfanumerica . $parteNumerica;
            return substr($resultado,0,6);
        }

        public function enviar_not_tramite($doc_id){
            //TODO: Instanciamos las clases para acceder a los metodos
            $conexion = new Conectar();
            $documento = new Documento();

            //TODO: Variable que almacena el id usando el metodo del modelo Usuario
            $datos =$documento->get_documento_x_id($doc_id);

            //TODO: Configuraciones basicas del phpmailer
            $this->IsSMTP();
            $this-> Host = 'mail.dreica.gob.pe';
            $this-> SMTPAuth =true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this-> Port = 587;
            $this-> SMTPSecure = 'tls';

            //TODO: Agregar el asunto y titulo del correo
            $this->setFrom($this->gCorreo,"Mesa de Partes - DREI");

            //TODO: Codificacion del texto
            $this->CharSet = 'UTF8';

            //TODO: Se le enviara a todos lo que se registraron usando el id
            $this->addAddress($datos[0]["usu_correo"]);
            $this->addAddress($datos[0]["area_correo"]);
            //TODO: Habilitamos html para enviar un contenido
            $this->IsHTML(true);
            //TODO: Agregamos un sujeto al correo
            $this->Subject = 'Nuevo Tramite Registrado en Mesa de Partes - DREI';

            //TODO: Variable que almacena la concatenacion de la cadena con el id cifrado
            $url = $conexion->rutas();

            //TODO: Agrega un cuerpo html al mensaje
            $cuerpo = file_get_contents("../assets/email/notificacion.html");
            //TODO: Reemplaza todos los href en el html con la cadena concatenada en el cuerpo 
            $cuerpo = str_replace("xlinksistema", $url, $cuerpo);
            $cuerpo = str_replace("xnrotramite", $datos[0]['numero_tramite'], $cuerpo);
            $cuerpo = str_replace("xarea", $datos[0]['area_nom'], $cuerpo);
            $cuerpo = str_replace("xtipotramite", $datos[0]['tram_nom'], $cuerpo);
            $cuerpo = str_replace("xnumadjuntos", $datos[0]['cantidad'], $cuerpo);
            $cuerpo = str_replace("xfolios", $datos[0]['doc_folios'], $cuerpo);
            //TODO: Agregar al mensaje el cuerpo
            $this->Body = $cuerpo;
            //TODO: Boton
            $this->AltBody = strip_tags('Enviar Registro');

            //TODO: Validacion de envio
            try {
                $this->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        }

        public function respuesta_not_tramite($doc_id){
            //TODO: Instanciamos las clases para acceder a los metodos
            $conexion = new Conectar();
            $documento = new Documento();

            //TODO: Variable que almacena el id usando el metodo del modelo Usuario
            $datos =$documento->get_documento_x_id($doc_id);

            //TODO: Configuraciones basicas del phpmailer
            $this->IsSMTP();
            $this-> Host = 'mail.dreica.gob.pe';
            $this-> SMTPAuth =true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this-> Port = 587;
            $this-> SMTPSecure = 'tls';

            //TODO: Agregar el asunto y titulo del correo
            $this->setFrom($this->gCorreo,"Mesa de Partes - DREI");

            //TODO: Codificacion del texto
            $this->CharSet = 'UTF8';

            //TODO: Se le enviara a todos lo que se registraron usando el id
            $this->addAddress($datos[0]["usu_correo"]);
            //TODO: Habilitamos html para enviar un contenido
            $this->IsHTML(true);
            //TODO: Agregamos un sujeto al correo
            $this->Subject = 'Se ha respondido su Trámite en Mesa de Partes - DREI';

            //TODO: Variable que almacena la concatenacion de la cadena con el id cifrado
            $url = $conexion->rutas();

            //TODO: Agrega un cuerpo html al mensaje
            $cuerpo = file_get_contents("../assets/email/respuesta.html");
            //TODO: Reemplaza todos los href en el html con la cadena concatenada en el cuerpo 
            $cuerpo = str_replace("xlinksistema", $url, $cuerpo);
            $cuerpo = str_replace("xnrotramite", $datos[0]['numero_tramite'], $cuerpo);
            $cuerpo = str_replace("xarea", $datos[0]['area_nom'], $cuerpo);
            $cuerpo = str_replace("xtipotramite", $datos[0]['tram_nom'], $cuerpo);
            $cuerpo = str_replace("xnumadjuntos", $datos[0]['cantidad'], $cuerpo);
            $cuerpo = str_replace("xfolios", $datos[0]['doc_folios'], $cuerpo);
            //TODO: Agregar al mensaje el cuerpo
            $this->Body = $cuerpo;
            //TODO: Boton
            $this->AltBody = strip_tags('Respuesta al Tramite');

            //TODO: Validacion de envio
            try {
                $this->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        }

        public function nuevo_personal($usu_id){
            //TODO: Instanciamos las clases para acceder a los metodos
            $conexion = new Conectar();
            $usuario = new Usuario();

            //TODO: Variable que almacena el id usando el metodo del modelo Usuario
            $datos = $usuario->get_usuario_id($usu_id);

            //TODO: Configuraciones basicas del phpmailer
            $this->IsSMTP();
            $this-> Host = 'mail.dreica.gob.pe';
            $this-> SMTPAuth =true;
            $this->Username = $this->gCorreo;
            $this->Password = $this->gContrasena;
            $this-> Port = 587;
            $this-> SMTPSecure = 'tls';

            //TODO: Agregar el asunto y titulo del correo
            $this->setFrom($this->gCorreo,"Bienvenido(a) Personal de la Mesa de Partes Virtual");

            //TODO: Codificacion del texto
            $this->CharSet = 'UTF8';

            //TODO: Se le enviara a todos lo que se registraron usando el id
            $this->addAddress($datos[0]["usu_correo"]);
            //TODO: Habilitamos html para enviar un contenido
            $this->IsHTML(true);
            //TODO: Agregamos un sujeto al correo
            $this->Subject = 'Mesa de Partes';

            //TODO: Variable que almacena la concatenacion de la cadena con el id cifrado
            $url = $conexion->rutas();
            $xusupass = $this->generar_xusupass();

            $usuario -> recuperar_usuario($datos[0]["usu_correo"], $xusupass);


            //TODO: Agrega un cuerpo html al mensaje
            $cuerpo = file_get_contents("../assets/email/personal.html");
            //TODO: Reemplaza todos los href en el html con la cadena concatenada en el cuerpo 
            $cuerpo = str_replace("xemail", $datos[0]["usu_correo"], $cuerpo);
            $cuerpo = str_replace("xusupass", $xusupass, $cuerpo);
            $cuerpo = str_replace("xlinksistema", $url, $cuerpo);
            //TODO: Agregar al mensaje el cuerpo
            $this->Body = $cuerpo;
            //TODO: Boton
            $this->AltBody = strip_tags('Recuperar Contraseña');

            //TODO: Validacion de envio
            try {
                $this->send();
                return true;
            } catch (Exception $e) {
                return false;
            }

        }
    }
?>