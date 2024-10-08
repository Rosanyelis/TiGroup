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
            <!-- <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
                id="dropdownMenuClickable" data-bs-auto-close="false" aria-expanded="false">
                <i class="ri-filter-fill me-1"></i> Filtros
            </button>
            <div class="dropdown-menu  w-px-300 p-6" style="" aria-labelledby="dropdownMenuClickable">
                <div class="row gy-6 ">
                    <div class="col-sm-12">
                        <div class="form-floating form-floating-outline ">
                            <input type="text" class="form-control flatpickr-input" placeholder="YYYY-MM-DD a YYYY-MM-DD"
                                id="flatpickr-range" readonly="readonly">
                            <label for="flatpickr-range">Filtrar por Rango de fecha</label>

                            <input type="hidden" id="startday" name="startday">
                            <input type="hidden" id="endday" name="endday">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <select id="cliente" name="cliente" class="form-select select2"
                            placeholder="Selecione un cliente">
                                <option value="">-- Seleccionar --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->business_name }}</option>
                                @endforeach
                            </select>
                            <label for="code">Filtrar por Cliente</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <select id="status" name="status" class="form-select select2"
                            placeholder="Selecione un estatus">
                                <option value="">-- Seleccionar --</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                            <label for="code">Filtrar por Estatus</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="button" id="clearFilter" class="btn btn-sm btn-danger w-100">
                            <i class="ri-filter-off-fill me-1"></i>
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div> -->

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
