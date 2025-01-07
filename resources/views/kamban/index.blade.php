@extends('layouts.app')
@section('title', 'Gestiones de Tableros Kamban (Trello)')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/typeahead-js/typeahead.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/jkanban/jkanban.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
<!-- Page CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-kanban.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <input type="hidden" name="id" value="{{ $data->id }} " id="workspace_id">
    <div class="app-kanban">
        <!-- Add new board -->
        <div class="row">
            <div class="col-12">
                <div class="card mb-6 ">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">{{ $data->title }}</h5>

                        <div class="d-flex align-items-center">
                            <button type="button"
                                data-bs-toggle="modal"
                                data-bs-target="#BoardModal"
                                class="btn btn-sm btn-primary"
                            > Nuevo Tablero</button>
                            &nbsp;&nbsp;&nbsp;
                        </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <form class="kanban-add-new-board">
                <label class="kanban-add-board-btn" for="kanban-add-board-input">
                    <i class="ri-add-line"></i>
                    <span class="align-middle">Nuevo Tablero</span>
                </label>
                <input
                    type="text"
                    class="form-control w-px-250 kanban-add-board-input mb-4 d-none"
                    placeholder="Añadir Nombre de Tablero"
                    id="kanban-add-board-input"
                    required />
                <div class="mb-4 kanban-add-board-input d-none">
                    <button class="btn btn-primary btn-sm me-3">Agregar Tablero</button>
                    <button type="button" class="btn btn-outline-secondary btn-sm kanban-add-board-cancel-btn">
                        Cancelar
                    </button>
                </div>
            </form>
            </div>
        </div>
        <!-- Kanban Wrapper -->
        <div class="kanban-wrapper"></div>

        <!-- Edit Task/Task & Activities -->
        <div class="offcanvas offcanvas-end kanban-update-item-sidebar">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body pt-2">
                <div class="nav-align-top">
                    <ul class="nav nav-tabs mb-2">
                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-update">
                                <i class="ri-edit-box-line me-2"></i>
                                <span class="align-middle">Editar</span>
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-activity">
                                <i class="ri-pie-chart-line me-2"></i>
                                <span class="align-middle">Actividades</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content px-0 pb-0">
                    <!-- Update item/tasks -->
                    <div class="tab-pane fade show active" id="tab-update" role="tabpanel">
                        <form action="{{ route('kamban.updateitem') }}" method="POST" >
                            @csrf
                            <input type="hidden" id="board_id" name="board_id" value="" />

                            <div class="form-floating form-floating-outline mb-5">
                                <input type="text" id="title"
                                    class="form-control"
                                    name="title"
                                    placeholder="Ingrese Titulo de Tarea" />
                                <label for="title">Titulo</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5">
                                <textarea id="description" name="description"
                                class="form-control h-px-100"
                                placeholder="Ingrese Descripción de Tarea"
                                    rows="3"></textarea>
                                <label for="description">Descripción</label>
                            </div>

                            <div class="form-floating form-floating-outline mb-5">
                                <input type="date" id="start-date"
                                name="start_date"
                                class="form-control"
                                placeholder="Ingrese Fecha de Inicio" />
                                <label for="start-date">Fecha de Inicio</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5">
                                <input type="date" id="due-date"
                                name="due_date"
                                class="form-control"
                                placeholder="Ingrese Fecha Final" />
                                <label for="due-date">Fecha Final</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5">
                                <select class="select2 select2-label form-select" id="label" name="priority">
                                    <option data-color="bg-label-info" value="Sin Definir">Sin Definir</option>
                                    <option data-color="bg-label-danger" value="Alta">Alta</option>
                                    <option data-color="bg-label-warning" value="Media">Media</option>
                                    <option data-color="bg-label-primary" value="Baja">Baja</option>
                                </select>
                                <label for="label"> Prioridad</label>
                            </div>
                            <div class="mb-5">
                                <label class="form-label" for="attachments">Archivos</label>
                                <div>
                                    <input type="file" name="attachments" class="form-control" id="attachments" />
                                </div>
                            </div>
                            <div>
                                <div class="d-flex flex-wrap">
                                    <button type="submit"  class="btn btn-primary me-4">
                                        Actualizar
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="offcanvas">
                                        Eliminar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal crear tarea-->
        <div class="modal fade" id="TaskModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <form action="{{ route('kamban.storeitem') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Crear Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <input type="hidden" id="modal_board_id" name="board_id" value="" />

                            <div class="form-floating form-floating-outline mb-5 col-md-12">
                                <input type="text" id="title"
                                    class="form-control"
                                    name="title"
                                    placeholder="Ingrese nombre y apellido de Cliente"
                                    required />
                                <label for="title">Cliente</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5 col-md-4">
                                <input type="text" id="start-date"
                                name="phone"
                                class="form-control"
                                placeholder="Ingrese Teléfono"
                                required/>
                                <label for="start-date">Teléfono</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5 col-md-4">
                                <input type="email" id="email"
                                name="email"
                                class="form-control"
                                placeholder="Ingrese Correo"
                                required/>
                                <label for="email">Correo</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5 col-md-4">
                                <select class="select2 select2-label form-select required" id="label" name="priority">
                                    <option data-color="bg-label-info" value="Sin Definir">Sin Definir</option>
                                    <option data-color="bg-label-danger" value="Alta">Alta</option>
                                    <option data-color="bg-label-warning" value="Media">Media</option>
                                    <option data-color="bg-label-primary" value="Baja">Baja</option>
                                </select>
                                <label for="label"> Prioridad</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5 col-md-12">
                                <textarea id="project_title" name="project_title"
                                class="form-control h-px-100"
                                placeholder="Ingrese Titulo de Proyecto"
                                rows="3"
                                required></textarea>
                                <label for="project_title">Titulo de Proyecto</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-5 col-md-12">
                                <textarea id="notes" name="notes"
                                class="form-control h-px-100"
                                placeholder="Ingrese Notas"
                                rows="3"
                                ></textarea>
                                <label for="notes">Notas</label>
                            </div>

                            <div class="mb-5 col-md-12">
                                <label class="form-label" for="attachments">Archivos</label>
                                <div>
                                    <input type="file" name="attachments[]" class="form-control" id="attachments" multiple />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!--/ Modal crear tarea-->

        <!-- Modal Ver / Actualizar tarea-->
        <div class="modal fade" id="ViewTaskModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
                <form action="{{ route('kamban.updateitem') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row g-3">
                                    <input type="hidden" id="update_board_id" name="board_id" value="" />

                                    <div class="form-floating form-floating-outline mb-5 col-md-12">
                                        <input type="text" id="title_update"
                                            class="form-control"
                                            name="title"
                                            placeholder="Ingrese nombre y apellido de Cliente"
                                            required />
                                        <label for="title">Cliente</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-5 col-md-4">
                                        <input type="text" id="phone_update"
                                        name="phone"
                                        class="form-control"
                                        placeholder="Ingrese Teléfono"
                                        required/>
                                        <label for="phone_update">Teléfono</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-5 col-md-4">
                                        <input type="email" id="email_update"
                                        name="email"
                                        class="form-control"
                                        placeholder="Ingrese Correo"
                                        required/>
                                        <label for="email_update">Correo</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-5 col-md-4">
                                        <select class="select2 select2-label form-select required" id="label_update" name="priority">
                                            <option data-color="bg-label-info" value="Sin Definir">Sin Definir</option>
                                            <option data-color="bg-label-danger" value="Alta">Alta</option>
                                            <option data-color="bg-label-warning" value="Media">Media</option>
                                            <option data-color="bg-label-primary" value="Baja">Baja</option>
                                        </select>
                                        <label for="label"> Prioridad</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-5 col-md-12">
                                        <textarea id="project_title_update" name="project_title"
                                        class="form-control h-px-100"
                                        placeholder="Ingrese Titulo de Proyecto"
                                        rows="3"
                                        required></textarea>
                                        <label for="project_title_update">Titulo de Proyecto</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-5 col-md-12">
                                        <textarea id="notes_update" name="notes"
                                        class="form-control h-px-100"
                                        placeholder="Ingrese Notas"
                                        rows="3"
                                        ></textarea>
                                        <label for="notes">Notas</label>
                                    </div>
                                    <div class="mb-5 col-md-12">
                                        <label class="form-label" for="attachments">Archivos</label>
                                        <div>
                                            <input type="file" name="attachments[]" class="form-control" id="attachments" multiple />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h5>Archivos Subidos</h5>
                                        <ul id="archivos_subidos" class="list-unstyled mt-2">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>

                </form>
            </div>
        </div>
        <!--/ Modal Ver / Actualizar tarea-->

        <!-- Modal crear tablero-->
        <div class="modal fade " id="BoardModal" tabindex="-1" aria-modal="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('kamban.storeboard', $data->id) }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCenterTitle">Nuevo Tablero</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-mb-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="title"
                                        class="form-control"
                                        name="title"
                                        placeholder="Ingrese Nombre de Tablero" />
                                    <label for="title">Nombre de Tablero</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
            <!--/ Modal crear tablero-->

        <!-- Modal Editar nombre de tablero-->
        <div class="modal fade " id="RenameBoardModal" tabindex="-1" aria-modal="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="{{ route('kamban.renameboard') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title" id="modalCenterTitle">Editar Nombre de Tablero</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="workspace_id" value="{{ $data->id }} ">
                        <input type="hidden" name="titleboardid" id="titleboardid">
                        <div class="row">
                            <div class="col-mb-6 mt-2">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="titleBoard"
                                        class="form-control"
                                        name="title"
                                        placeholder="Ingrese Nombre de Tablero" />
                                    <label for="title">Nombre de Tablero</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary waves-effect" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Actualizar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/ Modal nombre de tablero-->


        <form id="form_delete_board" action="{{ route('kamban.deleteboard') }}" method="POST">
            @csrf
            <input type="hidden" id="boardcolumn" name="board" value="" />
        </form>
    </div>

</div>
@endsection

@section('scripts')
<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/jkanban/jkanban.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/app-kanban.js') }}"></script>
@endsection
