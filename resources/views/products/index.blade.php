@extends('layouts.app')
@section('title', 'Productos')
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
            <h5 class="mb-0">Productos</h5>

            <div class="card-header-elements ms-auto">
                <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary"
                >Crear Producto</a>
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <div class="row my-3 ">
                <div class="col-md-3">
                    <div class="form-floating form-floating-outline">
                        <select id="category_id" name="category_id" class="form-select"
                        placeholder="Selecione una categoria">
                            <option value="">-- Seleccionar --</option>
                            @foreach($category as $item)
                            <option value="{{ $item->id }}" >{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <label for="code">Filtrar por Categoria</label>
                    </div>
                </div>
            </div>
            <table class="datatables-product table table-sm">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Tipo</th>
                        <th>Costo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->

</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/product.js') }}"></script>
@endsection
