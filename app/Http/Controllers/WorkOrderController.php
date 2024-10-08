<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\WorkOrder;
use Illuminate\Http\Request;
use App\Models\WorkOrderItem;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreWorkOrderRequest;
use App\Http\Requests\UpdateWorkOrderRequest;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Customer::all();
        if ($request->ajax()) {
            $data = WorkOrder::with('customer', 'user')->get();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('workorders.partials.actions', ['data' => $data]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('workorders.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Customer::all();
        $products = Product::all();
        return view('workorders.create', compact('clients', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkOrderRequest $request)
    {
        $correlativoInicial = 1001;
        $nroOrden = 0;
        $count = WorkOrder::count();
        if ($count > 0) {
            $data = WorkOrder::latest()->first();
            $nroOrden = $data->correlativo + 1;
        } else {
            $nroOrden = 1001;
        }
        $productos = json_decode($request->array_products);
        $workorder = WorkOrder::create([
            'customer_id'    => $request->customer_id,
            'user_id'        => auth()->user()->id,
            'correlativo'    => $nroOrden,
            'total'          => $request->total,
        ]);

        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            WorkOrderItem::create([
                'work_order_id'  => $workorder->id,
                'product_id'     => $product->id,
                'quantity'       => $key->quantity,
                'details'        => $key->details,
                'price'          => $key->price,
                'total'          => $key->subtotal,
            ]);
        }

        return redirect()->route('workorder.index')->with('success', 'Orden de Trabajo Creada Exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show($workOrder)
    {
        $workorder = WorkOrder::with('customer', 'user', 'items', 'items.product')->find($workOrder);
        return response()->json($workorder);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($workOrder)
    {
        $clients = Customer::all();
        $products = Product::all();
        $data = WorkOrder::with('customer', 'user', 'items', 'items.product')->find($workOrder);
        return view('workorders.edit', compact('clients', 'products', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkOrderRequest $request, $workOrder)
    {

        $workorder = WorkOrder::find($workOrder);
        $workorder->update([
            'customer_id'    => $request->customer_id,
            'user_id'        => auth()->user()->id,
            'total'          => $request->total,
        ]);
        WorkOrderItem::where('work_order_id', $workorder->id)->delete();
        $productos = json_decode($request->array_products);
        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            WorkOrderItem::create([
                'work_order_id'  => $workorder->id,
                'product_id'     => $product->id,
                'quantity'       => $key->quantity,
                'details'        => $key->details,
                'price'          => $key->price,
                'total'          => $key->subtotal,
            ]);
        }

        return redirect()->route('workorder.index')->with('success', 'Orden de Trabajo Actualizada Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $workorder = WorkOrder::find($request->id);
        $workorder->update([
            'status' => $request->status
        ]);
        return redirect()->route('workorder.index')->with('success', 'Estatus de Orden de Trabajo Actualizada Exitosamente');
    }
}
