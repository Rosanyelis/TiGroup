<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::all();
            return DataTables::of($data)
                ->addColumn('actions', function ($data) {
                    return view('categories.partials.actions', ['id' => $data->id]);
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->all());
        return redirect()->route('category.index')->with('success', 'Categoría creada con exito');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($category_id)
    {
        $category = Category::find($category_id);
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, $category_id)
    {
        $category = Category::find($category_id);
        $category->update($request->all());
        return redirect()->route('category.index')->with('success', 'Categoría actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($category_id)
    {
        // dd($category_id);
        $count = Product::where('category_id', $category_id)->count();
        if ($count > 0) {
            return redirect()->route('category.index')->with('error', 'La Categoría no puede ser eliminada, tiene productos relacionados');
        }

        $data = Category::destroy($category_id);


        return redirect()->route('category.index')->with('success', 'Categoría eliminada con exito');
    }
}
