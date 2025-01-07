@extends('layouts.app')
@section('title', 'Facturas')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-header header-elements border-bottom">
            <h5 class="mb-0 me-2">Facturas</h5>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('invoice.create') }}" class="btn btn-sm btn-primary"
                >Crear Factura</a>
            </div>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="datatables-invoice table table-sm" style="font-size: 14px">
                <thead>
                    <tr>
                        <th>Nº Fac.</th>
                        <th width="100px">Cliente</th>
                        <th>Motivo</th>
                        <th>Fecha Venc.</th>
                        <th>Total</th>
                        <th>Forma de Pago</th>
                        <th>Estado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
    <div class="modal fade" id="AddNumberInvoiceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Cambiar Forma de Pago </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('invoice.changeFormPayment') }}" method="POST" enctype="multipart/form-data" id="my-form-invoice-payment">
                    @csrf
                    <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class=" col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="payment_form" name="payment_form" class="form-select select2"
                                placeholder="Selecione la Forma de Pago">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="WebPay">WebPay</option>
                                </select>
                                <label for="code">Forma de Pago</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal agregar numero de factura y cargar archivo -->
    <div class="modal fade" id="InvoicesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Agregar Número de Factura Electronica <span id="correlativo"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('invoice.updateInvoiceFile') }}" method="POST" enctype="multipart/form-data" id="my-form-invoice">
                    @csrf
                    <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class=" col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input
                                    type="text"
                                    id="n_factura"
                                    name="n_factura"
                                    class="form-control @if($errors->has('n_factura')) is-invalid @endif"
                                    placeholder="Ingrese Nº de factura Electronica"
                                    value="{{ old('n_factura') }}"
                                />
                                <label for="code">Nº de factura Electronica</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ Modal agregar numero de factura y cargar archivo -->
    <!-- Modal Actualizar forma de pago-->
    <div class="modal fade" id="InvoicesPaymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Cambiar Forma de Pago </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('invoice.changeFormPayment') }}" method="POST" enctype="multipart/form-data" id="my-form-invoice-payment">
                    @csrf
                    <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class=" col-md-12">
                            <div class="form-floating form-floating-outline">
                                <select id="payment_form" name="payment_form" class="form-select select2"
                                placeholder="Selecione la Forma de Pago">
                                    <option value="">-- Seleccionar --</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="Transferencia">Transferencia</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="WebPay">WebPay</option>
                                </select>
                                <label for="code">Forma de Pago</label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Cancelar</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Guardar</span>
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--/ Modal Actualizar forma de pago-->
    <!-- Modal cambiar estado-->
    <form id="my-form" action="{{ route('invoice.changeStatus') }}" method="POST">
        @csrf
        <input type="hidden" id="id" name="id">
        <input type="hidden" id="status" name="status">
    </form>
    <!--/ Modal cambiar estado-->
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/invoice.js?v=1') }}"></script>
@endsection
