<?php
    require_once("../../config/conexion.php");
    session_destroy();
    if($_SESSION["rol_id"] == 1){
        header("Location:" . Conectar::rutas()."index.php");
    }
    elseif($_SESSION["rol_id"] == 2 || $_SESSION["rol_id"] == 3){
        header("Location:" . Conectar::rutas()."views/personal_login/index.php");
    }
    exit();
?>