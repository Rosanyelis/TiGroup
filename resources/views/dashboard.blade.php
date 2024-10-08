@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <!-- Ventas del mes -->
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="avatar me-4">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 me-2">2,856</h5>
                                <i class="ri-arrow-up-s-line text-success ri-20px"></i>
                                <small class="text-success">54.6%</small>
                            </div>
                            <p class="mb-0">Ventas del Mes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ventas del mes -->

        <!-- Pendientes de pago  -->
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="avatar me-4">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 me-2">2,856</h5>
                                <i class="ri-arrow-up-s-line text-success ri-20px"></i>
                                <small class="text-success">54.6%</small>
                            </div>
                            <p class="mb-0">Pendientes de Pago</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pendientes de pago -->
        <!-- Cotizados -->
        <div class="col-lg-4 col-sm-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="avatar me-4">
                            <div class="avatar-initial bg-label-success rounded-3">
                                <i class="ri-money-dollar-circle-line ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 me-2">2,856</h5>
                                <i class="ri-arrow-up-s-line text-success ri-20px"></i>
                                <small class="text-success">54.6%</small>
                            </div>
                            <p class="mb-0">Cotizados</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cotizados -->
        <!-- hostings -->
        <div class="col-md-4 col-xxl-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Cantidad de Hosting</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="popularInstructors" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="popularInstructors">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4 border border-start-0 border-end-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fs-xsmall text-uppercase fw-normal">Tipos de Hosting</h6>
                        <h6 class="mb-0 fs-xsmall text-uppercase fw-normal">Cant.</h6>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Hosting</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Tiendas Nube</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Servidores VPS</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Total</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">1000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hostings -->
        <!-- contratos por vencer  -->
        <div class="col-lg-8 col-xxl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Servicios por vencer</h5>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="teamMemberList" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="teamMemberList">
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                            <a class="dropdown-item" href="javascript:void(0);">Update</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive border border-start-0 border-end-0">
                    <table class="table table-sm table-borderless">
                        <thead>
                            <tr class="border-bottom">
                                <th class="bg-transparent fs-xsmall">Cliente</th>
                                <th class="bg-transparent fs-xsmall">Fecha Venc.</th>
                                <th class="bg-transparent fs-xsmall">Monto</th>
                                <th class="bg-transparent fs-xsmall">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-truncate">Dean Hogan</td>
                                <td>15/08/2022</td>
                                <td>$ 90.000</td>
                                <td>Hosting</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ contratos por vencer -->

        <!-- Cantidad de Contratos -->
        <div class="col-md-4 col-xxl-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2">Cantidad de Contratos</h5>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1" type="button"
                            id="popularInstructors" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i class="ri-more-2-line ri-20px"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="popularInstructors">
                            <a class="dropdown-item" href="javascript:void(0);">Select All</a>
                            <a class="dropdown-item" href="javascript:void(0);">Refresh</a>
                            <a class="dropdown-item" href="javascript:void(0);">Share</a>
                        </div>
                    </div>
                </div>
                <div class="px-5 py-4 border border-start-0 border-end-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fs-xsmall text-uppercase fw-normal">Tipo</h6>
                        <h6 class="mb-0 fs-xsmall text-uppercase fw-normal">Cant.</h6>
                    </div>
                </div>
                <div class="card-body pt-5">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Hosting</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Redes Sociales</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Soporte</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Desarrollo web</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">33</h6>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0 text-truncate">Total</h6>
                            </div>
                        </div>
                        <div class="text-end">
                            <h6 class="mb-0">1000</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Cantidad de Contratos -->
    </div>
</div>
@endsection
