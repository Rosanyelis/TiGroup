@extends('layouts.app')
@section('title', 'Productos - Editar')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Editar Productos</h5>

                        <a href="{{ route('product.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>

                    <div class="card-body">
                        <form id="formCategory" class="needs-validation" action="{{ route('product.update', $product->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="code"
                                            name="code"
                                            class="form-control @if($errors->has('code')) is-invalid @endif"
                                            placeholder="Ingrese el codigo de producto"
                                            value="{{ $product->code}}"
                                        />
                                        <label for="code">Codigo</label>
                                        @if($errors->has('code'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('code') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            class="form-control @if($errors->has('name')) is-invalid @endif"
                                            placeholder="Ingrese nombre de producto"
                                            value="{{ $product->name }}"
                                        />
                                        <label for="code">Producto</label>
                                        @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="category_id" name="category_id" class="form-select"
                                        placeholder="Selecione una categoria">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach($category as $item)
                                            <option value="{{ $item->id }}" {{ $product->category_id == $item->id ? 'selected' : '' }} >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="code">Categoria</label>
                                        @if($errors->has('category_id'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('category_id') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="type" name="type" class="form-select">
                                            <option value="">-- Seleccionar --</option>
                                            @foreach($typeproduct as $item)
                                            <option value="{{ $item->name }}" {{ $product->type == $item->name ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="type">Tipo de Producto</label>
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
                                            type="number"
                                            id="cost"
                                            name="cost"
                                            class="form-control @if($errors->has('cost')) is-invalid @endif"
                                            placeholder="Ingrese precio de costo de producto"
                                            value="{{ $product->cost }}"
                                        />
                                        <label for="code">Precio de Costo</label>
                                        @if($errors->has('cost'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('cost') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="price"
                                            name="price"
                                            class="form-control @if($errors->has('price')) is-invalid @endif"
                                            placeholder="Ingrese precio de venta de producto"
                                            value="{{ $product->price }}"
                                        />
                                        <label for="code">Precio de venta</label>
                                        @if($errors->has('price'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('price') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="quantity"
                                            name="quantity"
                                            class="form-control @if($errors->has('quantity')) is-invalid @endif"
                                            placeholder="Ingrese cantidad de producto"
                                            value="{{ $product->quantity }}"
                                        />
                                        <label for="code">Cantidad</label>
                                        @if($errors->has('quantity'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('quantity') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="text"
                                            id="description"
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif"
                                            placeholder="Ingrese descripcion de producto"
                                            value="{{ $product->description }}"
                                        />
                                        <label for="code">Descripción</label>
                                        @if($errors->has('description'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('description') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="mb-6 col-md-1">
                                    <button type="submit" class="btn btn-primary float-end">
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
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/product.js') }}"></script>
@endsection
