@extends('layouts.app')
@section('title', 'Facturas - Crear')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Nueva Factura</h5>

                        <a href="{{ route('invoice.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>

                    <div class="card-body">
                        <form id="formInvoice" class="needs-validation" action="{{ route('invoice.store') }}" method="POST"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="customer" name="customer" class="form-select select2"
                                        placeholder="Selecione una cliente">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach ($customers as $item)
                                            <option value="{{ $item->business_name }}" {{ old('customer') == $item->business_name ? 'selected' : '' }}>{{ $item->business_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="code">Cliente</label>
                                        @if($errors->has('customer'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('customer') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text"
                                            class="form-control flatpickr-input"
                                            placeholder="DD-MM-YYYY"
                                            name="fecha_factura"
                                            id="flatpickr-date" value="">
                                        <label for="code">fecha factura</label>
                                        @if($errors->has('fecha_factura'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fecha_factura') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="file" name="factura_pdf">
                                        <label for="code">Archivo de Factura</label>
                                        @if($errors->has('factura_pdf'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('factura_pdf') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>


                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="monto_neto"
                                            name="monto_neto"
                                            class="form-control @if($errors->has('monto_neto')) is-invalid @endif"
                                            placeholder="Ingrese monto neto factura"
                                            value="{{ old('monto_neto') }}"
                                        />
                                        <label for="code">Monto Neto de Factura</label>
                                        @if($errors->has('monto_neto'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('monto_neto') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="w-100"></div>

                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="description"
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif"
                                            placeholder="Ingrese Descripción para el detalle de factura"
                                            value="{{ old('description') }}"
                                        />
                                        <label for="code">Descripción de Producto</label>
                                    </div>
                                    <input type="hidden" name="product_name" id="product_name">
                                </div>

                                <div class="mb-6 col-md-2">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="priceCost"
                                            name="priceCost"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        <label for="code">Precio</label>
                                    </div>
                                </div>

                                <div class="mb-6 col-md-2">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="impuesto_adicional"
                                            name="impuesto_adicional"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        <label for="code">Impuesto Adicional</label>
                                    </div>
                                </div>

                                <div class="mb-6 col-md-2">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="descuento"
                                            name="descuento"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        <label for="code">Descuento</label>
                                    </div>
                                </div>

                                <div class="mb-6 col-md-2">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="quantity"
                                            name="quantity"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        <label for="code">Cantidad</label>
                                    </div>
                                </div>

                                <div class="mb-6 col-md-2 ">
                                    <button type="button" id="add_product" class="btn btn-info mt-1">
                                        Agregar
                                    </button>
                                </div>

                                <div class="w-100"></div>

                                <div class="mb-6 col-md-12">
                                    <div class="table-responsive text-nowrap">
                                        <table class="table" id="table_products">
                                            <thead>
                                                <tr>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Impuesto Adicional</th>
                                                    <th>Descuento</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_products"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mb-3 col-md-1">
                                    <input type="hidden" name="subtotal" id="subtotalcomplete">
                                    <input type="hidden" name="total" id="totalcomplete">
                                    <input type="hidden" name="iva" id="ivacomplete">
                                    <input type="hidden" name="array_products" id="array_products">

                                    <button type="submit" class="btn btn-primary float-end"
                                        id="guardar">
                                        <i class="ri-save-2-line me-1"></i>
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
    <script src="{{ asset('pagesjs/invoice.js') }}"></script>
@endsection
