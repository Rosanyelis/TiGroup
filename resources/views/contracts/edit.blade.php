@extends('layouts.app')
@section('title', 'Contratos - Editar')
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
                        <h5 class="mb-0">Editar Contrato</h5>

                        <a href="{{ route('contract.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>

                    <div class="card-body">
                        <form id="formContract" class="needs-validation" action="{{ route('contract.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="customer" name="customer" class="form-select select2"
                                        placeholder="Selecione una cliente">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach ($customers as $item)
                                            <option value="{{ $item->business_name }}" {{ $data->customer_id == $item->id ? 'selected' : '' }}>{{ $item->business_name }}</option>
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
                                        <select id="type_contract" name="type_contract" class="form-select select2"
                                        placeholder="Selecione un Tipo de Contrato">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="Contrato de Hosting" {{ $data->type_contract == 'Contrato de Hosting' ? 'selected' : '' }}>Contrato de Hosting</option>
                                            <option value="Contrato de Soporte" {{ $data->type_contract == 'Contrato de Soporte' ? 'selected' : '' }}>Contrato de Soporte</option>
                                            <option value="Contrato de Desarrollo Web" {{ $data->type_contract == 'Contrato de Desarrollo Web' ? 'selected' : '' }}>Contrato de Desarrollo Web</option>
                                            <option value="Contrato de Redes Sociales" {{ $data->type_contract == 'Contrato de Redes Sociales' ? 'selected' : '' }}>Contrato de Redes Sociales</option>
                                        </select>
                                        <label for="type_contract">Tipo de Contrato</label>
                                        @if($errors->has('type_contract'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('type_contract') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input class="form-control" type="file" name="file">
                                        <label for="code">Archivo de Referencia</label>
                                        @if($errors->has('file'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('file') }}
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
                                            placeholder="Ingrese notas de Contrato"
                                            value="{{ $data->note }}"
                                        />
                                        <label for="code">Notas</label>
                                        @if($errors->has('note'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('note') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="type" name="type" class="form-select select2"
                                        placeholder="Selecione un Plazo">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="annual" {{ $data->type == 'annual' ? 'selected' : '' }}>Anual</option>
                                            <option value="two years" {{ $data->type == 'two years' ? 'selected' : '' }}>Bianual</option>
                                        </select>
                                        <label for="type">Tipo de Plazo de Contrato</label>
                                        @if($errors->has('type'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('type') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="dominio"
                                            name="dominio"
                                            class="form-control @if($errors->has('dominio')) is-invalid @endif"
                                            placeholder="Ingrese dominio a asignar al hosting"
                                            value="{{ $data->dominio }}"
                                        />
                                        <label for="code">Dominio de Hosting (Opcional)</label>
                                        @if($errors->has('dominio'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('dominio') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="w-100"></div>

                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="producto" name="producto" class="form-select select2"
                                        placeholder="Selecione una cliente">
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
                                            type="text"
                                            id="details"
                                            name="details"
                                            class="form-control"
                                            placeholder=""
                                        />
                                        <label for="details">Detalles</label>
                                    </div>
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
                                                    <th>Producto</th>
                                                    <th>Detalles</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Total</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_products"></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end">SubTotal</td>
                                                    <td colspan="2" ><span id="subtotal">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">IVA (19%)</td>
                                                    <td colspan="2" ><span id="iva">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" class="text-end">Total</td>
                                                    <td colspan="2" ><span id="total">0</span></td>
                                                </tr>
                                            </tfoot>
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
                                        Actualizar
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
    <script src="{{ asset('pagesjs/contract.js') }}"></script>

    <script>
        // obtener la data de la tabla actual
        var oldData = @json($data->items);

        $.each(oldData, function(index, value) {
            datosTabla.push({
                'code': value.product.code,
                'product': value.product.name,
                'details': value.details,
                'quantity': value.quantity,
                'price': value.price,
                'subtotal': value.total
            });
            $("#table_products tbody").append(
                `<tr id="row-`+value.product.code+`">
                    <td>`+value.product.name+`</td>
                    <td>`+value.details+`</td>
                    <td id="quantity-`+value.product.code+`">`+value.quantity+`</td>
                    <td id="price-`+value.product.code+`">`+value.price+`</td>
                    <td id="subtotal-`+value.product.code+`">`+value.total+`</td>
                    <td>
                         <button type="button" class="btn btn-danger btn-sm"
                            id="delete_product" data-code="`+value.product.code+`">
                            <i class="ri-delete-bin-fill"></i>
                        </button>
                    </td>
                </tr>`);

            calcular();

        });
    </script>

@endsection
