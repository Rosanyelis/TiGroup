@extends('layouts.app')
@section('title', 'Ordenes de Compras')
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
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown"
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
                            <select id="proveedor" name="proveedor" class="form-select form-select-sm select2"
                            placeholder="Selecione un proveedor">
                                <option value="">-- Seleccionar --</option>
                                @foreach($suppliers as $item)
                                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="code">Filtrar por Proveedor</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="button" id="clearFilter" class="btn btn-sm btn-danger w-100">
                            <i class="ri-filter-off-fill me-1"></i>
                            Limpiar Filtros
                        </button>
                    </div>
                </div>
            </div>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('purchaseorder.create') }}" class="btn btn-sm btn-primary">Crear
                    Orden de Compra</a>
            </div>
        </div>

        <div class="card-datatable ">

            <table class="datatables-purchase-orders table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>N° OC</th>
                        <th>Proveedor</th>
                        <th>Total</th>
                        <th>Nota</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->

    <!-- Modal ver cotización-->
    <div class="modal fade" id="PurchaseOrdersModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Ver Orden de Compra </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <strong>Proveedor:</strong> <br>
                            <span id="name"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Orden de Compra:</strong><br>
                            <span id="date"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total :</strong><br>
                            <span id="total"></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Notas:</strong><br>
                            <span id="note"></span>
                        </div>
                        <div class="col-md-12 text-center">
                            <h4>Detalles de Compra</h4>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr class="text-center text-uppercase fw-semibold">
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="details" class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end fw-semibold">Total</td>
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
<script src="{{ asset('pagesjs/purchaseorder.js') }}"></script>
@endsection
