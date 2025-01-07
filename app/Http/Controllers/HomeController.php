<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Expense;
use App\Models\Invoice;
use App\Models\Contract;
use App\Models\Purchase;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard');
    }

    /**
     * Ventas del mes.
     */
    public function saleoverview()
    {
        # ventas del mes
        $sales = Invoice::whereMonth('created_at', date('m'))->sum('net_amount');
        # facturas pendientes de pago
        $invoices = Invoice::whereMonth('created_at', date('m'))
            ->where('status', 'Facturado')->orWhere('status', 'Por Facturar')->sum('net_amount');
        # total cotizados
        $quotations = Quotation::whereMonth('created_at', date('m'))
            ->sum('subtotal');

        return response()->json(['sales' => $sales, 'invoices' => $invoices, 'quotations' => $quotations]);
    }

    /** Servicios por Vencer */
    public function services()
    {
        $services = Contract::where('end_date', '>=', Carbon::now())
            ->with('customer') // Cargar la relación con el cliente
            ->get();

        return response()->json($services);
    }

    public function contractType()
    {
        $hosting = Contract::where('type_contract', 'Contrato de Hosting')->count();
        $soporte = Contract::where('type_contract', 'Contrato de Soporte')->count();
        $desarrollo = Contract::where('type_contract', 'Contrato de Desarrollo Web')->count();
        $redes = Contract::where('type_contract', 'Contrato de Redes Sociales')->count();
        $total = $hosting + $soporte + $desarrollo + $redes;

        return response()->json(['hosting' => $hosting, 'soporte' => $soporte, 'desarrollo' => $desarrollo, 'redes' => $redes, 'total' => $total]);
    }

    public function hostingType()
    {
        $hosting = Contract::join('contract_items', 'contracts.id', '=', 'contract_items.contract_id')
            ->join('products', 'contract_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'Hosting')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->first();

        $hostingvps = Contract::join('contract_items', 'contracts.id', '=', 'contract_items.contract_id')
            ->join('products', 'contract_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'Servidores VPS')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->first();

        $hostingtiendas = Contract::join('contract_items', 'contracts.id', '=', 'contract_items.contract_id')
            ->join('products', 'contract_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'Tiendas Online')
            ->select('categories.name', DB::raw('count(*) as total'))
            ->groupBy('categories.name')
            ->first();

            // dd($hosting, $hostingvps, $hostingtiendas);

            if ($hosting == null) {
                $hosting = 0;
            } else {
                $hosting = $hosting->total;
            }

            if ($hostingvps == null) {
                $hostingvps = 0;
            } else {
                $hostingvps = $hostingvps->total;
            }

            if ($hostingtiendas == null) {
                $hostingtiendas = 0;
            } else {
                $hostingtiendas = $hostingtiendas->total;
            }

        $total = $hosting + $hostingvps + $hostingtiendas;

        return response()->json(['hosting' => $hosting,
            'vps' => $hostingvps,
            'tiendas' => $hostingtiendas, 'total' => $total]);
    }

    public function sale_years()
    {
        $sales_year = Invoice::whereYear('created_at', date('Y'))->sum('net_amount');

        return response()->json(['sales_year' => $sales_year]);
    }

    public function purchase_month()
    {
        $purchases = Purchase::sum('total');
        return response()->json(['purchases' => $purchases]);
    }

    public function expenses_month()
    {
        $expenses = Expense::sum('amount');
        return response()->json(['expenses' => $expenses]);
    }

    public function invoices_pending_month()
    {
        $invoices = Invoice::where('status', 'Por Facturar')->sum('net_amount');

        $countInvoices = Invoice::where('status', 'Por Facturar')->count();
        return response()->json(['invoices_pendind' => $invoices, 'countInvoices' => $countInvoices]);
    }
}
