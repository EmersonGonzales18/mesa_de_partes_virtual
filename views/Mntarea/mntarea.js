var tabla;
function init(){
    $("#mnt_area_form").on("submit",function(e){
        guardar(e);
    });
}

//TODO: Funcion de guardado
function guardar(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_area_form")[0]);
    $.ajax({
        url:"../../controllers/area.php?opcion=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            if(datos == 1){
                $("#area_id").val('');
                $("#mnt_area_form")[0].reset();
                $("#listado_area").DataTable().ajax.reload();
                $("#mnt_area_modal").modal('hide');
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
                $("#area_id").val('');
                $("#mnt_area_form")[0].reset();
                $("#listado_area").DataTable().ajax.reload();
                $("#mnt_area_modal").modal('hide');
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
    tabla = $("#listado_area").dataTable({
      "aProcessing" : true,
      "aServerSide" : true,
      dom : "Bfrtip",
      "searching" : true,
      lengthChange : false,
      colReorder :true,
      "ajax":{
        url:"../../controllers/area.php?opcion=listar",
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
    $("#area_id").val('');
    $("#mnt_area_form")[0].reset();
    $("#mnt_area_modal").modal('show');
    $("#staticBackdropLabel").html('Nuevo Tipo de Area');
});

function editar(area_id){
    $("#staticBackdropLabel").html('Editar Tipo de Area');
    $.post("../../controllers/area.php?opcion=mostrar", {area_id: area_id}, function(data){
        data = JSON.parse(data);
        $("#area_id").val(data.area_id);
        $("#area_nom").val(data.area_nom);
        $("#area_correo").val(data.area_correo);
        $("#mnt_area_modal").modal('show');
    });

}

function eliminar(area_id){
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
            $.post("../../controllers/area.php?opcion=eliminar", {area_id: area_id}, function(data){
                console.log(data);
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se eliminó con Exito",
                    icon: "success"
                  });
                $("#listado_area").DataTable().ajax.reload();
            });
        }
    })
}
init();