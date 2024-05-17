var tabla;
function init(){
    $("#mnt_tipo_form").on("submit",function(e){
        guardar(e);
    });
}

//TODO: Funcion de guardado
function guardar(e){
    e.preventDefault();

    var formData = new FormData($("#mnt_tipo_form")[0]);
    $.ajax({
        url:"../../controllers/tipo.php?opcion=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            if(datos == 1){
                $("#tipo_id").val('');
                $("#mnt_tipo_form")[0].reset();
                $("#listado_tipo").DataTable().ajax.reload();
                $("#mnt_tipo_modal").modal('hide');
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se registro con Exito",
                    icon: "success"
                  });
            }else if(datos ==0){
                Swal.fire({
                    title: "Error",
                    text: "Registro Duplicado",
                    icon: "warning"
                  });
            }else if(datos ==2){
                $("#tipo_id").val('');
                $("#mnt_tipo_form")[0].reset();
                $("#listado_tipo").DataTable().ajax.reload();
                $("#mnt_tipo_modal").modal('hide');
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se actualizo con Exito",
                    icon: "success"
                  });
            }
            

        }
    });
}
$(document).ready(function () {
    tabla = $("#listado_tipo").dataTable({
      "aProcessing" : true,
      "aServerSide" : true,
      dom : "Bfrtip",
      "searching" : true,
      lengthChange : false,
      colReorder :true,
      "ajax":{
        url:"../../controllers/tipo.php?opcion=listar",
        type : "GET",
        dataType : "json",
        error:function(e){
          console.log(e.responseText);
        }
      },
      "bDestroy" : true,
      "responsive" : true,
      "bInfo" : true,
      "iDisplayLenght" : 10,
      "autoWitdh" : false,
      "language" : {
        "sProcessing" : "Procesando...",
        "sLenghtMenu" : "Mostrar _MENU_ registros",
        "sZeroRecords": "No se han encontrado resultados",
        "sEmptyTable" : "Ningun dato disponible en esta tabla",
        "sInfo"       : "Mostrando un total de _TOTAL_ registros",
        "sInfoEmpty"  : "Mostrando un total de 0 registros",
        "sInfoFiltered" : "(Filtrado de un total de _MAX_ registros)",
        "sInfoPostFix" : "",
        "sSearch"     : "Buscar",
        "sUrl"    : "",
        "sInfoThousands" : ",",
        "sLoadingRecords" : "Cargando...",
        "oPaginate" : {
          "sFirst" : "Primero",
          "sLast" : "Ultimo",
          "sNext" : "Siguiente",
          "sPrevious" : "Anterior",
        },
        "oAria" : {
          "sSortAscending" : ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending" : ": Activar para ordenar la columna de manera descendente"
        }

      }
    }).DataTable();
    
  });
  

$(document).on("click", "#btnuevo", function(){
    $("#tipo_id").val('');
    $("#mnt_tipo_form")[0].reset();
    $("#mnt_tipo_modal").modal('show');
    $("#staticBackdropLabel").html('Nuevo Tipo de Usuario');
});

function editar(tipo_id){
    $("#staticBackdropLabel").html('Editar Tipo de Usuario');
    $.post("../../controllers/tipo.php?opcion=mostrar", {tipo_id: tipo_id}, function(data){
        data = JSON.parse(data);
        $("#tipo_id").val(data.tipo_id);
        $("#tipo_nom").val(data.tipo_nom);
        $("#mnt_tipo_modal").modal('show');
    });

}

function eliminar(tipo_id){
    Swal.fire({
        title: "Esta seguro de eliminar el registro?",
        text: "El registro no se eliminara completamente del sistema",
        icon: "warning", 
        showCancelButton: !0,
        confirmButtonText: "Sí, Eliminar",
        cancelButtonText: "Cancelar",
        buttonsStyling: !1,
        customClass: {
            confirmButton: "btn btn-primary mt-2",
            cancelButton: "btn btn-secondary ms-2 mt-2"
          }
    }).then((result) => {
        if(result.isConfirmed){
            $.post("../../controllers/tipo.php?opcion=eliminar", {tipo_id: tipo_id}, function(data){
                console.log(data);
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se eliminó con Exito",
                    icon: "success"
                  });
                $("#listado_tipo").DataTable().ajax.reload();
            });
        }
    })
}
init();