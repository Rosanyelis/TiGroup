        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('dashboard') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <span style="color: var(--bs-primary)">
                            <img src="{{ asset('assets/img/TIGroup.png') }}" width="185" height="70" alt="" >
                        </span>
                    </span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                        d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z"
                        fill-opacity="0.9" />
                        <path
                        d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z"
                        fill-opacity="0.4" />
                    </svg>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                <!-- Dashboards -->
                <li class="menu-item @if (Route::currentRouteName() == 'dashboard') active @endif">
                    <a href="{{ route('dashboard') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-home-smile-line"></i>
                        <div data-i18n="Dashboard">Dashboard</div>
                    </a>
                </li>
                <li class="menu-item @if (Route::currentRouteName() == 'task.index') active @endif">
                    <a href="{{ route('task.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-list-check-3"></i>
                        <div data-i18n="Tareas">Tareas</div>
                    </a>
                </li>
                <!-- <li class="menu-item @if (Route::currentRouteName() == 'kamban.index') active @endif">
                    <a href="{{ route('kamban.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-list-check-3"></i>
                        <div data-i18n="Kanban">Kanban</div>
                    </a>
                </li> -->
                <li class="menu-item
                    @if (Route::currentRouteName() == 'contract.index' ||
                        Route::currentRouteName() == 'contract.create' ||
                        Route::currentRouteName() == 'contract.edit') active @endif">
                    <a href="{{ route('contract.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-file-shield-line"></i>
                        <div data-i18n="Contratos">Contratos</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'quote.index' ||
                        Route::currentRouteName() == 'quote.create' ||
                        Route::currentRouteName() == 'quote.edit') active @endif">
                    <a href="{{ route('quote.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-file-list-3-line"></i>
                        <div data-i18n="Cotizaciones">Cotizaciones</div>
                    </a>
                </li>
                <!-- <li class="menu-item
                    @if (Route::currentRouteName() == 'invoice.index' ||
                        Route::currentRouteName() == 'invoice.create' ||
                        Route::currentRouteName() == 'invoice.edit') active @endif">
                    <a href="{{ route('invoice.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-file-list-line"></i>
                        <div data-i18n="Facturas">Facturas</div>
                    </a>
                </li> -->
                <li class="menu-item
                    @if (Route::currentRouteName() == 'purchase.index' ||
                        Route::currentRouteName() == 'purchase.create' ||
                        Route::currentRouteName() == 'purchase.edit') active @endif">
                    <a href="{{ route('purchase.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-shopping-cart-line"></i>
                        <div data-i18n="Compras">Compras</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'purchaseorder.index' ||
                        Route::currentRouteName() == 'purchaseorder.create' ||
                        Route::currentRouteName() == 'purchaseorder.edit') active @endif">
                    <a href="{{ route('purchaseorder.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-refund-2-line"></i>
                        <div data-i18n="Orden de Compra">Orden de Compra</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'workorder.index' ||
                        Route::currentRouteName() == 'workorder.create' ||
                        Route::currentRouteName() == 'workorder.edit') active @endif">
                    <a href="{{ route('workorder.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-file-list-3-line"></i>
                        <div data-i18n="Orden de Trabajo">Orden de Trabajo</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'expense.index' ||
                        Route::currentRouteName() == 'expense.create' ||
                        Route::currentRouteName() == 'expense.edit') active @endif">
                    <a href="{{ route('expense.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-file-list-3-line"></i>
                        <div data-i18n="Gastos">Gastos</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'product.index' ||
                        Route::currentRouteName() == 'product.create' ||
                        Route::currentRouteName() == 'product.edit' ||
                        Route::currentRouteName() == 'product.show') active @endif">
                    <a href="{{ route('product.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-function-line"></i>
                        <div data-i18n="Productos">Productos</div>
                    </a>
                </li>

                <li class="menu-item
                    @if (Route::currentRouteName() == 'category.index' ||
                        Route::currentRouteName() == 'category.create' ||
                        Route::currentRouteName() == 'category.edit') active @endif">
                    <a href="{{ route('category.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-stack-line"></i>
                        <div data-i18n="Categorias">Categorias</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'customer.index' ||
                        Route::currentRouteName() == 'customer.create' ||
                        Route::currentRouteName() == 'customer.edit') active @endif">
                    <a href="{{ route('customer.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-group-line"></i>
                        <div data-i18n="Clientes">Clientes</div>
                    </a>
                </li>
                <li class="menu-item
                    @if (Route::currentRouteName() == 'supplier.index' ||
                        Route::currentRouteName() == 'supplier.create' ||
                        Route::currentRouteName() == 'supplier.edit') active @endif">
                    <a href="{{ route('supplier.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-shield-user-line"></i>
                        <div data-i18n="Proveedores">Proveedores</div>
                    </a>
                </li>

                <li class="menu-item
                    @if (Route::currentRouteName() == 'user.index' ||
                        Route::currentRouteName() == 'user.create' ||
                        Route::currentRouteName() == 'user.edit') active @endif"">
                    <a href="{{ route('user.index') }}" class="menu-link">
                        <i class="menu-icon tf-icons ri-group-2-line"></i>
                        <div data-i18n="Usuarios">Usuarios</div>
                    </a>
                </li>
            </ul>
        </aside>
