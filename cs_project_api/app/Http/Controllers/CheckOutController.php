<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\PublicModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        {
            $data = CheckOut::all();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $data
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
            'code_barang'   => 'required',
            'nama_barang'          => 'required',
            'kategori'           => 'required',
            'transaksi_date'           => 'required|date'
        ]);
        //create post
        $save = CheckOut::create([
            'code_barang'     => $request->post('code_barang'),
            'nama_barang'     => $request->post('nama_barang'),
            'kategori'     => $request->post('kategori'),
            'transaksi_date'     => $request->post('transaksi_date'),
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
     * @param  \App\Models\CheckOut  $checkOut
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $data = CheckOut::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CheckOut  $checkOut
     * @return \Illuminate\Http\Response
     */
    public function edit(CheckOut $checkOut)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CheckOut  $checkOut
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        //validate form
        $this->validate($request, [
            // 'code_barang'   => 'required',
            'nama_barang'          => 'required',
            'kategori'           => 'required',
            'transaksi_date'          => 'required|date'
        ]);
        //create post
        $post = CheckOut::findOrFail($id);
        $post->update([
            'code_barang'         => $request->post('code_barang'),
            'nama_barang'          => $request->post('nama_barang'),
            'kategori'              => $request->post('kategori'),
            'transaksi_date'       => $request->post('transaksi_date'),
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
     * @param  \App\Models\CheckOut  $checkOut
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $data = CheckOut::find($id);
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
            $count = (new CheckOut)->count();
            $arr_pagination = (new PublicModel())->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = (new CheckOut)->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos =  (new CheckOut)->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }

        return response()->json(
            (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
            200
        );
    }
}
