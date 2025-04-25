@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="row">
    <div class="col-12 col-md-12 col-xl-12">
        <div class="alert alert-dark bg-azul-claro" role="alert">
            <h4 class="display-4 d-flex align-items-center">
                <i data-feather="home" class="me-3" style="width: 45px; height: 45px;"></i>
                <strong>INSTITUCIONES</strong>
            </h4>
            <h5 class="lead bg-white"><div class="alert alert-fill-white" role="alert">Módulo de administracion de instituciones.</div></h5>
            <br />
            <div class="col-md-3">
                <!-- <a class="btn btn-info btn-sm" id="btn_volver_convenio" href="{{url('setic/malla_validacion')}}" data-toggle="tooltip" data-placement="top" title="Regresar a Malla de Validaciones">
                    <i class="btn-icon-prepend" data-feather="corner-up-left"></i> Regresar
                </a> -->
            </div>
        </div>
        <hr />
        <div class="col-12 col-md-12 col-xl-12">
            <div class="card border-secondary">
                <h5 class="card-header bg-azul text-white d-flex justify-content-between align-items-center">
                    <span class="text-white"> <i class="text-white icon-lg pb-3px" data-feather="list"></i> Instituciones </span>
                    <button type="button" id="btn_agregar" class="btn btn-azul-claro btn-sm" data-bs-toggle="modal" data-bs-target=".modal_instituciones">
                        <i class="btn-icon-prepend" data-feather="plus" style="width: 20px; height: 20px;"></i> Agregar
                    </button>
                </h5>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="jambo_table table table-hover" id="tbl_instituciones" border="1">
                            <thead class="bg-negro">
                                <tr class="headings">
                                    <th scope="col" class="text-white">ID</th>
                                    <th scope="col" class="text-white">Institución</th>
                                    <th scope="col" class="text-white">Siglas</th>
                                    <th scope="col" class="text-white">Campus</th>
                                    <th scope="col" class="text-white">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($instituciones as $row)
                                <tr style="font-size: small;">
                                    <td scope="row">{{$row->id}}</td>
                                    <td scope="row">{{$row->nombre}}</td>
                                    <td scope="row">{{$row->siglas}}</td>
                                    <td scope="row">{{$row->campus}}</td>
                                    <td scope="row">
                                    <button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" 
                                        data-bs-toggle="modal" 
                                        data-bs-target=".modal_instituciones"
                                        data-id="{{$row->id}}"
                                        data-nombre="{{$row->nombre}}"
                                        data-siglas="{{$row->siglas}}"
                                        data-campus="{{$row->campus}}"
                                        data-detalles="{{$row->detalles}}">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-icon btn-xs"
                                        data-bs-toggle="modal" 
                                        data-bs-target=".modal_eliminar"
                                        data-id="{{$row->id}}"
                                        data-nombre="{{$row->nombre}}"
                                        data-siglas="{{$row->siglas}}"
                                        data-campus="{{$row->campus}}"
                                        data-detalles="{{$row->detalles}}">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                    <a href="{{url('/instituciones/')}}/{{$row->id}}/estudiantes" type="button" class="btn btn-success btn-icon btn-xs">
                                        <i data-feather="users"></i>
                                    </a>
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
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".modal_instituciones">Extra large modal</button> -->
<div class="modal fade modal_instituciones" id="modal_instituciones" tabindex="-1" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-azul">
                <h5 class="modal-title h4 text-white" id="myExtraLargeModalLabel"><i class="icon-lg pb-3px" data-feather="plus"></i> Registrar Institución</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="btn-close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 grid-margin">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Institución</strong> <font class="text-danger">*</font></label>
                                    <input type="text" id="institucion" class="form-control" placeholder="Ingresa el nombre de la institución" />
                                </div>
                            </div>
                            <!-- Col -->
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Siglas</strong> <font class="text-danger">*</font></label>
                                    <input type="text" id="siglas" class="form-control" placeholder="Ingresa el campus" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-12 col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Campus</strong> <font class="text-danger">*</font></label>
                                    <input type="text" id="campus" class="form-control" placeholder="Ingresa las siglas" />
                                </div>
                            </div>
                            <!-- Col -->
                        </div>
                        <!-- Row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label"><strong>Detalles</strong></label>
                                    <input type="text" id="detalles" class="form-control" placeholder="Ingress detalles si existen" />
                                </div>
                            </div>
                        </div>
                        <!-- Row -->
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-negro">
                <button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_guardar_institucion">Guardar</button>
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
                                        <h5><label class="form-label" id="modal_institucion"></label></h5>
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
                <button type="button" class="btn btn-azul-claro btn-sm" id="btn_eliminar_institucion">Eliminar</button>
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
@endpush
@push('custom-scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/data-table.js') }}"></script>
  <script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://code.responsivevoice.org/responsivevoice.js?key=mzutkZDE"></script>
  <script type="text/javascript">
    var table = null;
    var accion = null;
    var btn_activo = true;
    var id = null;
    var institucion = null;
    var siglas = null;
    var campus = null;
    var detalles = null;
    var rowNumber = null; 
    var url_guardar_institucion = "{{url('/instituciones/guardar')}}"; 
    var id_seleccionar = localStorage.getItem("tbl_instituciones_id_seleccionar");
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        table = $("#tbl_instituciones").DataTable({
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

        $("#tbl_instituciones tbody").on("click", ".btn_editar", function () {
            //alert('Hey');
            accion = 2;
        });

        $("#tbl_instituciones").each(function () {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
            search_input.attr("placeholder", "Buscar");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });

        $("#modal_instituciones").on("show.bs.modal", function (e) {
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            institucion = triggerLink.data("nombre");
            siglas = triggerLink.data("siglas");
            campus = triggerLink.data("campus");
            detalles = triggerLink.data("detalles");
            $("#institucion").val(institucion);
            $("#siglas").val(siglas);
            $("#campus").val(campus);
            $("#detalles").val(detalles);
        });

        $("#modal_eliminar").on("show.bs.modal", function (e) {
            accion = 3;
            var triggerLink = $(e.relatedTarget);
            id = triggerLink.data("id");
            institucion = triggerLink.data("nombre");
            siglas = triggerLink.data("siglas");
            campus = triggerLink.data("campus");
            detalles = triggerLink.data("detalles");
            $("#modal_institucion").html(institucion);
        });

        $(".modal-footer").on("click", "#btn_eliminar_institucion", function () { 
            if(btn_activo){
                guardar_institucion(); 
            }
        }); 

        $("#tbl_instituciones tbody").on("click", "tr", function () {
            rowNumber = parseInt(table.row(this).index());
            table.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
            localStorage.setItem("tbl_instituciones_id_seleccionar", table.row(this).data()[0]);
        });


        $("#btn_guardar_institucion").on("click", function () {
            institucion = $("#institucion").val();
            siglas = $("#siglas").val();
            campus = $("#campus").val();
            detalles = $("#detalles").val();

            if(institucion == null || institucion == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Institución.'
                })
                return true;
            }

            if(siglas == null || siglas == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Siglas.'
                })
                return true;
            }

            if(campus == null || campus == ''){
                Toast.fire({
                    icon: 'error',
                    title: 'Valor requerido para Campus.'
                })
                return true;
            }

            if(btn_activo){
                guardar_institucion();
            }
            

        });

    });

    function guardar_institucion() {
        btn_activo = false;
        //console.log(accion);
        $.ajax({
            type: "post",
            url: url_guardar_institucion,
            data: {
                accion: accion,
                id: id,
                institucion: institucion,
                siglas: siglas,
                campus: campus,
                detalles: detalles,
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
                    for(var i = 0; i < data.instituciones.length; i++) { 
                        var row= data.instituciones[i]; 
                        var nuevaFilaDT=[ 
                                     row.id,row.nombre,row.siglas, row.campus,
                                      '<button type="button" class="btn btn-warning btn-icon btn-xs btn_editar" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_instituciones" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-nombre="' + row.nombre + '" ' +
                                        'data-siglas="' + row.siglas + '" ' +
                                        'data-campus="' + row.campus + '" ' +
                                        'data-detalles="' + row.detalles + '"> ' +
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg> ' +
                                    '</button> ' +
                                    '<button type="button" class="btn btn-danger btn-icon btn-xs" ' +
                                        'data-bs-toggle="modal" ' +
                                        'data-bs-target=".modal_eliminar" ' +
                                        'data-id="' + row.id + '" ' +
                                        'data-nombre="' + row.nombre + '" ' +
                                        'data-siglas="' + row.siglas + '" ' +
                                        'data-campus="' + row.campus + '" ' +
                                        'data-detalles="' + row.detalles + '"> ' +
                                        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> ' +
                                    '</button>'
                                     ]; 
                                    if(accion==1) {
                                        $("#modal_instituciones").modal('hide');
                                        table.row.add(nuevaFilaDT).draw();
                                    }else if (accion==2) {
                                        $("#modal_instituciones").modal('hide');
                                        table.row(rowNumber).data(nuevaFilaDT);
                                    } 
                    }
                    if (accion == 3){
                            $("#modal_eliminar").modal("hide");
                            table.row(rowNumber).remove().draw();
                        }  
                        btn_activo = true;
                    
                }
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