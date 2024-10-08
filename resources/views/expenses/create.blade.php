@extends('layouts.app')
@section('title', 'Gastos - Crear')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Nuevo Gasto</h5>

                        <a href="{{ route('expense.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>
                    <!-- <h5 class="card-header">Crear Categoría</h5> -->

                    <div class="card-body">
                        <form id="formCategory" class="needs-validation" action="{{ route('expense.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="name" name="name" class="form-select select2"
                                            placeholder="Selecione un tipo de gasto">
                                            <option value="">-- Seleccionar --</option>
                                            <option value="Oficina" {{ old('name') == 'Oficina' ? 'selected' : '' }}  >Oficina</option>
                                            <option value="Sueldos" {{ old('name') == 'Sueldos' ? 'selected' : '' }}>Sueldos</option>
                                            <option value="Comisiones" {{ old('name') == 'Comisiones' ? 'selected' : '' }}>Comisiones</option>
                                            <option value="Transporte" {{ old('name') == 'Transporte' ? 'selected' : '' }}>Transporte</option>
                                            <option value="Alquiler" {{ old('name') == 'Alquiler' ? 'selected' : '' }}>Alquiler</option>
                                            <option value="Servicios" {{ old('name') == 'Servicios' ? 'selected' : '' }}>Servicios</option>
                                            <option value="Impuestos" {{ old('name') == 'Impuestos' ? 'selected' : '' }}>Impuestos</option>
                                            <option value="Compras" {{ old('name') == 'Compras' ? 'selected' : '' }}>Compras</option>
                                            <option value="Equipos" {{ old('name') == 'Equipos' ? 'selected' : '' }}>Equipos</option>
                                            <option value="Otros" {{ old('name') == 'Otros' ? 'selected' : '' }}>Otros</option>
                                        </select>
                                        <label for="name">Tipo de Gasto</label>
                                        @if($errors->has('name'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('name') }}
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
                                            placeholder="Ingrese descripcion de gasto"
                                            value="{{ old('note') }}"
                                        />
                                        <label for="code">Notas o descripción del Gasto</label>
                                        @if($errors->has('note'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('note') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input
                                            type="number"
                                            id="amount"
                                            name="amount"
                                            class="form-control @if($errors->has('amount')) is-invalid @endif"
                                            placeholder="Ingrese descripcion de gasto"
                                            value="{{ old('amount') }}"
                                        />
                                        <label for="code">Monto</label>
                                        @if($errors->has('amount'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('amount') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row justify-content-end">
                                <div class="mb-3 col-md-1">
                                    <button type="submit" class="btn btn-primary float-end">
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
