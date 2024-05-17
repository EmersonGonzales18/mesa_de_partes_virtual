$(document).on("click", "#video", function(){
    $("#modal_video").modal('show');
});
//TODO: Darle estilo a los selector 
let arrayDocumentos = [];
//TODO: Desinicializar el dropzone del index
Dropzone.autoDiscover=false;
//TODO: Inicializar el dropzone
let myDropzone = new Dropzone('.dropzone',{
    url: "../../documents/registro/",
    maxFilesize : 10,
    maxFiles: 5,
    acceptedFiles : 'application/pdf',
    addRemoveLinks: true,
    dictRemoveFile: 'Remover'
});
//TODO: Funcion para delimitar el numero de archivos
myDropzone.on('maxfilesexceeded', function(file){
    Swal.fire({
        title: "Mesa de Partes",
        text: "Solo se permite un maximo de 5 archivos",
        icon: "error",
        confirmButtonColor: "#5156be"
    });
    myDropzone.removeFile(file);
});
//TODO: Funcion para delimitar el tamaño de cada archivo
myDropzone.on('addedfile', function(file){
    if(file.size > 10 * 1024*1024){2
        Swal.fire({
            title: "Mesa de Partes",
            text: 'El archivo "'+ file.name +'" excede el tamaño maximo de 10 MB',
            icon: "warning",
            confirmButtonColor: "#5156be"
        });
        myDropzone.removeFile(file);
    }
});

myDropzone.on('addedfile', file =>{
    arrayDocumentos.push(file);
});

myDropzone.on('removedfile', file =>{
    let i = arrayDocumentos.indexOf(file);
    arrayDocumentos.splice(i,1);
});


//TODO: Caputar el evento del boton
function init(){
    $("#document_form").on("submit",function(e){
        guardar(e);
    });
}

//TODO: Funcion de guardado
function guardar(e){
    e.preventDefault();
    if(arrayDocumentos.length === 0 ){
        Swal.fire({
            title: "Esta seguro?",
            text: "No ha adjuntado ningun documento",
            icon: "warning", 
            showCancelButton: !0,
            confirmButtonText: "Sí, enviar",
            cancelButtonText: "Regresar",
            buttonsStyling: !1,
            customClass: {
                confirmButton: "btn btn-primary mt-2",
                cancelButton: "btn btn-secondary ms-2 mt-2"
              }
        }).then((result) => {
            if(result.isConfirmed){
                enviar_tramite();
            }
        })
    }else{
        enviar_tramite();
    }
}

function enviar_tramite(){
    $('#btnenviar').prop('disabled', true);
    $('#btnenviar').html('<i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>Enviando ...');

    var formData = new FormData($("#document_form")[0]);
    var totaldocument = arrayDocumentos.length;
    for(var i=0;i<totaldocument;i++){
        formData.append("file[]",arrayDocumentos[i]);
    }
    $.ajax({
        url:"../../controllers/documento.php?opcion=registrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            $("#document_form")[0].reset();
            Dropzone.forElement('.dropzone').removeAllFiles(true);
            
            Swal.fire({
                title: "Mesa de Partes",
                html: "Tramite Registrado con<br>N° :<strong> " + data + "</strong>",
                icon: "success",
                confirmButtonColor: "#5156be"
            });
            $('#btnenviar').prop('disabled', false);
            $('#btnenviar').html('Enviar');
        }
    });
}

//TODO: Cargar los select de la pagina form
$(document).ready(function() {
    const combobox = document.querySelector('#area_id');
    $.post("../../controllers/area.php?opcion=combo", function(data){
        $('#area_id').html(data);
    });
    $.post("../../controllers/tipo.php?opcion=combo", function(data){
        $('#tipo_id').html(data);
    });
    //$.post("../../controllers/tramite.php?opcion=combo", function(data){
        //$('#tram_id').html(data);
    //});

    combobox.addEventListener('change', () => {
        let valor = combobox.value;
        switch(valor){
            case '2':
                $.post("../../controllers/tramite.php?opcion=comboRemuneraciones", function(data){
                    $('#tram_id').html(data);
                });
                break;
            case '1':
                $.post("../../controllers/tramite.php?opcion=comboInformatica", function(data){
                        $('#tram_id').html(data);
                });
                break;
        }
    });

});

$(document).on("click","#btnlimpiar", function(){
    $("#document_form")[0].reset();
    Dropzone.forElement('.dropzone').removeAllFiles(true);
});
init();