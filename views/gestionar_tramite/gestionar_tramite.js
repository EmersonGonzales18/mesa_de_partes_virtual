var tabla;
var tabla_detalle_documento;

let arrayDocumentos = [];
//TODO: Desinicializar el dropzone del index
Dropzone.autoDiscover = false;
//TODO: Inicializar el dropzone
let myDropzone = new Dropzone(".dropzone", {
  url: "../../documents/respuesta/",
  maxFilesize: 10,
  maxFiles: 5,
  acceptedFiles: "application/pdf",
  addRemoveLinks: true,
  dictRemoveFile: "Remover",
});
//TODO: Funcion para delimitar el numero de archivos
myDropzone.on("maxfilesexceeded", function (file) {
  Swal.fire({
    title: "Mesa de Partes",
    text: "Solo se permite un maximo de 5 archivos",
    icon: "error",
    confirmButtonColor: "#5156be",
  });
  myDropzone.removeFile(file);
});
//TODO: Funcion para delimitar el tamaño de cada archivo
myDropzone.on("addedfile", function (file) {
  if (file.size > 10 * 1024 * 1024) {
    2;
    Swal.fire({
      title: "Mesa de Partes",
      text: 'El archivo "' + file.name + '" excede el tamaño maximo de 10 MB',
      icon: "warning",
      confirmButtonColor: "#5156be",
    });
    myDropzone.removeFile(file);
  }
});

myDropzone.on("addedfile", (file) => {
  arrayDocumentos.push(file);
});

myDropzone.on("removedfile", (file) => {
  let i = arrayDocumentos.indexOf(file);
  arrayDocumentos.splice(i, 1);
});

$(document).ready(function () {
  $.post("../../controllers/usuario.php?opcion=combo_area", function (data) {
    $("#area_id").html(data);
  });

  $("#area_id").change(function () {
    $("#area_id").each(function () {
      let area_id = $(this).val();

      tabla = $("#listado_table")
        .dataTable({
          aProcessing: true,
          aServerSide: true,
          dom: "Bfrtip",
          buttons: [
            {
              extend: "excel",
              text: '<i class="mdi mdi-file-excel"></i>',
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5], // Exporta solo las columnas visibles
              },
              titleAttr: "Exportar a Excel",
              className: "btn btn-success waves-effect waves-light",
            },
            {
              extend: "pdf",
              text: '<i class="mdi mdi-file-pdf"></i>',
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5], // Exporta solo las columnas visibles
              },
              titleAttr: "Exportar a PDF",
              className: "btn btn-danger waves-effect waves-light ml-2",
            },
            {
              extend: "copy",
              text: '<i class="mdi mdi-content-copy"></i>',
              exportOptions: {
                columns: [0, 1, 2, 3, 4, 5], // Exporta solo las columnas visibles
              },
              titleAttr: "Copiar",
              className: "btn btn-warning waves-effect waves-light",
            },
          ],
          order: [0, "desc"],
          searching: true,
          lengthChange: false,
          colReorder: true,
          ajax: {
            url: "../../controllers/documento.php?opcion=listar_documentos_area",
            type: "POST",
            data: { area_id: area_id },
            dataType: "json",
            error: function (e) {
              console.log(e.responseText);
            },
          },
          bDestroy: true,
          responsive: true,
          bInfo: true,
          pageLength: 6,
          autoWitdh: false,
          language: {
            sProcessing: "Procesando...",
            sLenghtMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se han encontrado resultados",
            sEmptyTable: "Ningun dato disponible en esta tabla",
            sInfo: "Mostrando un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando un total de 0 registros",
            sInfoFiltered: "(Filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
              sFirst: "Primero",
              sLast: "Ultimo",
              sNext: "Siguiente",
              sPrevious: "Anterior",
            },
            oAria: {
              sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
              sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
            },
          },
        })
        .DataTable();
    });
  });
});

function ver(doc_id) {
  $.post(
    "../../controllers/documento.php?opcion=mostrar_modal",
    { doc_id: doc_id },
    function (data) {
      data = JSON.parse(data);
      $("#usu_tipo").val(data.tipo_nom);
      $("#doc_dni").val(data.doc_dni);
      $("#doc_nombres").val(data.doc_nombres);

      $("#area_nom").val(data.doc_estado);
      $("#tram_nom").val(data.tram_nom);
      $("#doc_folios").val(data.doc_folios);
      $("#doc_folios").val(data.doc_folios);
      $("#doc_descr").val(data.doc_descr);
      $("#usu_correo").val(data.usu_correo);
      $("#doc_id").val(data.doc_id);
      $("#lblmodal").html("N° de Trámite : " + data.numero_tramite);

      $("#nombre_usuario").html(data.usu_nombres);
      $("#correo_usuario").html(data.usu_correo);
      $("#adjuntos").html(data.cantidad);

      if (data.doc_estado == "Pendiente") {
        $("#estado_doc").html(
          "<span class='badge bg-warning'>Pendiente</span>"
        );
      } else if (data.doc_estado == "Terminado") {
        $("#estado_doc").html(
          "<span class='badge bg-success'>Terminado</span>"
        );
      }
      if (data.doc_link == "") {
        $("#doc_link").val("No se han registrados enlaces");
      } else {
        $("#doc_link").val(data.doc_link);
      }

      tabla_detalle_documento = $("#listado_detalle_documento")
        .dataTable({
          aProcessing: true,
          paging: false,
          aServerSide: true,
          order: [0, "desc"],
          searching: false,
          lengthChange: false,
          colReorder: true,
          ajax: {
            url: "../../controllers/documento.php?opcion=listar_documentos_detalles",
            type: "POST",
            data: { doc_id: doc_id, detalle_tipo: "Pendiente" },
            dataType: "json",
            error: function (e) {
              console.log(e.responseText);
            },
          },
          bDestroy: true,
          responsive: true,
          bInfo: false,
          iDisplayLenght: 5,
          autoWitdh: false,
          language: {
            sProcessing: "Procesando...",
            sLenghtMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se han encontrado resultados",
            sEmptyTable: "Ningun dato disponible en esta tabla",
            sInfo: "Mostrando un total de _TOTAL_ registros",
            sInfoEmpty: "Mostrando un total de 0 registros",
            sInfoFiltered: "(Filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
              sFirst: "Primero",
              sLast: "Ultimo",
              sNext: "Siguiente",
              sPrevious: "Anterior",
            },
            oAria: {
              sSortAscending:
                ": Activar para ordenar la columna de manera ascendente",
              sSortDescending:
                ": Activar para ordenar la columna de manera descendente",
            },
          },
        })
        .DataTable();
    }
  );
  $("#modal_documento").modal("show");
}

function init() {
  $("#documento_respuesta").on("submit", function (e) {
    guardar(e);
  });
}

function guardar(e){
  e.preventDefault();
  if(arrayDocumentos.length === 0 ){
      Swal.fire({
          title: "Esta seguro?",
          text: "No ha adjuntado ningun documento para la respuesta",
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

  var formData = new FormData($("#documento_respuesta")[0]);
  var totaldocument = arrayDocumentos.length;
  for(var i=0;i<totaldocument;i++){
      formData.append("file[]",arrayDocumentos[i]);
  }
  $.ajax({
      url:"../../controllers/documento.php?opcion=respuesta_documento",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(data){
          $("#documento_respuesta")[0].reset();
          $("#listado_table").DataTable().ajax.reload();

          Dropzone.forElement('.dropzone').removeAllFiles(true);
          $("#modal_documento").modal("hide");
          Swal.fire({
              title: "Mesa de Partes",
              html: "El trámite N° :<strong> " + data + "</strong> <br>Ha sido respondido e informado al usuario",
              icon: "success",
              confirmButtonColor: "#5156be"
          });
          $('#btnenviar').prop('disabled', false);
          $('#btnenviar').html('Responder');
      }
  });
}
$(document).on("click","#btnlimpiar", function(){
  $("#documento_respuesta")[0].reset();
  Dropzone.forElement('.dropzone').removeAllFiles(true);
});
init();