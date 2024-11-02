<?php

namespace App\Http\Controllers;

use App\Models\MasterRatecard;
use App\Models\PublicModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class MasterRatecardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MasterRatecard::select('master_ratecard.*','mc.category_name')
        ->join('master_categories AS mc','mc.category_code', '=', 'master_ratecard.category_code')
        ->get();

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
            'job_description'   => 'required',
            'ratecard'          => 'required',
            'remarks'           => 'required'
        ]);
        //create post
        $save = MasterRatecard::create([
            'category_code'     => $request->post('category_code'),
            'job_category_code'     => $request->post('job_category_code'),
            'job_description'     => $request->post('job_description'),
            'ratecard'     => $request->post('ratecard'),
            'remarks'   => $request->post('remarks'),
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
     * @param  \App\Models\MasterRatecard  $masterRatecard
     * @return \Illuminate\Http\Response
     */
    public function show(String $id)
    {
        $data = MasterRatecard::find($id);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterRatecard  $masterRatecard
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterRatecard $masterRatecard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterRatecard  $masterRatecard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, String $id)
    {
        //validate form
        $this->validate($request, [
            'job_description'   => 'required',
            'ratecard'          => 'required',
            'remarks'           => 'required'
        ]);
        //create post
        $post = MasterRatecard::findOrFail($id);
        $post->update([
            'category_code'         => $request->post('category_code'),
            'job_category_code'     => $request->post('job_category_code'),
            'job_description'       => $request->post('job_description'),
            'ratecard'              => $request->post('ratecard'),
            'remarks'               => $request->post('remarks'),
            'status'               => $request->post('status'),
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
     * @param  \App\Models\MasterRatecard  $masterRatecard
     * @return \Illuminate\Http\Response
     */
    public function destroy(String $id)
    {
        $data = MasterRatecard::find($id);
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
        try {
            $URL = URL::current();
            $category_code = $request->category_code; 
            $search = $request->search;               
    
            
            if (empty($search)) {
                $count = (new MasterRatecard)->count();
                $arr_pagination = (new PublicModel())->pagination_without_search($URL, $request->limit, $request->offset);
            } else {
            
                $arr_pagination = (new PublicModel())->pagination_without_search($URL, $request->limit, $request->offset, $search);
            }
    
            
            $todos = (new MasterRatecard)->get_data_($search, $arr_pagination, $category_code);
            $count = $todos->count();
    
            return response()->json(
                (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
                200
            );
        } catch (\Exception $e) {
            
            \Log::error("Error in getData: " . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
    
}

