<?php

namespace App\Http\Controllers;

use App\Models\Kamban;
use App\Http\Requests\StoreKambanRequest;
use App\Http\Requests\UpdateKambanRequest;

class KambanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kamban.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKambanRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kamban $kamban)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kamban $kamban)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateKambanRequest $request, Kamban $kamban)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kamban $kamban)
    {
        //
    }
}
