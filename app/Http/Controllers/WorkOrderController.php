<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\WorkOrder;
use App\Mail\SendWorkOrder;
use Illuminate\Http\Request;
use App\Models\WorkOrderItem;
use App\Models\WorkOrderTask;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
            $data = WorkOrder::with('customer', 'user', 'user_asigned')->get();
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
        $users = User::where('name', '!=' ,'Desarrollador')->where('id', '!=', Auth::user()->id)->get();
        return view('workorders.create', compact('clients', 'products', 'users'));
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
        $tasks = json_decode($request->array_tasks);
        $workorder = WorkOrder::create([
            'customer_id'    => $request->customer_id,
            'user_id'        => auth()->user()->id,
            'correlativo'    => $nroOrden,
            'total'          => $request->total,
            'user_assigned_id' => $request->user_assigned_id,
            'nota'        => $request->notes
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

        foreach ($tasks as $item) {
            WorkOrderTask::create([
                'work_order_id'  => $workorder->id,
                'task'           => $item->task,
            ]);
        }

        return redirect()->route('workorder.index')->with('success', 'Orden de Trabajo Creada Exitosamente');

    }

    /**
     * Display the specified resource.
     */
    public function show($workOrder)
    {
        $workorder = WorkOrder::with('customer', 'user', 'items', 'tasks', 'items.product')->find($workOrder);
        return response()->json($workorder);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($workOrder)
    {
        $clients = Customer::all();
        $products = Product::all();
        $users = User::where('name', '!=' ,'Desarrollador')->where('id', '!=', Auth::user()->id)->get();
        $data = WorkOrder::with('customer', 'user', 'items', 'tasks', 'items.product')->find($workOrder);
        return view('workorders.edit', compact('clients', 'products', 'users', 'data'));
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
            'user_assigned_id' => $request->user_assigned_id,
            'notes'        => $request->notes
        ]);
        WorkOrderItem::where('work_order_id', $workorder->id)->delete();
        WorkOrderTask::where('work_order_id', $workorder->id)->delete();

        $productos = json_decode($request->array_products);
        $tasks = json_decode($request->array_tasks);
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


        foreach ($tasks as $item) {
            WorkOrderTask::create([
                'work_order_id'  => $workorder->id,
                'task'           => $item->task,
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

    public function workorderpdf($workorder)
    {
        $workorder = WorkOrder::find($workorder);
        return Pdf::loadView('workorders.pdfs.workorder', compact('workorder'))
                ->stream(''.config('app.name', 'Laravel').' - Orden de Trabajo N '.$workorder->correlativo.'.pdf');
    }

    public function sendEmailWorkorderpdf($workorder)
    {
        $workorder = workorder::with('customer')->find($workorder);

        if ($workorder->customer->email == null) {
            return redirect()->route('workorder.index')->with('error', 'El Cliente no posee correo para enviar la cotizacion');
        }

        $publicpath = public_path('storage/ordentrabajo/');
        $namepdf = config('app.name', 'Laravel').' - Orden de Trabajo - '.$workorder->customer->business_name.' - '.date('Y-m-d').'.pdf';
        $urlpdf = $publicpath.$namepdf;


        $pdf = Pdf::loadView('workorders.pdfs.workorder', compact('workorder'))
                ->save($urlpdf);

        try {
            Mail::to($workorder->customer->email)->send(new SendWorkOrder($workorder, $urlpdf, $namepdf));

            return redirect()->route('workorder.index')->with('success', 'Orden de Trabajo Enviada Exitosamente');
        } catch (\Throwable $th) {
            dd($th);
            Log::error("error al enviar orden de trabajo: ".$th->getMessage());

            return redirect()->route('workorder.index')->with('error', 'Error al enviar la Orden de Trabajo, verifique su correo');
        }

    }
}
