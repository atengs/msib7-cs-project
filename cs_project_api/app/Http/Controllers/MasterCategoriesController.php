<?php

namespace App\Http\Controllers;

use App\Models\MasterCategories;
use App\Models\PublicModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class MasterCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterCategories::all();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ]);
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
        //validate form
        $this->validate($request, [
            // 'category_code'     => 'required',
            'category_name'     => 'required',
            'category_prefix'   => 'required'
        ]);
        //create post
        $save = MasterCategories::create([
            // 'category_code'     => $request->post('category_code'),
            'category_code'     => $this->generateCode(),
            'category_name'     => $request->post('category_name'),
            'category_prefix'   => $request->post('category_prefix'),
            'created_by'        => $request->post('userid')
        ]);

        if($save) {
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menyimpan data',
            ], 200);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Gagal menyimpan data',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterCategories  $categories
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $data = MasterCategories::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterCategories  $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterCategories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterCategories  $categories
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        //validate form
        $this->validate($request, [
            'category_name'   => 'required',
            'category_prefix' => 'required',
        ]);
        //create post
        $post = MasterCategories::findOrFail($id);
        $post->update([
            'category_name'         => $request->post('category_name'),
            'category_prefix'     => $request->post('category_prefix'),
            'updated_by'            => $request->post('userid'),
            'updated_at'            => Carbon::now()
        ]);

        if($post) {
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menyimpan data',
            ], 200);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Gagal menyimpan data',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterCategories  $categories
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $data = MasterCategories::find($id);
        if($data->delete()) {
            return response()->json([
                'status'    => true,
                'message'   => 'Berhasil menghapus data',
            ], 200);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Gagal menghapus data',
            ], 400);
        }
    }

    public function getData(Request $request)
    {
        $URL =  URL::current();

        if (!isset($request->search)) {
            $count = (new MasterCategories)->count();
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = (new MasterCategories)->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos =  (new MasterCategories)->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }

        return response()->json(
            (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
            200
        );
    }

    public function generateCode()
    {
        $kode =  '001';

        // $count = MasterCategories::count();
        $count = MasterCategories::withTrashed()->count();

        if ($count > 0) {
            $kode = str_pad($kode + $count, 3, '0', STR_PAD_LEFT);
            return 'CAT' . $kode;
        } else {
            return 'CAT' . $kode;
        }
    }
}
