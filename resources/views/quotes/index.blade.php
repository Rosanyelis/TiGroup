@extends('layouts.app')
@section('title', 'Cotizaciones')
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
                                <p class="mb-0">Total Cotizado</p>
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
                        <div
                            class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
                            <div>
                                <h4 class="mb-0" id="totalProfit">0</h4>
                                <p class="mb-0">Total Profit</p>
                            </div>
                            <div class="avatar me-sm-6">
                                <span class="avatar-initial rounded-3 bg-label-secondary">
                                    <i class="ri-wallet-line text-heading ri-26px"></i>
                                </span>
                            </div>
                        </div>
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
                            <select id="vendedor" name="vendedor" class="form-select form-select-sm select2"
                            placeholder="Selecione un vendedor">
                                <option value="">-- Seleccionar --</option>
                                @foreach($users as $item)
                                <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="code">Filtrar por Vendedor</label>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-floating form-floating-outline">
                            <select id="cliente" name="cliente" class="form-select select2"
                            placeholder="Selecione un cliente">
                                <option value="">-- Seleccionar --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
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
                                <option value="Cotizado">Cotizado</option>
                                <option value="Facturado">Facturado</option>
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
                <a href="{{ route('quote.create') }}" class="btn btn-sm btn-primary">Crear
                    Cotizacion</a>
            </div>
        </div>

        <div class="card-datatable ">

            <table class="datatables-quote table table-sm">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>N° Coti</th>
                        <th>Cliente</th>
                        <th>Vendedor</th>
                        <th>Valor Neto</th>
                        <th>F. Cierre</th>
                        <th>Profit Neto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->

    <!-- Modal ver cotización-->
    <div class="modal fade" id="QuotesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Ver Cotizacion Nº <span id="correlativo"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Cliente:</strong><br>
                            <span id="name"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Total :</strong><br>
                            <span id="totalfinal"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha de Cotización:</strong><br>
                            <span id="date"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Archivo de Propuesta detallada:</strong><br>
                            <span id="file"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Fecha de Cierre:</strong><br>
                            <span id="closing_date"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>% de Cierre:</strong><br>
                            <span id="closing_percentage"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Nº de factura:</strong><br>
                            <span id="number_invoice"></span>
                        </div>

                        <div class="col-md-12">
                            <strong>Notas:</strong><br>
                            <span id="note"></span>
                        </div>

                        <div class="col-md-12 text-center">
                            <h4>Detalles de Cotización</h4>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr class="text-center text-uppercase fw-semibold">
                                        <th>Código</th>
                                        <th>Articulo</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Profit</th>
                                        <th>Margen</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="details" class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="text-end fw-semibold">Subtotal</td>
                                        <td id="subtotal" class="text-center fw-semibold"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end fw-semibold">IVA (% 19)</td>
                                        <td id="iva" class="text-center fw-semibold"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-end fw-semibold">Total</td>
                                        <td id="total" class="text-center fw-semibold"></td>
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

    <div id="myModalFactura" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <form id="myFormFactura" action="{{ route('quote.addReferencias') }}" method="post">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Agregar Número de Factura </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <input type="number" id="invoice_number" name="invoice_number" class="form-control"
                                        placeholder="Ingrese N° de Factura" />
                                    <label for="code">N° de Factura</label>
                                    <input type="hidden" id="id" name="id" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal"
                            id="close">Cerrar</button>

                        <button type="submit" class="btn btn-primary waves-effect">Guardar</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
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
<script src="{{ asset('pagesjs/quote.js') }}"></script>
@endsection
