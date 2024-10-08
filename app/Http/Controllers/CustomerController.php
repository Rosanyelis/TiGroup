<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\StoreImportCustomerRequest;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::all();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('customers.partials.actions', ['id' => $data->id]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('customers.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        return redirect()->route('customer.index')->with('success', 'Cliente creado con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show($customer)
    {
        $customer = Customer::find($customer);
        return response()->json($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer)
    {
        $customer = Customer::find($customer);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, $customer)
    {
        $cust = Customer::find($customer);
        $cust->update($request->all());
        return redirect()->route('customer.index')->with('success', 'Cliente actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($customer)
    {
        $cust = Customer::find($customer);
        $cust->delete();
        return redirect()->route('customer.index')->with('success', 'Cliente eliminado con exito');
    }

    public function import()
    {
        return view('customers.import');
    }

    public function importData(StoreImportCustomerRequest $request)
    {
        Excel::import(new CustomerImport, $request->file('archivo'));

        return redirect()->route('customer.index')->with('success', 'Data importada exitósamente');
    }
}
