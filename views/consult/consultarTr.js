var tabla;
$(document).on("click", "#video", function () {
  $("#modal_video").modal("show");
});
$(document).ready(function () {
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
        url: "../../controllers/documento.php?opcion=listar_documentos_usuario",
        type: "GET",
        dataType: "json",
        error: function (e) {
          console.log(e.responseText);
        },
      },
      bDestroy: true,
      responsive: true,
      bInfo: true,
      iDisplayLenght: 6,
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
      $("#doc_respuesta").val(data.doc_respuesta);
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

      tabla_detalle_respuesta = $("#listado_detalle_documento_respuesta")
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
            data: { doc_id: doc_id, detalle_tipo: "Terminado" },
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
$(document).on("click","#btnlimpiar", function(){
  $("#modal_documento").modal("hide");
});