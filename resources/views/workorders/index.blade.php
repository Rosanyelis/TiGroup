@extends('layouts.app')
@section('title', 'Ordenes de Trabajo')
@section('css')
<link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet"
    href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">


    <!-- Ajax Sourced Server-side -->
    <div class="card ">
        <div class="card-header header-elements border-bottom">

            <div class="card-header-elements ms-auto">
                <a href="{{ route('workorder.create') }}" class="btn btn-sm btn-primary">Crear
                    Orden de Trabajo</a>
            </div>
        </div>

        <div class="card-datatable ">

            <table class="datatables-workorder table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>N° OT</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Estatus</th>
                        <th>Creado Por</th>
                        <th>Asignado a</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->

    <!-- Modal ver cotización-->
    <div class="modal fade" id="WorkOrdersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Ver Orden de Trabajo </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>Cliente:</strong> <span id="name"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>N° de Orden:</strong> <span id="nfactura"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Orden:</strong> <span id="date"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total :</strong> <span id="totals"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Estatus :</strong> <span id="estatus"></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Detalles :</strong> <span id="notes"></span>
                        </div>
                        <div class="col-md-12 text-center">
                            <h4>Detalles de Tareas</h4>
                        </div>
                        <div class="col-md-12">
                            <table id="table_tasks_show" class="table table-sm table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr class=" text-uppercase fw-semibold">
                                        <th>Actividades o Tareas</th>
                                    </tr>
                                </thead>
                                <tbody id="detailsTask" >
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 text-center">
                            <h4>Detalles de Servicios</h4>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr class="text-center text-uppercase fw-semibold">
                                        <th>Servicio/Artículo</th>
                                        <th>Detalles</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="details" class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">Total</td>
                                        <td id="total2" class="text-center fw-semibold"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ Modal ver cotización-->
    <form id="my-form" action="{{ route('workorder.destroy') }}" method="POST">
        @csrf
        <input type="hidden" id="id" name="id" >
        <input type="hidden" id="status" name="status">

    </form>

</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}">
</script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/js/forms-selects.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}">
</script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
<script src="{{ asset('pagesjs/workorder.js') }}"></script>
@endsection
