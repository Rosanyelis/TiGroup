<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SaleController extends Controller
{

    public function index()
    {
        $users = User::where('name', '!=' ,'Desarrollador')->get();
        $clients = Customer::all();
        return view('sales.index', compact('users', 'clients'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Sale::with('customer', 'user', 'invoice');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('user_id') && $request->get('user_id') != '') {
                        $query->where('sales.user_id', $request->get('user_id'));
                    }

                    if ($request->has('customer_id') && $request->get('customer_id') != '') {
                        $query->where('sales.customer_id', $request->get('customer_id'));
                    }

                    if ($request->has('start') && $request->has('end') && $request->get('start') != '' && $request->get('end') != '') {
                        $query->whereBetween('sales.created_at', [$request->get('start'), $request->get('end')]);
                    }
                    if ($request->has('search') && $request->get('search')['value'] != '') {
                        $searchValue = $request->get('search')['value'];
                        $query->where(function ($subQuery) use ($searchValue) {
                            $subQuery->where('customer.name', 'like', "%{$searchValue}%")
                                    ->orWhere('user.name', 'like', "%{$searchValue}%")
                                    ->orWhere('customer.rut', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->make(true);
        }
    }
}
