@extends('layouts.app')
@section('title', 'Compras')
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
    <!-- Contador -->
    <div class="card">
        <div class="card-widget-separator-wrapper">
            <div class="card-body card-widget-separator">
                <div class="row gy-4 gy-sm-1">
                    <div class="col-sm-6 col-lg-3">
                        <div
                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
                            <div>
                                <h4 class="mb-0" id="totalCotizado">0</h4>
                                <p class="mb-0">Total Compras</p>
                            </div>
                            <div class="avatar me-lg-6">
                                <span class="avatar-initial rounded-3 bg-label-secondary">
                                    <i class="ri-pages-line text-heading ri-26px"></i>
                                </span>
                            </div>
                        </div>
                        <hr class="d-none d-sm-block d-lg-none">
                    </div>
                    <div class="col-sm-6 col-lg-3">

                    </div>
                    <!-- <div class="col-sm-6 col-lg-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h4 class="mb-0">$876</h4>
                                <p class="mb-0">Unpaid</p>
                            </div>
                            <div class="avatar">
                                <span class="avatar-initial rounded-3 bg-label-secondary">
                                    <i class="ri-money-dollar-circle-line text-heading ri-26px"></i>
                                </span>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Contador -->

    <!-- Ajax Sourced Server-side -->
    <div class="card mt-4">
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
                        <div class="form-floating form-floating-outline">
                            <select id="status" name="status" class="form-select select2"
                            placeholder="Selecione un estatus">
                                <option value="">-- Seleccionar --</option>
                                <option value="1">Recibido</option>
                                <option value="0">No Recibido</option>
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
            </div>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('purchase.create') }}" class="btn btn-sm btn-primary">Crear
                    Compra</a>
            </div>
        </div>

        <div class="card-datatable ">

            <table class="datatables-purchase table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Proveedor</th>
                        <th>N° factura</th>
                        <th>Total</th>
                        <th>Nota</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->

    <!-- Modal ver cotización-->
    <div class="modal fade" id="PurchaseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Ver Compra </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <strong>Proveedor:</strong> <br>
                            <span id="name"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Fecha de Compra:</strong><br>
                            <span id="date"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>Total :</strong><br>
                            <span id="total"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>N° de factura:</strong><br>
                            <span id="nfactura"></span>
                        </div>
                        <div class="col-md-6">
                            <strong>¿Recibido? :</strong><br>
                            <span id="recibido"></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Notas:</strong><br>
                            <span id="note"></span>
                        </div>
                        <div class="col-md-12">
                            <strong>Archivos:</strong><br>
                            <span id="files"></span>
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

    <!-- Modal cambiar estado-->
    <form id="my-form" action="{{ route('quote.cambiarStatus') }}" method="POST">
        @csrf
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="status" name="status">
    </form>
    <!--/ Modal cambiar estado-->

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
<script src="{{ asset('pagesjs/purchase.js') }}"></script>
@endsection
