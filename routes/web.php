<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KambanController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TodoListController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\PurchaseOrderController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    # Task
    Route::get('/tareas', [TodoListController::class, 'index'])->name('task.index');
    Route::get('/tareas/create', [TodoListController::class, 'create'])->name('task.create');
    Route::post('/tareas/store', [TodoListController::class, 'store'])->name('task.store');
    Route::post('/tareas/cambiar-estado', [TodoListController::class, 'changeStatus'])->name('task.changeStatus');
    Route::post('/tareas/destroy', [TodoListController::class, 'destroy'])->name('task.destroy');

    # Categories
    Route::get('/categorias', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categorias/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categorias/guardar', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categorias/{category}/editar', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categorias/{category}/actualizar', [CategoryController::class, 'update'])->name('category.update');
    Route::get('/categorias/{category}/eliminar', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/categorias/importar-categorias', [CategoryController::class, 'view_import'])->name('category.viewimport');
    Route::post('/categorias/import-data', [CategoryController::class, 'import'])->name('category.import');

    # products
    Route::get('/productos', [ProductController::class, 'index'])->name('product.index');
    Route::get('/productos/datatable', [ProductController::class, 'datatable'])->name('product.datatable');
    Route::get('/productos/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/productos', [ProductController::class, 'store'])->name('product.store');
    Route::get('/productos/{product}/show', [ProductController::class, 'show'])->name('product.show');
    Route::get('/productos/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('/productos/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::get('/productos/{product}/delete', [ProductController::class, 'destroy'])->name('product.destroy');

    # Customers
    Route::get('/clientes', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/clientes/create', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/clientes', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/clientes/{cliente}/show', [CustomerController::class, 'show'])->name('customer.show');
    Route::get('/clientes/{cliente}/edit', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::put('/clientes/{cliente}/update', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('/clientes/{cliente}/delete', [CustomerController::class, 'destroy'])->name('customer.destroy');
    Route::get('/clientes/importar', [CustomerController::class, 'import'])->name('customer.import');
    Route::post('/clientes/importar', [CustomerController::class, 'importData'])->name('customer.importData');


    # Suppliers
    Route::get('/proveedores', [SupplierController::class, 'index'])->name('supplier.index');
    Route::get('/proveedores/create', [SupplierController::class, 'create'])->name('supplier.create');
    Route::post('/proveedores', [SupplierController::class, 'store'])->name('supplier.store');
    Route::get('/proveedor/{proveedor}/show', [SupplierController::class, 'show'])->name('supplier.show');
    Route::get('/proveedores/{proveedor}/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::put('/proveedores/{proveedor}/update', [SupplierController::class, 'update'])->name('supplier.update');
    Route::get('/proveedores/{proveedor}/delete', [SupplierController::class, 'destroy'])->name('supplier.destroy');

    # Expenses
    Route::get('/gastos', [ExpenseController::class, 'index'])->name('expense.index');
    Route::get('/gastos/create', [ExpenseController::class, 'create'])->name('expense.create');
    Route::post('/gastos', [ExpenseController::class, 'store'])->name('expense.store');
    Route::get('/gastos/{gasto}/show', [ExpenseController::class, 'show'])->name('expense.show');
    Route::get('/gastos/{gasto}/edit', [ExpenseController::class, 'edit'])->name('expense.edit');
    Route::put('/gastos/{gasto}/update', [ExpenseController::class, 'update'])->name('expense.update');
    Route::get('/gastos/{gasto}/delete', [ExpenseController::class, 'destroy'])->name('expense.destroy');

    # Quotation
    Route::get('/cotizaciones', [QuotationController::class, 'index'])->name('quote.index');
    Route::get('/cotizaciones/datatable', [QuotationController::class, 'datatable'])->name('quote.datatable');
    Route::get('/cotizaciones/create', [QuotationController::class, 'create'])->name('quote.create');
    Route::post('/cotizaciones', [QuotationController::class, 'store'])->name('quote.store');
    Route::get('/cotizaciones/{quotation}/show', [QuotationController::class, 'show'])->name('quote.show');
    Route::get('/cotizaciones/{quotation}/edit', [QuotationController::class, 'edit'])->name('quote.edit');
    Route::post('/cotizaciones/{quotation}/update', [QuotationController::class, 'update'])->name('quote.update');
    Route::get('/cotizaciones/{quotation}/delete', [QuotationController::class, 'destroy'])->name('quote.destroy');
    Route::get('/cotizaciones/{quotation}/productjson', [QuotationController::class, 'productjson'])->name('quote.productjson');
    Route::get('/cotizaciones/{quotation}/quotepdf', [QuotationController::class, 'quotepdf'])->name('quote.quotepdf');
    Route::get('/cotizaciones/{quotation}/enviar-cotizacion', [QuotationController::class, 'sendEmailQuotepdf'])->name('quote.sendEmailQuotepdf');
    Route::post('/cotizaciones/cambiar-status', [QuotationController::class, 'cambiarStatus'])->name('quote.cambiarStatus');
    Route::post('/cotizaciones/agregar-numero-de-factura', [QuotationController::class, 'addReferencias'])->name('quote.addReferencias');

    # Contract
    Route::get('/contratos', [ContractController::class, 'index'])->name('contract.index');
    Route::get('/contratos/create', [ContractController::class, 'create'])->name('contract.create');
    Route::post('/contratos', [ContractController::class, 'store'])->name('contract.store');
    Route::get('/contratos/{contract}/show', [ContractController::class, 'show'])->name('contract.show');
    Route::get('/contratos/{contract}/edit', [ContractController::class, 'edit'])->name('contract.edit');
    Route::put('/contratos/{contract}/update', [ContractController::class, 'update'])->name('contract.update');
    Route::get('/contratos/{contract}/delete', [ContractController::class, 'destroy'])->name('contract.destroy');

    # Invoices
    Route::get('/facturas', [InvoiceController::class, 'index'])->name('invoice.index');
    Route::get('/facturas/create', [InvoiceController::class, 'create'])->name('invoice.create');
    Route::post('/facturas', [InvoiceController::class, 'store'])->name('invoice.store');
    Route::get('/facturas/{invoice}/show', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/facturas/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoice.edit');
    Route::put('/facturas/{invoice}/update', [InvoiceController::class, 'update'])->name('invoice.update');
    Route::get('/facturas/{invoice}/delete', [InvoiceController::class, 'destroy'])->name('invoice.destroy');

    # Compras
    Route::get('/compras', [PurchaseController::class, 'index'])->name('purchase.index');
    Route::get('/compras/datatable', [PurchaseController::class, 'datatable'])->name('purchase.datatable');
    Route::get('/compras/{product}/productjson', [PurchaseController::class, 'productjson'])->name('purchase.productjson');
    Route::get('/compras/create', [PurchaseController::class, 'create'])->name('purchase.create');
    Route::post('/compras', [PurchaseController::class, 'store'])->name('purchase.store');
    Route::get('/compras/{purchase}/show', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::get('/compras/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::put('/compras/{purchase}/update', [PurchaseController::class, 'update'])->name('purchase.update');
    Route::get('/compras/{purchase}/delete', [PurchaseController::class, 'destroy'])->name('purchase.destroy');

    # Purchase Order
    Route::get('/ordenes-de-compra', [PurchaseOrderController::class, 'index'])->name('purchaseorder.index');
    Route::get('/ordenes-de-compra/datatable', [PurchaseOrderController::class, 'datatable'])->name('purchaseorder.datatable');
    Route::get('/ordenes-de-compra/create', [PurchaseOrderController::class, 'create'])->name('purchaseorder.create');
    Route::post('/ordenes-de-compra', [PurchaseOrderController::class, 'store'])->name('purchaseorder.store');
    Route::get('/ordenes-de-compra/{purchaseorder}/show', [PurchaseOrderController::class, 'show'])->name('purchaseorder.show');
    Route::get('/ordenes-de-compra/{purchaseorder}/edit', [PurchaseOrderController::class, 'edit'])->name('purchaseorder.edit');
    Route::put('/ordenes-de-compra/{purchaseorder}/update', [PurchaseOrderController::class, 'update'])->name('purchaseorder.update');
    Route::get('/ordenes-de-compra/{purchaseorder}/delete', [PurchaseOrderController::class, 'destroy'])->name('purchaseorder.destroy');

    # work order
    Route::get('/ordenes-de-trabajo', [WorkOrderController::class, 'index'])->name('workorder.index');
    Route::get('/ordenes-de-trabajo/create', [WorkOrderController::class, 'create'])->name('workorder.create');
    Route::post('/ordenes-de-trabajo', [WorkOrderController::class, 'store'])->name('workorder.store');
    Route::get('/ordenes-de-trabajo/{workorder}/show', [WorkOrderController::class, 'show'])->name('workorder.show');
    Route::get('/ordenes-de-trabajo/{workorder}/edit', [WorkOrderController::class, 'edit'])->name('workorder.edit');
    Route::put('/ordenes-de-trabajo/{workorder}/update', [WorkOrderController::class, 'update'])->name('workorder.update');
    Route::post('/ordenes-de-trabajo/delete', [WorkOrderController::class, 'destroy'])->name('workorder.destroy');

    # users
    Route::get('/usuarios', [UserController::class, 'index'])->name('user.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('user.store');
    Route::get('/usuarios/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/usuarios/{user}/update', [UserController::class, 'update'])->name('user.update');
    Route::get('/usuarios/{user}/delete', [UserController::class, 'destroy'])->name('user.destroy');

    # Kamban
    Route::get('/kamban', [KambanController::class, 'index'])->name('kamban.index');
    Route::get('/kamban/create', [KambanController::class, 'create'])->name('kamban.create');
    Route::post('/kamban', [KambanController::class, 'store'])->name('kamban.store');
    Route::get('/kamban/{kamban}/show', [KambanController::class, 'show'])->name('kamban.show');
    Route::get('/kamban/{kamban}/edit', [KambanController::class, 'edit'])->name('kamban.edit');
    Route::put('/kamban/{kamban}/update', [KambanController::class, 'update'])->name('kamban.update');
    Route::get('/kamban/{kamban}/delete', [KambanController::class, 'destroy'])->name('kamban.destroy');

});

require __DIR__.'/auth.php';
