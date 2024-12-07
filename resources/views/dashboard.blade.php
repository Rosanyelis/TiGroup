@extends('layouts.app')
@section('title', 'Dashboard')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row g-6">
        <!-- ventas overwiew -->
        <div class="col-lg-12">
            <div class="card h-100">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mb-1">Resumen de Ventas</h5>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-between flex-wrap gap-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-success rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="salesmonth">0</h5>
                            <p class="mb-0">Ventas del Mes</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="salesyear">0</h5>
                            <p class="mb-0">Ventas del Año</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-warning rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="invoicesmonth">0</h5>
                            <p class="mb-0">Pendientes de Pago</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-secondary rounded">
                                <i class="ri-money-dollar-circle-fill  ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0" id="invoicesqty">0</h5> &nbsp; 
                                <small id="qtyinvoices" class="text-danger">0</small>
                            </div>
                            <p class="mb-0">Facturas Pendientes</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-info rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="quotemonth">0</h5>
                            <p class="mb-0">Cotizados</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="purchasesMonth">0</h5>
                            <p class="mb-0">Compras</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar">
                            <div class="avatar-initial bg-label-danger rounded">
                                <i class="ri-money-dollar-circle-fill ri-24px"></i>
                            </div>
                        </div>
                        <div class="card-info">
                            <h5 class="mb-0" id="expensesMonth">0</h5>
                            <p class="mb-0">Gastos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ventas overwiew -->
        <!-- hostings -->
        <div class="col-lg-4 col-sm-4">
            <div class="swiper-container swiper-container-horizontal swiper swiper-sales" id="swiper-marketing-sales">
                <div class="swiper-wrapper">
                    <div class="swiper-slide card pb-5 shadow-none border-0">
                        <h5 class="mb-1">Cantidad de Contratos</h5>
                        <div class="d-flex align-items-center card-subtitle gap-2">
                            <div>Total <span id="totalContractType"></span> Contratos</div>
                        </div>
                        <div class="d-flex align-items-center mt-5">

                            <div class="d-flex flex-column w-100">
                                <div class="row d-flex flex-wrap justify-content-between g-4">
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3 align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="hosting">0</p>
                                                <p class="mb-0 text-truncate">Hosting</p>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="support">0</p>
                                                <p class="mb-0 text-truncate">Soporte</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3 align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="social">0</p>
                                                <p class="mb-0 text-truncate">Redes Sociales</p>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="web">0</p>
                                                <p class="mb-0 text-truncate">Desarrollo Web</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide card pb-5 shadow-none border-0">
                        <h5 class="mb-1">Cantidad de Hosting</h5>
                        <div class="d-flex align-items-center card-subtitle gap-2">
                            <div>Total <span id="typeHostingTotal"></span> Hosting</div>
                        </div>
                        <div class="d-flex align-items-center mt-5">
                            <div class="d-flex flex-column w-100 ">
                                <div class="row d-flex flex-wrap justify-content-between g-4">
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3 align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="typeHosting">0</p>
                                                <p class="mb-0 text-truncate">Hosting</p>
                                            </li>
                                            <li class="d-flex align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="typeTienda">0</p>
                                                <p class="mb-0 text-truncate">Tiendas Online</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3 align-items-center">
                                                <p class="mb-0 me-3 sales-text-bg fw-medium" id="typeVPS">0</p>
                                                <p class="mb-0 text-truncate">Servidores VPS</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <!-- hostings -->
        <!-- contratos por vencer  -->
        <div class="col-lg-8 col-xxl-8">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Servicios por vencer</h5>
                </div>
                <div class="table-responsive border border-start-0 border-end-0">
                    <table class="table table-sm table-borderless" id="table-services-due">
                        <thead>
                            <tr class="border-bottom">
                                <th class="bg-transparent fs-xsmall">Cliente</th>
                                <th class="bg-transparent fs-xsmall">Fecha Venc.</th>
                                <th class="bg-transparent fs-xsmall">Monto</th>
                                <th class="bg-transparent fs-xsmall">Tipo</th>
                            </tr>
                        </thead>
                        <tbody id="table-services-due-body">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ contratos por vencer -->
    </div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('assets/js/app-ecommerce-dashboard.js') }}"></script>
<script src="{{ asset('pagesjs/home.js') }}"></script>
@endsection
