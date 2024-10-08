<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Product;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\ContractItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;

class ContractController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Contract::with('customer')->get();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('contracts.partials.actions', ['data' => $data]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('contracts.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return view('contracts.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        $customer = Customer::where('business_name', $request->customer)->first();
        $productos = json_decode($request->array_products);
        // $fechaActual = Carbon::now('America/Santiago');
        // $fechaActual = ;
        $star_date = Carbon::createFromDate(2023, 12, 31);
        $file_propuesta = null;
        $correlativoInicial = 1001;
        $nroOrden = 0;
        $count = Contract::count();
        if ($count > 0) {
            $data = Contract::latest()->first();
            $nroOrden = $data->correlativo + 1;
        } else {
            $nroOrden = 1001;
        }
        if ($request->hasFile('file')) {
            $uploadPath = public_path('/storage/contratos/');
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/contratos/'.$fileName;
            $foto = $url;
            $file_propuesta = $url;
        }

        if ($request->type == 'annual') {
            $end_date = Carbon::createFromDate(2023, 12, 31)->addYear(1);
        }
        if ($request->type == 'two years') {
            $end_date = Carbon::createFromDate(2023, 12, 31)->addYear(2);
        }

        $contract = Contract::create([
            'customer_id'    => $customer->id,
            'user_id'        => auth()->user()->id,
            'correlativo'    => $nroOrden,
            'dominio'        => $request->dominio,
            'type_contract'  => $request->type_contract,
            'type'           => $request->type,
            'start_date'     => $star_date,
            'end_date'       => $end_date,
            'subtotal'       => $request->subtotal,
            'iva'            => $request->iva,
            'grand_total'    => $request->total,
            'file'           => $file_propuesta,
            'note'           => $request->note,
        ]);

        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            ContractItem::create([
                'contract_id'   => $contract->id,
                'product_id'    => $product->id,
                'details'       => $key->details,
                'quantity'      => $key->quantity,
                'price'         => $key->price,
                'total'         => $key->subtotal,
            ]);
        }

        return redirect()->route('contract.index')->with('success', 'Contrato Guardado Exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($contract)
    {
        $data = Contract::with('items', 'customer', 'items.product')->find($contract);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($contract)
    {
        $customers = Customer::all();
        $products = Product::all();
        $data = Contract::with('customer', 'items', 'items.product')->find($contract);

        return view('contracts.edit', compact('customers', 'products', 'data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, $contract)
    {
        $customer = Customer::where('business_name', $request->customer)->first();
        $productos = json_decode($request->array_products);
        // $fechaActual = Carbon::now('America/Santiago');
        // $fechaActual = ;
        $file_propuesta = null;

        if ($request->hasFile('file')) {
            $uploadPath = public_path('/storage/contratos/');
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/contratos/'.$fileName;
            $foto = $url;
            $file_propuesta = $url;
        }

        $data = Contract::find($contract);
        if ($request->type == 'annual') {
            $end_date = Carbon::parse($data->start_date)->addYear(1);
        }
        if ($request->type == 'two years') {
            $end_date = Carbon::parse($data->start_date)->addYear(2);
        }
        $data->update([
            'customer_id'    => $customer->id,
            'user_id'        => auth()->user()->id,
            'dominio'        => $request->dominio,
            'type_contract'  => $request->type_contract,
            'type'           => $request->type,
            'end_date'       => $end_date,
            'subtotal'       => $request->subtotal,
            'iva'            => $request->iva,
            'grand_total'    => $request->total,
            'file'           => $file_propuesta,
            'note'           => $request->note,
        ]);

        $data->items()->delete();
        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            ContractItem::create([
                'contract_id'   => $data->id,
                'product_id'    => $product->id,
                'details'       => $key->details,
                'quantity'      => $key->quantity,
                'price'         => $key->price,
                'total'         => $key->subtotal,
            ]);
        }

        return redirect()->route('contract.index')->with('success', 'Contrato Actualizado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($contract)
    {
        $data = Contract::find($contract);
        $data->items()->delete();
        $data->delete();
        return redirect()->route('contract.index')->with('success', 'Contrato Eliminado Exitosamente');
    }
}
