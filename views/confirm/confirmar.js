//TODO: Funcion para aplicar en la vista
$(document).ready(function(){
    //TODO: Metodo para capturar la url
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    //TODO: Despues de la cade url y captar lo que esta despues del id
    const confirmar = params.get("id");
    const decode_id = decodeURIComponent(confirmar);
    //TODO: La variable id almacena la url codificada
    const id = decode_id.replace(/\s/g, '+');
    
    //TODO: Envio del id a usu_id hacia el controlador usuario
    $.post("../../controllers/usuario.php?opcion=activar",{usu_id : id}, function(data){

    });
}); 