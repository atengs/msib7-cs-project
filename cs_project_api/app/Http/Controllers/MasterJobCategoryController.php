<?php

namespace App\Http\Controllers;

use App\Models\MasterJobCategory;
use Illuminate\Http\Request;

class MasterJobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterJobCategory::all();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ],200 );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterJobCategory  $masterJobCategory
     * @return \Illuminate\Http\Response
     */
    public function show(MasterJobCategory $masterJobCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterJobCategory  $masterJobCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterJobCategory $masterJobCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterJobCategory  $masterJobCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterJobCategory $masterJobCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterJobCategory  $masterJobCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(MasterJobCategory $masterJobCategory)
    {
        //
    }
}
