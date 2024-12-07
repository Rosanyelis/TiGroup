<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Contract;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ContractsRenewed;
use App\Models\ContractsRenewedItems;
use Yajra\DataTables\Facades\DataTables;

class ContractsRenewedController extends Controller
{

    public function datatableRenew(Request $request)
    {
        if ($request->ajax()) {
            $data = ContractsRenewed::with('customer') // Cargar la relación con el cliente
            ->get();
            return DataTables::of($data)
                // ->addColumn('actions', function ($data) {
                //     return view('contracts.partials.actions', ['data' => $data]);
                // })
                // ->rawColumns(['actions'])
                ->make(true);
        }
    }

    public function create($contract)
    {
        $customers = Customer::all();
        $products = Product::all();
        $data = Contract::with('customer', 'items', 'items.product')->find($contract);

        return view('contracts.renew', compact('customers', 'products', 'data'));
    }

    public function store(Request $request, $contract)
    {
        $data = Contract::find($contract);
        $star_date = Carbon::parse($request->start_date);
        if ($request->type == 'annual') {
            $end_date = $star_date->addYear(1);
        }
        if ($request->type == 'two years') {
            $end_date = $star_date->addYear(2);
        }
        $file_propuesta = $data->file_propuesta;
        if ($request->hasFile('file')) {
            $file_propuesta = $this->saveFile($request->file('file'));
        }
        # creamos la renovacion del contrato
        $contractRenew = ContractsRenewed::create([
            'contract_id' => $contract,
            'user_id' => auth()->user()->id,
            'customer_id' => $data->customer_id,
            'correlativo' => $this->correlation(),
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'dominio' => $request->dominio,
            'type' => $request->type,
            'type_contract' => $data->type_contract,
            'subtotal' => $request->subtotal,
            'iva' => $request->iva,
            'grand_total' => $request->total,
            'note' => $request->note,
            'file' => $file_propuesta,
        ]);
        $productos = json_decode($request->array_products);
        foreach ($productos as $key) {
            $product = Product::where('code', $key->code)->first();
            ContractsRenewedItems::create([
                'contract_renewed_id' => $contractRenew->id,
                'product_id'    => $product->id,
                'details'       => $key->details,
                'quantity'      => $key->quantity,
                'price'         => $key->price,
                'total'         => $key->subtotal,
            ]);
        }

        # ahora debemos actualizar la fecha de vencimiento del contrato original
        $data->update([
            'start_date' => $request->start_date,
            'end_date' => $end_date,
            'dominio' => $request->dominio,
            'type' => $request->type,
        ]);

        # creamos la factura
        // $this->createInvoice($contractRenew);

        return redirect()->route('contract.index')->with('success', 'Contrato Renovado Exitosamente');

    }

    public function correlation()
    {
        $correlativoInicial = 1001;
        $nroOrden = 0;
        $count = ContractsRenewed::count();

        if ($count > 0) {
            $data = ContractsRenewed::latest()->first();
            $nroOrden = $data->correlativo + 1;
        } else {
            $nroOrden = 1001;
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

    public function createInvoice($contractRenew)
    {
        $data = ContractsRenewed::with('items', 'customer', 'items.product')->find($contract);

        $invoice = Invoice::create([
            'customer_id' => $data->customer_id,
            'contract_renewed_id' => $data->id,
            'user_id' => auth()->user()->id,
            'correlativo' => $this->correlationInvoice(),
            'type' => 'Contract',
            'motive' => $data->type_contract.' - Renovación',
            'net_amount' => $data->subtotal,
            'iva' => $data->iva,
            'total' => $data->grand_total,
            'invoice_date' => $data->end_date,
            'due_date' => Carbon::parse($data->end_date)->addDays(5),
        ]);

        return $invoice;
    }

    public function correlationInvoice()
    {
        $correlativoInicial = 1001;
        $nroOrden = 0;
        $count = Invoice::count();

        if ($count > 0) {
            $data = Invoice::latest()->first();
            $nroOrden = $data->correlativo + 1;
        } else {
            $nroOrden = 1001;
        }

        return $nroOrden;
    }
}
