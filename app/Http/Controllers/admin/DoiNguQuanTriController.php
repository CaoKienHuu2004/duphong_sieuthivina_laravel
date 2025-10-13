<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiachinguoidungModel;

use App\Models\NguoidungModel;
use Illuminate\Http\Request;

class DoiNguQuanTriController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $danhsach = NguoidungModel::with('diachi')
            ->where('vaitro', 'admin')
            ->get();
        $diachi = DiachinguoidungModel::all();

        return view("doinguquantrivien.index", compact("danhsach","diachi"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
