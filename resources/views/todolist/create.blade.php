@extends('layouts.app')
@section('title', 'Todo List - Crear')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Nueva Tarea</h5>

                        <a href="{{ route('task.index') }}" class="btn btn-sm btn-secondary"
                        ><i class="ri-arrow-left-line me-1"></i> Regresar</a>
                    </div>


                    <div class="card-body">
                        <form id="formTask" class="needs-validation" action="{{ route('task.store') }}" method="POST">
                            @csrf
                            <div class="row g-5">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline">
                                        <textarea
                                            type="text"
                                            class="form-control form-control-sm"
                                            id="task"
                                            name="task"
                                            placeholder="Ingrese la tarea"
                                            autofocus> {{ old('task') }}</textarea>
                                        <label for="task">Tarea</label>

                                        @if($errors->has('task'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('task') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <select id="usersMultiple" name="members[]" class="select2 form-select" multiple>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="usersMultiple">Usuarios</label>
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control flatpickr-input active"
                                        placeholder="DD-MM-YYYY" name="fecha_inicio" id="flatpickr-date"
                                        value="{{ old('fecha_inicio') }}">
                                        <label for="fecha_inicio">Fecha Inicio</label>

                                        @if($errors->has('fecha_inicio'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fecha_inicio') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-6 col-md-4">
                                    <div class="form-floating form-floating-outline">
                                        <input type="text" class="form-control flatpickr-input active"
                                        placeholder="DD-MM-YYYY" name="fecha_fin" id="flatpickr-date2"
                                        value="{{ old('fecha_fin') }}">
                                        <label for="fecha_fin">Fecha Final</label>


                                    </div>
                                    @if($errors->has('fecha_fin'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('fecha_fin') }}
                                        </div>
                                        @endif
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
@section('scripts')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>
    <!-- Page JS -->
    <script src="{{ asset('pagesjs/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/forms-selects.js') }}"></script>
@endsection
