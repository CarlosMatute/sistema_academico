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
                <i data-feather="book-open" class="me-3" style="width: 45px; height: 45px;"></i>
                <strong>MATRÍCULA</strong>
            </h4>
            <h5 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Módulo de administracion de la matrícula de los estudiantes.</div></h5>
            <br />
            <div class="col-md-3">
                <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('instituciones')}}/{{$id_institucion}}/periodos_academicos" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                    <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                </a>
            </div>
        </div>
        <hr />
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card border-secondary">
                <h5 class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                    <span class="text-white"> <i class="text-white icon-lg pb-3px" data-feather="users"></i> Estudiantes Matriculados </span>
                    <button type="button" id="btn_agregar" class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target=".modal_estudianres_secciones">
                        <i class="btn-icon-prepend" data-feather="user-plus" style="width: 15px; height: 15px;"></i> Matricular
                    </button>
                </h5>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="jambo_table table table-hover" id="tbl_secciones_estudiantes" border="1">
                            <thead class="bg-negro">
                                <tr class="headings">
                                    <th scope="col" class="text-white">ID</th>
                                    <th scope="col" class="text-white">Cuenta</th>
                                    <th scope="col" class="text-white">Nombre</th>
                                    <th scope="col" class="text-white">Correo</th>
                                    <th scope="col" class="text-white">Celular</th>
                                    <th scope="col" class="text-white">Carrera</th>
                                    <th scope="col" class="text-white">Observaciones</th>
                                    <th scope="col" class="text-white">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($secciones_estudiantes as $row)
                                <tr style="font-size: small;">
                                    <td scope="row">{{$row->id}}</td>
                                    <td scope="row">{{$row->numero_cuenta}}</td>
                                    <td scope="row">{{$row->nombre_estudiante}}</td>
                                    <td scope="row">{{$row->correo_electronico}}</td>
                                    <td scope="row">{{$row->celular}}</td>
                                    <td scope="row">{{$row->carrera}}</td>
                                    <td scope="row">{{$row->observaciones}}</td>
                                    <td scope="row">
                                        <!-- <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target=".modal_estudiantes"
                                            data-id="{{$row->id}}"
                                            data-numero_cuenta="{{$row->numero_cuenta}}"
                                            data-primer_nombre="{{$row->primer_nombre}}"
                                            data-segundo_nombre="{{$row->segundo_nombre}}"
                                            data-primer_apellido="{{$row->primer_apellido}}"
                                            data-segundo_apellido="{{$row->segundo_apellido}}"
                                            data-correo_electronico="{{$row->correo_electronico}}"
                                            data-celular="{{$row->celular}}"
                                            data-carrera="{{$row->carrera}}"
                                            >
                                            <i data-feather="edit"></i>
                                        </button> -->
                                        <button type="button" class="btn btn-danger btn-icon btn-xs"
                                            data-bs-toggle="modal" 
                                            data-bs-target=".modal_eliminar"
                                            data-id="{{$row->id}}"
                                            data-id_estudiante="{{$row->id_estudiante}}"
                                            data-numero_cuenta="{{$row->numero_cuenta}}"
                                            data-nombre_estudiante="{{$row->nombre_estudiante}}"
                                            data-primer_nombre="{{$row->primer_nombre}}"
                                            data-segundo_nombre="{{$row->segundo_nombre}}"
                                            data-primer_apellido="{{$row->primer_apellido}}"
                                            data-segundo_apellido="{{$row->segundo_apellido}}"
                                            data-correo_electronico="{{$row->correo_electronico}}"
                                            data-celular="{{$row->celular}}"
                                            data-carrera="{{$row->carrera}}"
                                            data-observaciones="{{$row->observaciones}}"
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
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal_estudianres_secciones">Extra large modal</button> -->
<div class="modal fade modal_estudianres_secciones" id="modal_estudianres_secciones" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-azul">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="user-plus"></i> Matricular Estudiantes</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                                <div class="table-responsive">
                                    <table class="jambo_table table table-hover" id="tbl_estudiantes_sin_matricula" border="1">
                                        <thead class="bg-negro">
                                            <tr class="headings">
                                                <th scope="col" class="text-white">ID</th>
                                                <th scope="col" class="text-white">Cuenta</th>
                                                <th scope="col" class="text-white">Nombre</th>
                                                <th scope="col" class="text-white">Correo</th>
                                                <th scope="col" class="text-white">Celular</th>
                                                <th scope="col" class="text-white">Carrera</th>
                                                <th scope="col" class="text-white">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($estudiantes_sin_matricula as $row)
                                            <tr style="font-size: small;">
                                                <td scope="row">{{$row->id}}</td>
                                                <td scope="row">{{$row->numero_cuenta}}</td>
                                                <td scope="row">{{$row->nombre_estudiante}}</td>
                                                <td scope="row">{{$row->correo_electronico}}</td>
                                                <td scope="row">{{$row->celular}}</td>
                                                <td scope="row">{{$row->carrera}}</td>
                                                <td scope="row">
                                                    <!-- <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target=".modal_estudiantes"
                                                        data-id="{{$row->id}}"
                                                        data-numero_cuenta="{{$row->numero_cuenta}}"
                                                        data-primer_nombre="{{$row->primer_nombre}}"
                                                        data-segundo_nombre="{{$row->segundo_nombre}}"
                                                        data-primer_apellido="{{$row->primer_apellido}}"
                                                        data-segundo_apellido="{{$row->segundo_apellido}}"
                                                        data-correo_electronico="{{$row->correo_electronico}}"
                                                        data-celular="{{$row->celular}}"
                                                        data-carrera="{{$row->carrera}}"
                                                        >
                                                        <i data-feather="edit"></i>
                                                    </button> -->
                                                    <button type="button" class="btn btn-success btn-icon btn-xs"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target=".modal_observaciones_matricula"
                                                        data-id="{{$row->id}}"
                                                        data-numero_cuenta="{{$row->numero_cuenta}}"
                                                        data-nombre_estudiante="{{$row->nombre_estudiante}}"
                                                        data-primer_nombre="{{$row->primer_nombre}}"
                                                        data-segundo_nombre="{{$row->segundo_nombre}}"
                                                        data-primer_apellido="{{$row->primer_apellido}}"
                                                        data-segundo_apellido="{{$row->segundo_apellido}}"
                                                        data-correo_electronico="{{$row->correo_electronico}}"
                                                        data-celular="{{$row->celular}}"
                                                        data-carrera="{{$row->carrera}}"
                                                        >
                                                        <i data-feather="plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-negro">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="button" class="btn btn-azul-claro btn-sm" data-bs-dismiss="modal">Guardar</button> -->
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
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Cancelar Matrícula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-danger" data-feather="user-x" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>¿Realmente deseas cancelar esta matrícula?</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_eliminar_detalle"></label></h5>
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
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_eliminar_estudiante">Cancelar Matrícula</button>
            </div>
        </div>
    </div>
</div>
<!-- Large modal -->

<div class="modal fade modal_observaciones_matricula" id="modal_observaciones_matricula" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-azul">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="x"></i> Matricular</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <center>
                                <i class="btn-icon-prepend text-dark" data-feather="user-plus" style="width: 90px; height: 90px;"></i>
                                <br><br>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <h4><label class="form-label"><strong>Matricular estudiante</strong></label></h4>
                                        <br>
                                        <h5><label class="form-label" id="modal_observaciones_matricula_detalle"></label></h5>
                                        <br>
                                        <label class="form-label"><strong>Observaciones</strong> (opcional)</label>
                                        <textarea class="form-control" id="modal_observaciones_matricula_observacion" maxlength="100" rows="8" placeholder="Describe algunas observaciones de ser necesario."></textarea>
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
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_matricular_estudiante">Matricular</button>
            </div>
        </div>
    </div>
</div>

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
    var table2 = null;
    var accion = null;
    var btn_activo = true;
    var id_institucion = "{{$id_institucion}}"
    var id_periodo_academico = "{{$id_periodo_academico}}";
    var id_seccion = "{{$id_seccion}}";
    var id = null;
    var seccion = null;
    var nombre_estudiante = null;
    var id_estudiante_sin_matricula = null;
    var observaciones_matricula_observacion = null;
    var id_asignatura = null;
    var hora_inicio = null;
    var hora_fin = null;
    var rowNumber = null; 
    var rowNumber2 = null; 
    var url_guardar_secciones_estudiantes = "{{url('/instituciones/periodos_academicos/secciones/estudiantes/guardar')}}"; 
    var id_seleccionar = localStorage.getItem("tbl_secciones_estudiantes_id_seleccionar");
    var id_seleccionar = localStorage.getItem("tbl_estudiantes_sin_matricula_id_seleccionar");
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
            noCalendar: true,
            dateFormat: "H:i",
            });
        }

        table = $("#tbl_secciones_estudiantes").DataTable({
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

        table2 = $("#tbl_estudiantes_sin_matricula").DataTable({
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

        $("#tbl_secciones_estudiantes tbody").on("click", ".btn_editar", function () {
            //alert('Hey');
            accion = 2;
        });

        $("#tbl_secciones_estudiantes").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Buscar");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#tbl_estudiantes_sin_matricula").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Buscar");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#modal_estudianres_secciones").on("show.bs.modal", function (e) {
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            seccion = triggerLink.data("seccion");
            aula = triggerLink.data("aula");
            //id_periodo_academico = triggerLink.data("id_periodo_academico");
            id_asignatura  = triggerLink.data("id_asignatura");
            hora_inicio = triggerLink.data("hora_inicio");
            hora_fin = triggerLink.data("hora_fin");
            $("#seccion").val(seccion);
            $("#aula").val(aula);
            //$("#id_periodo_academico").val(id_periodo_academico);
            $("#id_asignatura").val(id_asignatura);
            $("#hora_inicio").val(hora_inicio);
            $("#hora_fin").val(hora_fin);
        });

        $("#modal_observaciones_matricula").on("show.bs.modal", function (e) {
            accion = 1;
            var triggerLink = $(e.relatedTarget);
            nombre_estudiante = triggerLink.data("nombre_estudiante");
            id_estudiante_sin_matricula = triggerLink.data("id");
            observaciones_matricula_observacion = triggerLink.data("observaciones");
            $("#modal_observaciones_matricula_detalle").html(nombre_estudiante);
        });

        $("#modal_eliminar").on("show.bs.modal", function (e) {
            accion = 3;
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            nombre_estudiante = triggerLink.data("nombre_estudiante");
            id_estudiante_sin_matricula = triggerLink.data("id_estudiante");
            observaciones_matricula_observacion = triggerLink.data("observaciones");
            $("#modal_eliminar_detalle").html(nombre_estudiante);
        });

        $(".modal-footer").on("click", "#btn_eliminar_estudiante", function () { 
            if(btn_activo){
                guardar_secciones_estudiantes(); 
            }
        }); 

        $("#tbl_secciones_estudiantes tbody").on("click", "tr", function () {
            rowNumber = parseInt(table.row(this).index());
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
            localStorage.setItem("tbl_secciones_estudiantes_id_seleccionar", table.row(this).data()[0]);
        });

        $("#tbl_estudiantes_sin_matricula tbody").on("click", "tr", function () {
            rowNumber2 = parseInt(table2.row(this).index());
            table2.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
            localStorage.setItem("tbl_estudiantes_sin_matricula_id_seleccionar", table2.row(this).data()[0]);
        });


        $("#btn_matricular_estudiante").on("click", function () {
            observaciones_matricula_observacion = $("#modal_observaciones_matricula_observacion").val();
            //alert(id_estudiante_sin_matricula+' '+id_seccion+' '+observaciones_matricula_observacion);

            if(btn_activo){
                guardar_secciones_estudiantes();
            }
            

        });

    });

    function guardar_secciones_estudiantes() {
        btn_activo = false;
        //console.log(hora_inicio);
        $.ajax({
            type: "post",
            url: url_guardar_secciones_estudiantes,
            data: {
                accion: accion,
                id: id,
                id_estudiante_sin_matricula : id_estudiante_sin_matricula,
                observaciones_matricula_observacion: observaciones_matricula_observacion,
                id_seccion : id_seccion
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
                    if(accion==1) {
                        for(var i = 0; i < data.secciones_estudiantes.length; i++) { 
                        var row= data.secciones_estudiantes[i]; 
                        var nuevaFilaDT=[ 
                                     row.id,row.numero_cuenta,row.nombre_estudiante,row.correo_electronico,row.celular,row.carrera,row.observaciones,
                                    '<button type="button" class="btn btn-danger btn-icon btn-xs" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_observaciones_matricula" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-id_asignatura="' + row.id_asignatura+ '" ' +
                                        'data-seccion="' +row.nombre+ '" ' +
                                        'data-aula="' +row.aula+ '" ' +
                                        'data-hora_inicio="' +row.hora_inicio+ '" ' +
                                        'data-hora_fin="' +row.hora_fin+ '" ' +
                                        '>'+
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> ' +
                                    '</button>'
                                     ]; 
                        }
                                        $("#modal_observaciones_matricula").modal('hide');
                                        $("#modal_estudianres_secciones").modal('show');
                                        table.row.add(nuevaFilaDT).draw();
                                        table2.row(rowNumber2).remove().draw();
                                    }else if (accion==2) {
                                        $("#modal_estudianres_secciones").modal('hide');
                                        table.row(rowNumber).data(nuevaFilaDT);
                                    } 
                    if (accion == 3){
                        for(var i = 0; i < data.estudiantes_sin_matricula.length; i++) { 
                        var row= data.estudiantes_sin_matricula[i]; 
                        var nuevaFilaDT=[ 
                                     row.id,row.numero_cuenta,row.nombre_estudiante,row.correo_electronico,row.celular,row.carrera,
                                    '<button type="button" class="btn btn-success btn-icon btn-xs" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_observaciones_matricula" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-id_asignatura="' + row.id_asignatura+ '" ' +
                                        'data-seccion="' +row.nombre+ '" ' +
                                        'data-aula="' +row.aula+ '" ' +
                                        'data-hora_inicio="' +row.hora_inicio+ '" ' +
                                        'data-hora_fin="' +row.hora_fin+ '" ' +
                                        '>'+
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> ' +
                                    '</button>'
                                     ]; 
                        }
                            $("#modal_eliminar").modal("hide");
                            table.row(rowNumber).remove().draw();
                            table2.row.add(nuevaFilaDT).draw();
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