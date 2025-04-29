@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/pickr/themes/classic.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="alert alert-dark bg-azul-claro" role="alert">
            <h4 class="display-4 d-flex align-items-center">
                <i data-feather="bookmark" class="me-3" style="width: 45px; height: 45px;"></i>
                <strong>SECCIONES</strong>
            </h4>
            <h5 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Módulo de administracion de secciones.</div></h5>
            <br />
            <div class="col-md-3">
                <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('instituciones')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                    <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                </a>
            </div>
        </div>
        <hr />
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card border-secondary">
                <h5 class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                    <span class="text-white"> <i class="text-white icon-lg pb-3px" data-feather="list"></i> Secciones </span>
                    <button type="button" id="btn_agregar" class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target=".modal_asignaturas">
                        <i class="btn-icon-prepend" data-feather="plus" style="width: 20px; height: 20px;"></i> Agregar
                    </button>
                </h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="jambo_table table table-hover" id="tbl_secciones" border="1">
                            <thead class="bg-negro">
                                <tr class="headings">
                                    <th scope="col" class="text-white">ID</th>
                                    <th scope="col" class="text-white">Sección</th>
                                    <th scope="col" class="text-white">Aula</th>
                                    <th scope="col" class="text-white">Hora Inicio</th>
                                    <th scope="col" class="text-white">Hora Fin</th>
                                    <th scope="col" class="text-white">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secciones as $row)
                                <tr style="font-size: small;">
                                    <td scope="row">{{$row->id}}</td>
                                    <td scope="row">{{$row->nombre}}</td>
                                    <td scope="row">{{$row->aula}}</td>
                                    <td scope="row">{{$row->hora_inicio}}</td>
                                    <td scope="row">{{$row->hora_fin}}</td>
                                    <td scope="row">
                                        <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target=".modal_asignaturas"
                                            data-id="{{$row->id}}"
                                            data-id_periodo_academico="{{$row->nombre}}"
                                            data-asignatura="{{$row->asignatura}}"
                                            data-detalle="{{$row->hora_inicio}}"
                                            data-detalle="{{$row->hora_fin}}"
                                            >
                                            <i data-feather="edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger btn-icon btn-xs"
                                            data-bs-toggle="modal" 
                                            data-bs-target=".modal_eliminar"
                                            data-id="{{$row->id}}"
                                            data-id_periodo_academico="{{$row->nombre}}"
                                            data-asignatura="{{$row->asignatura}}"
                                            data-detalle="{{$row->hora_inicio}}"
                                            data-detalle="{{$row->hora_fin}}"
                                            >
                                            <i data-feather="trash-2"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extra large modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal_asignaturas">Extra large modal</button> -->
<div class="modal fade modal_asignaturas" id="modal_asignaturas" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-azul">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="plus"></i> Registrar Sección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <div class="col-lg-2 col-md-12 col-sm-12">
                                <div class="mb-3">
                                <label class="form-label"><strong>ID Asignatura</strong> <font class="text-danger">*</font></label>
                                    <select class="js-example-basic-single form-select" id="id_periodo_academico" data-width="100%">
                                        @foreach($periodos_academicos as $row)
                                            <option value="{{$row->id}}">{{$row->nombre}}</option>
                                        @endforeach
                                    </select>
                                    <!-- <label class="form-label"><strong>ID Asignatura</strong> <font class="text-danger">*</font></label>
                                    <input type="text" id="id_periodo_academico" class="form-control" placeholder="Ingresa el ID de la asignatura" /> -->
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Asignatura</strong> <font class="text-danger">*</font></label>
                                    <input type="text" id="asignatura" class="form-control" placeholder="Ingresa la asignatura" />
                                </div>
                            </div>
                            <!-- Col -->
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Detalle</strong></label>
                                    <input type="text" id="detalle" class="form-control" placeholder="Ingresa el detalle" />
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-negro">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_guardar_asignatura">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- Large modal -->

<!-- Extra large modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal_eliminar">Extra large modal</button> -->
<div class="modal fade modal_eliminar" id="modal_eliminar" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Eliminar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-warning" data-feather="alert-circle" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>¿Realmente deseas eliminar este registro?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_estudiante"></label></h5>
                                        <br>
                                        <p class="fw-normal">Este proceso no se puede revertir</p>
                                    </div>
                                </div>
                            </center>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-negro">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_eliminar_estudiante">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<!-- Large modal -->

@endsection
@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/flatpickr/flatpickr.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="{{ asset('assets/js/select2.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null;
    var accion = null;
    var btn_activo = true;
    var id_institucion = "{{$id_institucion}}"
    var id = null;
    var id_periodo_academico = null;
    var asignatura = null;
    var detalle = null;
    var rowNumber = null; 
    var url_guardar_asignatura = "{{url('/instituciones/asignaturas/guardar')}}"; 
    var id_seleccionar = localStorage.getItem("tbl_secciones_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        if($('#flatpickr-date').length) {
            flatpickr("#flatpickr-date", {
            wrap: true,
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            });
        }

        $('#modal_asignaturas').on('shown.bs.modal', function () {
            $('.js-example-basic-single').select2({
                dropdownParent: $('#modal_asignaturas'),
                width: '100%'
            });
        });

        table = $("#tbl_secciones").DataTable({
            aLengthMenu: [
                [10, 30, 50, 100, -1],
                [10, 30, 50, 100, "Todo"],
            ],
            iDisplayLength: 10,
            language: {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                infoPostFix: "",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último",
                },
                aria: {
                    sortAscending: ": Activar para ordenar la columna de manera ascendente",
                    sortDescending: ": Activar para ordenar la columna de manera descendente",
                },
            },
        });

        $("#btn_agregar").on("click", function () {
            accion = 1;
        });

        $("#tbl_secciones tbody").on("click", ".btn_editar", function () {
            //alert('Hey');
            accion = 2;
        });

        $("#tbl_secciones").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Buscar");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#modal_asignaturas").on("show.bs.modal", function (e) {
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            id_periodo_academico = triggerLink.data("id_periodo_academico");
            asignatura  = triggerLink.data("asignatura");
            detalle = triggerLink.data("detalle");
            $("#id_periodo_academico").val(id_periodo_academico);
            $("#asignatura").val(asignatura);
            $("#detalle").val(detalle);
        });

        $("#modal_eliminar").on("show.bs.modal", function (e) {
            accion = 3;
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            id_periodo_academico = triggerLink.data("id_periodo_academico");
            asignatura  = triggerLink.data("asignatura");
            detalle = triggerLink.data("detalle");
            $("#modal_estudiante").html(id_periodo_academico);
        });

        $(".modal-footer").on("click", "#btn_eliminar_estudiante", function () { 
            if(btn_activo){
                guardar_id_periodo_academico(); 
            }
        }); 

        $("#tbl_secciones tbody").on("click", "tr", function () {
            rowNumber = parseInt(table.row(this).index());
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
            localStorage.setItem("tbl_secciones_id_seleccionar", table.row(this).data()[0]);
        });


        $("#btn_guardar_asignatura").on("click", function () {
            id_periodo_academico = $("#id_periodo_academico").val();
            asignatura  = $("#asignatura").val();
            detalle = $("#detalle").val();

            if(id_periodo_academico == null || id_periodo_academico == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Periódo Académico.'
                })
                return true;
            }

            if(asignatura == null || asignatura == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Año.'
                })
                return true;
            }

            if(btn_activo){
                guardar_id_periodo_academico();
            }
            

        });

    });

    function guardar_id_periodo_academico() {
        btn_activo = false;
        //console.log(accion);
        $.ajax({
            type: "post",
            url: url_guardar_asignatura,
            data: {
                accion: accion,
                id_institucion : id_institucion,
                id: id,
                id_periodo_academico : id_periodo_academico,
                asignatura : asignatura,
                detalle : detalle,
            },
            success: function (data) {
                if (data.msgError != null) {
                    titleMsg = "Error al Cargar";
                    textMsg = data.msgError;
                    typeMsg = "error";
                    btn_activo = true;
                } else {
                    titleMsg = "Datos Cargados";
                    textMsg = data.msgSuccess;
                    typeMsg = "success";
                    for(var i = 0; i < data.asignaturas.length; i++) { 
                        var row= data.asignaturas[i]; 
                        var nuevaFilaDT=[ 
                                     row.id,row.id_periodo_academico,row.asignatura,row.detalle,
                                      '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_asignaturas" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-id_periodo_academico="' + row.id_periodo_academico + '" ' +
                                        'data-asignatura="' + row.asignatura + '" ' +
                                            'data-detalle="' + row.detalle + '" ' +
                                            '>'+
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> ' +
                                    '</button> ' +
                                    '<button type="button" class="btn btn-danger btn-icon btn-xs" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_eliminar" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-id_periodo_academico="' + row.id_periodo_academico + '" ' +
                                        'data-asignatura="' + row.asignatura + '" ' +
                                            'data-detalle="' + row.detalle + '" ' +
                                            '>'+
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> ' +
                                    '</button>'
                                     ]; 
                                    if(accion==1) {
                                        $("#modal_asignaturas").modal('hide');
                                        table.row.add(nuevaFilaDT).draw();
                                    }else if (accion==2) {
                                        $("#modal_asignaturas").modal('hide');
                                        table.row(rowNumber).data(nuevaFilaDT);
                                    } 
                    }
                    if (accion == 3){
                            $("#modal_eliminar").modal("hide");
                            table.row(rowNumber).remove().draw();
                        }  
                        btn_activo = true;
                    
                }
                console.log(textMsg);
                Toast.fire({
                    icon: typeMsg,
                    title: textMsg
                })
            },
            error: function (xhr, status, error) {
                alert(xhr.responseText);
            },
        });
    }

    
    const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

  </script>
@endpush