<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\Correlative;
use App\Models\InvoiceItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Invoice::with('customer', 'contract', 'quotation', 'contractrenewed', 'user')
                ->where('status', '!=', 'Pagado');
            return DataTables::of($data)
                ->make(true);
        }
        return view('invoices.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        return view('invoices.create', compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $invoice = Invoice::create([
            'customer_id'       => $request->customer_id,
            'user_id'           => auth()->user()->id,
            'correlativo'       => $this->correlation(),
            'motive'            => $request->motive,
            'type'              => 'Invoice External',
            'net_amount'        => $request->subtotal,
            'iva'               => $request->iva,
            'total'             => $request->total,
            'additional_tax'    => $request->impuesto_adicional,
            'invoice_date'      => $request->invoice_date,
            'due_date'          => Carbon::parse($request->invoice_date)->addDays(5),
            'payment_form'      => $request->payment_form,
            'status'            => $request->status,
            'factura_pdf'       => $this->saveFile($request->factura_pdf),
        ]);

        $producto = json_decode($request->array_products);

        foreach ($producto as $key) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'codigo' => $key->code,
                'description' => $key->product,
                'price' => $key->price,
                'quantity' => $key->quantity,
                'impuesto_adicional' => $key->impuesto_adicional,
                'descuento' => $key->descuento,
                'total' => $key->subtotal
            ]);
        }

        if ($request->confirm_sale == 'Si') {
            // $this->createSale($invoice->id);
        }


        return redirect()->route('invoice.index')->with('success', 'Factura creada con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    public function updateInvoiceFile(Request $request)
    {

        if ($request->id == null) {
            return redirect()->back()->with('error', 'Error al cargar Nº de Factura y Archivo');
        }

        $invoice = Invoice::find($request->id);
        $invoice->update([
            'n_factura' => $request->n_factura,
        ]);

        return redirect()->back()->with('success', 'Nº de Factura y archivo cargado Exitosamente');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function changeStatus(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->update([
            'status' => $request->status
        ]);
        return redirect()->route('invoice.index')->with('success', 'Estatus de Factura Actualizada Exitosamente');
    }

    public function changeFormPayment(Request $request)
    {
        $invoice = Invoice::find($request->id);
        $invoice->update([
            'payment_form' => $request->payment_form
        ]);

        return redirect()->route('invoice.index')->with('success', 'Estatus de Factura Actualizada Exitosamente');
    }

    public function saveFile($archivo)
    {
        if ($archivo != null) {
            $uploadPath = public_path('/storage/facturas/');
            $file = $archivo;
            $extension = $file->getClientOriginalExtension();
            $uuid = Str::uuid(4);
            $fileName = $uuid . '.' . $extension;
            $file->move($uploadPath, $fileName);
            $url = '/storage/facturas/'.$fileName;
            $file_propuesta = $url;
        } else {
            $file_propuesta = null;
        }


        return $file_propuesta;
    }

    public function correlation()
    {
        $nro = Correlative::where('type', 'Invoice')->first();
        $correlativoInicial = $nro->correlative_initial;
        $correlativUltimo = $nro->correlative_last + 1;

        $count = Invoice::count();
        if ($count > 0) {
            $data = Invoice::latest()->first();
            $nroOrden = $correlativUltimo;
            $nro->update([
                'correlative_last' => $correlativUltimo,
            ]);
        } else {
            $nroOrden = $correlativoInicial;
        }
        return $nroOrden;

    }

    public function createSale($id)
    {
        $invoice = Invoice::find($id);
        $sale = Sale::create([
            'customer_id' => $invoice->customer_id,
            'invoice_id' => $invoice->id,
            'user_id' => auth()->user()->id,
            'type' => $invoice->type,
            'subtotal' => $invoice->net_amount,
            'iva' => $invoice->iva,
            'grand_total' => $invoice->total,
            'discount' => $invoice->discount,
            'payment_form' => $invoice->payment_form,
        ]);
    }
}
