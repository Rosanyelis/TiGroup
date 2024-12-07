<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\Correlative;
use Illuminate\Support\Str;
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
        $countContractDue = Contract::where('end_date', '<=', now())
                        ->whereIn('status', ['Activo', 'Por Facturar'])
                        ->count();
        if ($request->ajax()) {
            $data = Contract::with('customer')->get();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('contracts.partials.actions', ['data' => $data]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('contracts.index', compact('countContractDue'));
    }

    public function datatableDue(Request $request)
    {
        if ($request->ajax()) {
            $data = Contract::where('end_date', '<=', now())
            ->whereIn('status', ['Activo', 'Por Facturar'])
            ->with('customer') // Cargar la relación con el cliente
            ->get();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('contracts.partials.actions', ['data' => $data]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
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
        $data = [];
        $data['customer_id'] = $request->customer_id;
        $data['user_id'] = auth()->user()->id;
        $data['correlativo'] = $this->correlation();
        $data['start_date'] = $request->start_date;
        if ($request->hasFile('file')) {
            $data['file_propuesta'] = $this->saveFile($request->file('file'));
        }
        $star_date = Carbon::parse($request->start_date);
        if ($request->type == 'annual') {
            $end_date = $star_date->addYear(1);
            $data['end_date'] = $end_date;
        }
        if ($request->type == 'two years') {
            $end_date = $star_date->addYear(2);
            $data['end_date'] = $end_date;
        }
        $data['dominio'] = $request->dominio;
        $data['type'] = $request->type;
        $data['type_contract'] = $request->type_contract;
        $data['subtotal'] = $request->subtotal;
        $data['iva'] = $request->iva;
        $data['grand_total'] = $request->total;
        $data['note'] = $request->note;
        $data['confirm_invoice'] = $request->confirm_invoice;
        $data['status'] = $request->status;

        $contract = Contract::create($data);

        $productos = json_decode($request->array_products);
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

        // if ($request->confirm_invoice == 'Si') {
        //     $this->createInvoice($contract->id);
        // }
        return redirect()->route('contract.index')->with('success', 'Contrato Guardado Exitosamente');
    }

    public function createInvoice($contract)
    {
        $data = Contract::with('items', 'customer', 'items.product')->find($contract);

        $invoice = Invoice::create([
            'customer_id' => $data->customer_id,
            'contract_id' => $data->id,
            'user_id' => auth()->user()->id,
            'correlativo' => $this->correlationInvoice(),
            'type' => 'Contract',
            'motive' => $data->type_contract,
            'net_amount' => $data->subtotal,
            'iva' => $data->iva,
            'total' => $data->grand_total,
            'invoice_date' => $data->end_date,
            'due_date' => Carbon::parse($data->end_date)->addDays(5),
        ]);

        return $invoice;
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
        $star_date = Carbon::parse($request->start_date);
        if ($request->type == 'annual') {
            $end_date = $star_date->addYear(1);
        }
        if ($request->type == 'two years') {
            $end_date = $star_date->addYear(2);
        }

        $data = Contract::find($contract);
        $file_propuesta = $data->file_propuesta;
        if ($request->hasFile('file')) {
            $file_propuesta = $this->saveFile($request->file('file'));
        }
        $data->update([
            'customer_id' => $request->customer_id,
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'dominio' => $request->dominio,
            'type' => $request->type,
            'type_contract' => $request->type_contract,
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'grand_total' => $request->total,
            'note' => $request->note,
            'file' => $file_propuesta,
            // 'confirm_invoice' => $request->confirm_invoice,
            'status' => $request->status
        ]);

        $data->items()->delete();
        $productos = json_decode($request->array_products);
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

        // if ($request->confirm_invoice == 'Si') {
        //     $this->updateInvoice($contract->id);
        // }

        return redirect()->route('contract.index')->with('success', 'Contrato Actualizado Exitosamente');
    }

    public function updateInvoice($contract)
    {
        $data = Contract::find($contract)->count();
        if ($data == 0) {
            $this->createInvoice($contract);
        }

        $data = Contract::with('items', 'customer', 'items.product')->find($contract);
        $date_due = Carbon::parse($data->end_date);
        $data->invoice()->update([
            'customer_id' => $data->customer_id,
            'contract_id' => $data->id,
            'user_id' => auth()->user()->id,
            'correlativo' => $this->correlationInvoice(),
            'type' => 'Contract',
            'motive' => $data->type_contract,
            'net_amount' => $data->subtotal,
            'iva' => $data->iva,
            'total' => $data->grand_total,
            'invoice_date' => $data->end_date,
            'due_date' => $date_due->addDays(5),
        ]);

        return $data->invoice;
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

    public function correlation()
    {
        $nro = Correlative::where('type', 'contract')->first();
        $correlativoInicial = $nro->correlative_initial;
        $correlativUltimo = $nro->correlative_last + 1;

        $count = Contract::count();
        if ($count > 0) {
            $data = Contract::latest()->first();
            $nroOrden = $correlativUltimo;
            $nro->update([
                'correlative_last' => $correlativUltimo,
            ]);
        } else {
            $nroOrden = $correlativoInicial;
        }
        return $nroOrden;

    }

    public function correlationInvoice()
    {
        $nro = Correlative::where('type', 'Invoice')->first();
        $correlativoInicial = $nro->correlative_initial;
        $correlativUltimo = $nro->correlative_last + 1;

        $count = Invoice::count();

        if ($count > 0) {
            $data = Invoice::latest()->first();
            $nroOrden = $data->correlativo + 1;
            $nro->update([
                'correlative_last' => $correlativUltimo,
            ]);
        } else {
            $nroOrden = $correlativoInicial;
        }

        return $nroOrden;
    }

    public function saveFile($archivo)
    {
        $uploadPath = public_path('/storage/contratos/');
        $file = $archivo;
        $extension = $file->getClientOriginalExtension();
        $uuid = Str::uuid(4);
        $fileName = $uuid . '.' . $extension;
        $file->move($uploadPath, $fileName);
        $url = '/storage/contratos/'.$fileName;
        $file_propuesta = $url;

        return $file_propuesta;
    }

    public function renew_contract($contract)
    {
        $customers = Customer::all();
        $products = Product::all();
        $data = Contract::with('customer', 'items', 'items.product')->find($contract);

        return view('contracts.renew', compact('customers', 'products', 'data'));
    }

    public function store_renew(StoreContractRequest $request)
    {
        $data = [];
        $data['customer_id'] = $request->customer_id;
        $data['user_id'] = auth()->user()->id;
        $data['correlativo'] = $this->correlation();
        $data['start_date'] = $request->start_date;
        if ($request->hasFile('file')) {
            $data['file_propuesta'] = $this->saveFile($request->file('file'));
        }
        $star_date = Carbon::parse($request->start_date);
        if ($request->type == 'annual') {
            $end_date = $star_date->addYear(1);
            $data['end_date'] = $end_date;
        }
        if ($request->type == 'two years') {
            $end_date = $star_date->addYear(2);
            $data['end_date'] = $end_date;
        }
        $data['dominio'] = $request->dominio;
        $data['type_contract'] = $request->type_contract;
        $data['type'] = $request->type;
        $data['subtotal'] = $request->subtotal;
        $data['iva'] = $request->iva;
        $data['grand_total'] = $request->grand_total;
        $data['note'] = $request->note;
        $data['status'] = 'Activo';
        $data['items'] = $request->items;
        Contract::create($data);
        return redirect()->route('contract.index')->with('success', 'Contrato Renovado Exitosamente');
    }
}
