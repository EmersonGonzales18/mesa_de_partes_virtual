var tabla;
var tabla_permiso;
function init(){
    $("#mnt_rol_form").on("submit",function(e){
        guardar(e);
    });
}

//TODO: Funcion de guardado
function guardar(e){
    e.preventDefault();
    var formData = new FormData($("#mnt_rol_form")[0]);
    $.ajax({
        url:"../../controllers/rol.php?opcion=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            if(datos == 1){
                $("#rol_id").val('');
                $("#mnt_rol_form")[0].reset();
                $("#listado_rol").DataTable().ajax.reload();
                $("#mnt_rol_modal").modal('hide');
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
                $("#rol_id").val('');
                $("#mnt_rol_form")[0].reset();
                $("#listado_rol").DataTable().ajax.reload();
                $("#mnt_rol_modal").modal('hide');
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
    tabla = $("#listado_rol").dataTable({
      "aProcessing" : true,
      "aServerSide" : true,
      dom : "Bfrtip",
      "searching" : true,
      lengthChange : false,
      colReorder :true,
      "ajax":{
        url:"../../controllers/rol.php?opcion=listar",
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
    $("#rol_id").val('');
    $("#mnt_rol_form")[0].reset();
    $("#mnt_rol_modal").modal('show');
    $("#staticBackdropLabel").html('Nuevo Tipo de Rol');
});

function editar(rol_id){
    $("#staticBackdropLabel").html('Editar Tipo de Rol');
    $.post("../../controllers/rol.php?opcion=mostrar", {rol_id: rol_id}, function(data){
        data = JSON.parse(data);
        $("#rol_id").val(data.rol_id);
        $("#rol_nombre").val(data.rol_nombre);
        $("#mnt_rol_modal").modal('show');
    });

}

function eliminar(rol_id){
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
            $.post("../../controllers/rol.php?opcion=eliminar", {rol_id: rol_id}, function(data){
                console.log(data);
                Swal.fire({
                    title: "Mesa de Partes",
                    text: "Se eliminó con Exito",
                    icon: "success"
                  });
                $("#listado_rol").DataTable().ajax.reload();
            });
        }
    })
}


function permiso(rol_id){
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
      url:"../../controllers/rol.php?opcion=listar_permisos",
      type : "POST",
      data : {rol_id : rol_id},
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


function habilitar(menud_id){
  $.post("../../controllers/rol.php?opcion=habilitar", {menud_id: menud_id}, function(data){
    console.log(data);
    $("#listado_permisos").DataTable().ajax.reload();
});
}
function deshabilitar(menud_id){
  $.post("../../controllers/rol.php?opcion=deshabilitar", {menud_id: menud_id}, function(data){
    console.log(data);
    $("#listado_permisos").DataTable().ajax.reload();
});
}
init();