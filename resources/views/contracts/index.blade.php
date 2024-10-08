@extends('layouts.app')
@section('title', 'Contratos')
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
            <h5 class="mb-0 me-2">Contratos</h5>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('contract.create') }}" class="btn btn-sm btn-primary"
                >Crear Contrato</a>
            </div>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="datatables-contract table table-sm">
                <thead>
                    <tr>
                        <th>Nº Contrato</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Fecha Venc.</th>
                        <th>Plazo</th>
                        <th>Valor</th>
                        <th>Estado</th>
                        <th style="width: 10px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
    <!-- Modal ver cotización-->
    <div class="modal fade" id="ContractsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Ver Contrato Nº <span id="correlativo"></span> </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Razón Social o Cliente :</strong><br>
                            <span id="bussines_name"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha de Inicio:</strong><br>
                            <span id="start_date"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Fecha de Vencimiento:</strong><br>
                            <span id="end_date"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Tipo de Contrato:</strong><br>
                            <span id="type_contract"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Plazo de Contrato:</strong><br>
                            <span id="type"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Dominio:</strong><br>
                            <span id="dominio"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Estatus:</strong><br>
                            <span id="estatus"></span>
                        </div>

                        <div class="col-md-12">
                            <strong>Notas:</strong><br>
                            <span id="note"></span>
                        </div>

                        <div class="col-md-12 text-center">
                            <h4>Detalles de Contrato</h4>
                        </div>

                        <div class="col-md-12">
                            <table class="table table-sm table-striped table-bordered nowrap w-100">
                                <thead>
                                    <tr class="text-center text-uppercase fw-semibold">
                                        <th>Producto</th>
                                        <th>Detalles</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody id="details" class="text-center">
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">Subtotal</td>
                                        <td id="subtotal" class="text-center fw-semibold"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">IVA (% 19)</td>
                                        <td id="iva" class="text-center fw-semibold"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end fw-semibold">Total</td>
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
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/contract.js') }}"></script>
@endsection
