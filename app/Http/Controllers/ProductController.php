<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\TypeProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();
        return view('products.index', compact('category'));
    }

    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('category');
            return DataTables::of($data)
                ->filter(function ($query) use ($request) {
                    if ($request->has('category_id') && $request->get('category_id') != '') {
                        $query->where('category_id', $request->get('category_id'));
                    }

                    if ($request->has('search') && $request->get('search')['value'] != '') {
                        $searchValue = $request->get('search')['value'];
                        $query->where(function ($subQuery) use ($searchValue) {
                            $subQuery->where('name', 'like', "%{$searchValue}%")
                                     ->orWhere('code', 'like', "%{$searchValue}%")
                                     ->orWhere('type', 'like', "%{$searchValue}%");
                        });
                    }
                })
                ->addColumn('actions', function ($data) {
                    return view('products.partials.actions', ['id' => $data->id]);
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
        $category= Category::all();
        $typeproduct = TypeProduct::all();
        return view('products.create', compact('category', 'typeproduct'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->all();
        $producto = Product::create($data);

        return redirect()->route('product.index')->with('success', 'Producto creado con exito');

    }


    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product)
    {
        $category= Category::all();
        $typeproduct = TypeProduct::all();
        $product = Product::find($product);
        return view('products.edit', compact('product', 'category', 'typeproduct'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $product)
    {
        $data = $request->all();

        $product = Product::find($product);
        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Producto actualizado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {

        $data = Product::find($product);
        $data->delete();

        return redirect()->route('product.index')->with('success', 'Producto eliminado con exito');
    }
}
