var timeInterval;

$(document).on("click", "#terminos", function(){
    $("#myModal").modal('show');
});


function init(){
    registroButton.disabled = false;
    //TODO: Escuchar el submit del formulario de registro
    $("#mnt_form").on("submit", function(e){
        //TODO: Evita que el formulario se envie automaticamente
        e.preventDefault();
        //TODO: Validar el formulario antes de enviarlo
        if(isFormValid()){
            //TODO: Si es valido, eviar datos
           registrar(e);
        }else{
            //TODO: Si no lo es, mostrar mensajes de error
            displayValidationMessages();
        }
    });
}


function isFormValid(){
    //TODO: Usa validator.js para validar cada campo del formulario
    return validateEmail() && validateText("usu_nombres") && validatePassword() && validatePasswordMatch();
}

function validateEmail(){
    var email = $("#usu_correo").val();
    var isValid = validator.isEmail(email); 
    //TODO: Muestra mensaje si la validacion no es exitosa
    displayErrorMessage("#usu_correo", isValid, "Ingrese Correo Electronico");
    return isValid;
}
function validateText(fieldId){
    var value = $("#" + fieldId).val();
    //TODO: Como minimo debe haber 1 caracteres
    var isValid = validator.isLength(value,{min:1});
    //TODO: Muestra mensaje si la validacion no es exitosa
    displayErrorMessage("#" + fieldId, isValid, "Este Campo es Obligatorio");
    return isValid;
}

function validatePassword(){
    var password = $("#usu_pass").val();
    //TODO: Como minimo debe haber 8 caracteres
    var isValid = validator.isLength(password,{min:8});
    //TODO: Muestra mensaje si la validacion no es exitosa
    displayErrorMessage("#usu_pass",isValid, "Debe contener al menos 8 caracteres");
    return isValid;
}


function validatePasswordMatch(){
    var password = $("#usu_pass").val();
    var confirmpassword = $("#usu_passmatch").val();
    //TODO: Deben conincidir las contraseñas
    var isValid = validator.equals(password, confirmpassword);
    //TODO: Muestra mensaje si la validacion no es exitosa
    displayErrorMessage("#usu_passmatch",isValid, "Las contraseñas no coinciden");
    return isValid;
}



function displayErrorMessage(fieldSelector, isValid, message){
    //TODO: Busca el mensaje de error y actuliza su contenido
    var errorField = $(fieldSelector).next(".validation-error");
    errorField.text(isValid ?"" : message);
    errorField.toggleClass("text-danger", !isValid);
}
function displayValidationMessages(){
    //TODO: Muestra mensajes de error de los campos del formulario
    validateEmail();
    validateText("usu_nombres");
    validatePassword();
    validatePasswordMatch();
}
function registrar(e){
    //TODO: Previene defectos
    e.preventDefault();
    //TODO: Inicialiazamos el formulario y traemos la informacion
    var formData = new FormData($("#mnt_form")[0]);
    //TODO: Metodo ajax para enviar los datos al controlador
    $.ajax({
        url:"../../controllers/usuario.php?opcion=registrar",
        type: "POST",
        data: formData, 
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            if(datos==1){
                Swal.fire({
                    title: "Registro",
                    text: "Se registro correctamente. Redireccionando...",
                    icon: "success",
                    confirmButtonColor: "#5156be",
                    timer: 5000,
                    timerProgressBar: true,
                    didOpen: function(){
                        Swal.showLoading();

                        timeInterval = setInterval(function(){
                            var content = Swal.getHtmlContainer();
                            if(!content) return;
                            var countDownElement = content.querySelector("b");
                            if(countDownElement){
                                countDownElement.textContent = (Swal.getTimerLeft()/1000).toFixed(0);
                            }
                        }, 100);
                    },
                    didClose: function(){
                        clearInterval(timeInterval);
                        window.location.href="../verify/index.php";
                    },
                }).then(function(result){
                    if(result.dismiss === Swal.DismissReason.timer){
                        console.log("I was closed by the timer") ;
                    }
                });
            }else if(datos==0){
                Swal.fire({
                    title: "Error!",
                    text: "El correo electronico ya existe",
                    icon: "error",
                    confirmButtonColor: "#5156be"
                });
            }
            //console.log(datos);
        }
    });
}

init();