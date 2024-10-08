<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Expense::all();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('expenses.partials.actions', ['id' => $data->id]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('expenses.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $expense = Expense::create($data);
        return redirect()->route('expense.index')->with('success', 'Gasto creado con exito');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($expense)
    {
        $data = Expense::find($expense);
        return view('expenses.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, $expense)
    {
        $data = $request->all();
        $expense = Expense::find($expense);
        $expense->update($data);
        return redirect()->route('expense.index')->with('success', 'Gasto actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($expense)
    {
        $expense = Expense::find($expense);
        $expense->delete();
        return redirect()->route('expense.index')->with('success', 'Gasto eliminado con exito');
    }
}
