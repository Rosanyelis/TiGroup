@extends('layouts.app')
@section('title', 'Clientes')
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
            <h5 class="mb-0 me-2">Clientes</h5>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('customer.import') }}" class="btn btn-sm btn-secondary"
                >Importar Cliente</a>
                <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary"
                >Crear Cliente</a>
            </div>
        </div>

        <div class="card-datatable text-nowrap">
            <table class="datatables-customer table table-sm">
                <thead>
                    <tr>
                        <th>Razón Social o Nombre</th>
                        <th>RUT</th>
                        <th>Representante</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th style="width: 10px"></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
    <div id="myModalCustomer" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Ver Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <strong>Razon Social:</strong><br>
                            <span id="bussines_name"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>RUT :</strong><br>
                            <span id="rut"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Contacto o Representante:</strong><br>
                            <span id="contacto"></span>
                        </div>
                        <div class="col-md-4">
                            <strong>Giro:</strong><br>
                            <span id="giro"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Telefono:</strong><br>
                            <span id="phone"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Correo:</strong><br>
                            <span id="email"></span>
                        </div>

                        <div class="col-md-4">
                            <strong>Comuna:</strong><br>
                            <span id="comuna"></span>
                        </div>

                        <div class="col-md-6">
                            <strong>Dirección:</strong><br>
                            <span id="address"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal"
                        id="close">Cerrar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/customer.js') }}"></script>
@endsection
