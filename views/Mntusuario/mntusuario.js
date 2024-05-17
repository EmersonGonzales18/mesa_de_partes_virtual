var tabla;
var tabla_permiso;
function init(){
    $("#mnt_personal_form").on("submit",function(e){
        guardar(e);
    });
}

//TODO: Funcion de guardado
function guardar(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_personal_form")[0]);
    $.ajax({
        url:"../../controllers/usuario.php?opcion=guardaryeditar_personal",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            console.log(datos);
            if(datos == 1){
                $('#btn_guardar').prop('disabled', false);
                $('#btn_guardar').html('Guardar');

                $("#usu_id").val('');
                $("#mnt_personal_form")[0].reset();
                $("#listado_personal").DataTable().ajax.reload();
                $("#mnt_personal_modal").modal('hide');
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
                $('#btn_guardar').prop('disabled', false);
                $('#btn_guardar').html('Guardar');
                $("#usu_id").val('');
                $("#mnt_personal_form")[0].reset();
                $("#listado_personal").DataTable().ajax.reload();
                $("#mnt_personal_modal").modal('hide');
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se actualizo con Exito",
                    icon: "success"
                  });
            }

        }, beforeSend: function(){
          $('#btn_guardar').prop('disabled', true);
          $('#btn_guardar').html('<i class="bx bx-hourglass bx-spin font-size-16 align-middle me-2"></i>Espere ...');
      }
    });
}
$(document).ready(function () {
    $.post("../../controllers/rol.php?opcion=combo", function(data){
        $('#rol_id').html(data);
    });

    tabla = $("#listado_personal").dataTable({
      "aProcessing" : true,
      "aServerSide" : true,
      dom : "Bfrtip",
      "searching" : true,
      lengthChange : false,
      colReorder :true,
      "ajax":{
        url:"../../controllers/usuario.php?opcion=listar",
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
    $("#usu_id").val('');
    $("#mnt_personal_form")[0].reset();
    $("#mnt_personal_modal").modal('show');
    $("#staticBackdropLabel").html('Nuevo Usuario de Personal');
});

function editar(usu_id){
    $("#staticBackdropLabel").html('Editar Usuario de Personal');
    $.post("../../controllers/usuario.php?opcion=mostrar", {usu_id: usu_id}, function(data){
        data = JSON.parse(data);
        $("#usu_id").val(data.usu_id);
        $("#usu_nombres").val(data.usu_nombres);
        $("#usu_correo").val(data.usu_correo);
        $("#rol_id").val(data.rol_id);
        $("#mnt_personal_modal").modal('show');
    });

}

function eliminar(usu_id){
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
            $.post("../../controllers/usuario.php?opcion=eliminar", {usu_id: usu_id}, function(data){
                console.log(data);
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se eliminó con Exito",
                    icon: "success"
                  });
                $("#listado_personal").DataTable().ajax.reload();
            });
        }
    })
}

function permiso(usu_id){
  tabla_permiso = $("#listado_permisos").dataTable({
    "aProcessing" : true,
    "aServerSide" : true,
    dom : "lfrtip",
    columnDefs: [
      { className: 'dt-center', targets: [1] } // Cambia '0' al índice de tu columna
    ],
    "searching" : true,
    lengthChange : false,
    colReorder :true,
    "ajax":{
      url:"../../controllers/area.php?opcion=listar_permisos",
      type : "POST",
      data : {usu_id : usu_id},
      dataType : "json",
      error:function(e){
        console.log(e.responseText);
      }
    },
    "bDestroy" : true,
    "responsive" : true,
    "bInfo" : true,
    "iDisplayLenght" : 15,
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
  $("#mnt_permiso").modal('show');
}
function habilitar(aread_id){
  $.post("../../controllers/area.php?opcion=habilitar", {aread_id: aread_id}, function(data){
    console.log(data);
    $("#listado_permisos").DataTable().ajax.reload();
});
}
function deshabilitar(aread_id){
  $.post("../../controllers/area.php?opcion=deshabilitar", {aread_id: aread_id}, function(data){
    console.log(data);
    $("#listado_permisos").DataTable().ajax.reload();
});
}
init();