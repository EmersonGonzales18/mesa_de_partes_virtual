//TODO: Funcion para aplicar en la vista
$(document).ready(function(){    

}); 

$(document).on("click","#btn_recuperar",function(){
    var usu_correo = $('#usu_correo').val();
    if(usu_correo === ""){
        Swal.fire({
            title: "Alerta",
            text: "No ha ingresado un correo electronico",
            icon: "warning",
            confirmButtonColor: "#5156be"
        });
    }else{
        $.ajax({
            url:"../../controllers/email.php?opcion=recuperar",
            type: "POST",
            data: {usu_correo : usu_correo, rol_id : 2},
            success: function(datos){
                if(datos == 1){
                Swal.fire({
                    title: "Recuperar",
                    text: "Se cambio la contraseña y se envio a su correo electronico",
                    icon: "success",
                    confirmButtonColor: "#5156be"
                });
        
                $('#btn_recuperar').prop('disabled', false);
                $('#btn_recuperar').html('Recuperar');
                }else{
                    Swal.fire({
                        title: "Error!",
                        text: "El correo electronico no existe",
                        icon: "error",
                        confirmButtonColor: "#5156be"
                    });
                }
            }, beforeSend: function(){
                $('#btn_recuperar').prop('disabled', true);
                $('#btn_recuperar').html('<i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>Espere ...');
            }
        });
    }
    
}); 