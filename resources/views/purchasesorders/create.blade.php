@extends('layouts.app')
@section('title', 'Orden de Compra - Crear')
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
                        <h5 class="mb-0">Nueva Orden de Compra</h5>

                        <a href="{{ route('purchaseorder.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>

                    <div class="card-body">
                        <form id="formPurchase" class="needs-validation" action="{{ route('purchaseorder.store') }}" method="POST"
                        enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="supplier_id" name="supplier_id" class="form-select select2"
                                        placeholder="Selecione un proveedor">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach ($suppliers as $item)
                                            <option value="{{ $item->id }}" {{ old('supplier_id') == $item->id ? 'selected' : '' }}>{{ $item->business_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="code">Proveedor</label>
                                        @if($errors->has('supplier_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('supplier_id') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="note"
                                            name="note"
                                            class="form-control @if($errors->has('note')) is-invalid @endif"
                                            placeholder="Ingrese notas de Cotización"
                                            value="{{ old('note') }}"
                                        />
                                        <label for="code">Notas</label>
                                        @if($errors->has('note'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('note') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="w-100"></div>

                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="producto" name="producto" class="form-select select2"
                                        placeholder="Selecione un producto">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach ($products as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="code">Producto</label>

                                    </div>
                                    <input type="hidden" name="product_name" id="product_name">
                                    <input type="hidden" name="product_code" id="product_code">
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
                                        <label for="code">Precio de Costo</label>
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
                                <div class="mb-6 col-md-2">
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
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Costo</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_products"></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="3" class="text-end">Total</td>
                                                    <td colspan="2"><span id="total">0</span></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mb-3 col-md-1">
                                    <input type="hidden" name="total" id="totalcomplete">
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
    <script src="{{ asset('pagesjs/purchaseorder.js') }}"></script>
@endsection
