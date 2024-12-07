@extends('layouts.app')
@section('title', 'Perfil')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="nav-align-top">
                <ul class="nav nav-pills flex-column flex-md-row mb-6 gap-2 gap-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i
                                class="ri-group-line me-2"></i>Mi Perfiil</a>
                    </li>
                </ul>
            </div>
            <div class="card mb-6">
                <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}"
                    enctype="multipart/form-data">
                @csrf
                @method('put')
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-6">
                        @if ($user->photo != null)
                        <img src="{{ asset($user->photo) }}" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded-4" id="uploadedAvatar" />
                        @else
                        <img src="../../assets/img/avatars/1.png" alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded-4" id="uploadedAvatar" />
                        @endif
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-3 mb-4" tabindex="0">
                                <span class="d-none d-sm-block">Cargar foto de perfil</span>
                                <i class="ri-upload-2-line d-block d-sm-none"></i>
                                <input type="file" id="upload" class="account-file-input" hidden
                                    accept="image/png, image/jpeg" name="photo" />
                            </label>
                            <button type="button" class="btn btn-outline-danger account-image-reset mb-4">
                                <i class="ri-refresh-line d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <div>JPG, GIF o PNG permitidos. Tamaño máximo de 2MB</div>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row mt-1 g-5">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control @if($errors->has('firstname')) is-invalid @endif"
                                type="text" id="firstName" name="firstname" value="{{ $user->firstname }}"
                                    autofocus />
                                <label for="firstName">Nombre</label>
                                @if($errors->has('firstname'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('firstname') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control @error('lastname') is-invalid @enderror " type="text" name="lastname"
                                id="lastName" value="{{ $user->lastname }}" />
                                <label for="lastName">Apellido</label>
                                @if($errors->has('lastname'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('lastname') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name"
                                    value="{{ $user->name }}" />
                                <label for="name">Usuario</label>
                                @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <input class="form-control @error('email') is-invalid @enderror "
                                type="text" id="email" name="email"
                                value="{{ $user->email }}" placeholder="john.doe@example.com" />
                                <label for="email">Correo</label>
                                @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-merge">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror "
                                    value="{{ $user->phone }}" />
                                    <label for="phone">Teléfono</label>
                                    @if($errors->has('phone'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('phone') }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-3">Actualizar Cambios</button>
                        <button type="reset" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </div>
                <!-- /Account -->
                </form>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
@endsection
@section('scripts')
<!-- Page JS -->
<script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

