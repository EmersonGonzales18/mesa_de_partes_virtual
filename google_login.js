//TODO: Funcion para iniciar el proceso de inicio de sesion con google
function startGoogleSignIn(){
    //TODO: Obtener la instancia de autenticacion de google
    const auth = gapi.auth2.getAuthInstance();
    //TODO: Iniciar sesion con google
    auth.signIn();
}

function handleCredentialResponse(response){

    $.ajax({
        type : 'POST',
        url : 'controllers/usuario.php?opcion=registrarGoogle',
        contentType : 'application/json',
        headers : {
            "Content-Type" : "application/json"
        },
        data : JSON.stringify({
            request_type : 'user_auth',
            credential : response.credential
        }),
        success:    function(data){
            console.log(data);
            if(data === "1"){
                Swal.fire({
                    title: "Exito!",
                    text: "Se ha creado su cuenta con los datos de Google",
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
                        window.location.href="views/home/";
                    },
                }).then(function(result){
                    if(result.dismiss === Swal.DismissReason.timer){
                        console.log("I was closed by the timer") ;
                    }
                });
            }else if(data === "0"){
                Swal.fire({
                    title: "Exito!",
                    text: "Accediendo a su cuenta",
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
                        window.location.href="views/home/";
                    },
                }).then(function(result){
                    if(result.dismiss === Swal.DismissReason.timer){
                        console.log("I was closed by the timer") ;
                    }
                });
            }
        }
    })

    if(response && response.credential){
        const credentialToken = response.credential;

        const decodificadoToken = JSON.parse(atob(credentialToken.split('.')[1]));

        //console.log(decodificadoToken);
    }
}
