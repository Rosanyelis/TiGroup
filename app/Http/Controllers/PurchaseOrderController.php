<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('purchasesorders.index', compact('suppliers'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('purchase_orders')
                ->join('users', 'purchase_orders.user_id', '=', 'users.id')
                ->join('suppliers', 'purchase_orders.supplier_id', '=', 'suppliers.id')
                ->select('purchase_orders.*', 'users.name as user', 'suppliers.business_name as supplier');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('supplier_id') && $request->get('supplier_id') != '') {
                        $query->where('purchase_orders.supplier_id', $request->get('supplier_id'));
                    }

                    if ($request->has('start') && $request->has('end') && $request->get('start') != '' && $request->get('end') != '') {
                        $query->whereBetween('purchase_orders.created_at', [$request->get('start'), $request->get('end')]);
                    }

                    if ($request->has('search') && $request->get('search')['value'] != '') {
                        $searchValue = $request->get('search')['value'];
                        $query->where(function ($subQuery) use ($searchValue) {
                            $subQuery->where('purchase_orders.name', 'like', "%{$searchValue}%")
                                     ->orWhere('users.name', 'like', "%{$searchValue}%")
                                     ->orWhere('purchase_orders.reference', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addColumn('actions', function ($data) {
                    return view('purchasesorders.partials.actions', ['data' => $data]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function productjson($product)
    {
        $data = Product::find($product);
        return response()->json($data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        return view('purchasesorders.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        $productos = json_decode($request->array_products);
        $correlativoInicial = 1001;
        $nroOrden = 0;
        $count = PurchaseOrder::count();
        if ($count > 0) {
            $data = PurchaseOrder::latest()->first();
            $nroOrden = $data->correlativo + 1;
        } else {
            $nroOrden = 1001;
        }
        $purchase = PurchaseOrder::create([
            'supplier_id'    => $request->supplier_id,
            'user_id'        => auth()->user()->id,
            'correlativo'    => $nroOrden,
            'total'          => $request->total,
            'note'           => $request->note,
        ]);

        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            PurchaseOrderItem::create([
                'purchase_order_id' => $purchase->id,
                'product_id'        => $product->id,
                'quantity'          => $key->quantity,
                'cost'              => $key->price,
                'subtotal'          => $key->total,
            ]);

        }

        return redirect()->route('purchaseorder.index')->with('success', 'Orden de Compra Guardada Exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($purchaseorder)
    {
        $data = PurchaseOrder::with('items', 'supplier', 'items.product')->find($purchaseorder);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($purchaseorder)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $data = PurchaseOrder::with('items', 'items.product')->find($purchaseorder);
        return view('purchasesorders.edit', compact('suppliers', 'products', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, $purchaseorder)
    {

        $productos = json_decode($request->array_products);
        $purchase = PurchaseOrder::find($purchaseorder);
        $purchase->update([
            'supplier_id'    => $request->supplier_id,
            'user_id'        => auth()->user()->id,
            'total'          => $request->total,
            'note'           => $request->note
        ]);
        PurchaseOrderItem::where('purchase_order_id', $purchase->id)->delete();
        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            PurchaseOrderItem::create([
                'purchase_order_id'       => $purchase->id,
                'product_id'        => $product->id,
                'quantity'          => $key->quantity,
                'cost'              => $key->price,
                'subtotal'          => $key->total,
            ]);
        }
        return redirect()->route('purchaseorder.index')->with('success', 'Orden de Compra Actualizada Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($purchase)
    {
        $purchase = PurchaseOrder::find($purchase);
        $purchase->delete();

        $purchaseItems = PurchaseOrderItem::where('purchase_order_id', $purchase->id)->get();
        foreach ($purchaseItems as $key) {
            $key->delete();
        }
        return redirect()->route('purchaseorder.index')->with('success', 'Orden de Compra Eliminada Exitosamente');
    }

    public function purchasepdf($purchase)
    {
        $purchase = Purchase::with('purchaseItems', 'purchaseItems.product', 'supplier')->find($purchase);
        return Pdf::loadView('pdfs.purchase', compact('purchase'))
                ->stream(''.config('app.name', 'Laravel').' - Compra.pdf');
    }

}
