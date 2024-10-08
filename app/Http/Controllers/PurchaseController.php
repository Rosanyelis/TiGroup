<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\PurchaseItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return view('purchases.index', compact('suppliers'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('purchases')
                ->join('users', 'purchases.user_id', '=', 'users.id')
                ->join('suppliers', 'purchases.supplier_id', '=', 'suppliers.id')
                ->select('purchases.*', 'users.name as user', 'suppliers.business_name as supplier');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('supplier_id') && $request->get('supplier_id') != '') {
                        $query->where('purchases.supplier_id', $request->get('supplier_id'));
                    }

                    if ($request->has('start') && $request->has('end') && $request->get('start') != '' && $request->get('end') != '') {
                        $query->whereBetween('purchases.created_at', [$request->get('start'), $request->get('end')]);
                    }

                    if ($request->has('status') && $request->get('status') != '') {
                        $query->where('purchases.received', $request->get('status'));
                    }

                    if ($request->has('search') && $request->get('search')['value'] != '') {
                        $searchValue = $request->get('search')['value'];
                        $query->where(function ($subQuery) use ($searchValue) {
                            $subQuery->where('suppliers.name', 'like', "%{$searchValue}%")
                                     ->orWhere('users.name', 'like', "%{$searchValue}%")
                                     ->orWhere('purchases.reference', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addColumn('actions', function ($data) {
                    return view('purchases.partials.actions', ['data' => $data]);
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
        return view('purchases.create', compact('suppliers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequest $request)
    {
        $urlfile = null;
        if ($request->hasFile('archivo')) {
            $uploadPath = public_path('/storage/compras/');
            $file = $request->file('archivo');
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/compras/'.$fileName;
            $urlfile = $url;
        }
        $productos = json_decode($request->array_products);
        $purchase = Purchase::create([
            'supplier_id'    => $request->supplier_id,
            'user_id'        => auth()->user()->id,
            'total'          => $request->total,
            'reference'      => $request->reference,
            'files'          => $urlfile,
            'note'           => $request->note,
            'received'       => $request->received
        ]);

        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            PurchaseItem::create([
                'purchase_id'       => $purchase->id,
                'product_id'        => $product->id,
                'quantity'          => $key->quantity,
                'cost'              => $key->price,
                'subtotal'          => $key->total,
            ]);

        }

        return redirect()->route('purchase.index')->with('success', 'Compra Guardada Exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($purchase)
    {
        $data = Purchase::with('items', 'supplier', 'items.product')->find($purchase);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($purchase)
    {
        $suppliers = Supplier::all();
        $products = Product::all();
        $data = Purchase::with('items', 'items.product')->find($purchase);
        return view('purchases.edit', compact('suppliers', 'products', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequest $request, $purchase)
    {

        $urlfile = null;
        if ($request->hasFile('archivo')) {
            $uploadPath = public_path('/storage/compras/');
            $file = $request->file('archivo');
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/compras/'.$fileName;
            $urlfile = $url;
        }

        $productos = json_decode($request->array_products);
        $purchase = Purchase::find($purchase);
        $urlfile = $purchase->files;
        $purchase->update([
            'supplier_id'    => $request->supplier_id,
            'user_id'        => auth()->user()->id,
            'total'          => $request->total,
            'reference'      => $request->reference,
            'received'       => $request->received,
            'files'          => $urlfile,
            'note'           => $request->note
        ]);
        PurchaseItem::where('purchase_id', $purchase->id)->delete();
        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            PurchaseItem::create([
                'purchase_id'       => $purchase->id,
                'product_id'        => $product->id,
                'quantity'          => $key->quantity,
                'cost'              => $key->price,
                'subtotal'          => $key->total,
            ]);
        }
        return redirect()->route('purchase.index')->with('success', 'Compra Actualizada Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($purchase)
    {
        $purchase = Purchase::find($purchase);
        $purchase->delete();

        $purchaseItems = PurchaseItem::where('purchase_id', $purchase->id)->get();
        foreach ($purchaseItems as $key) {
            $key->delete();
        }
        return redirect()->route('purchase.index')->with('success', 'Compra Eliminada Exitosamente');
    }

    public function purchasepdf($purchase)
    {
        $purchase = Purchase::with('purchaseItems', 'purchaseItems.product', 'supplier')->find($purchase);
        return Pdf::loadView('pdfs.purchase', compact('purchase'))
                ->stream(''.config('app.name', 'Laravel').' - Compra.pdf');
    }
}
