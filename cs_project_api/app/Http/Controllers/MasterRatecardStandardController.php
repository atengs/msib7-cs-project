<?php

namespace App\Http\Controllers;

use App\Models\MasterRatecardStandard;
use App\Models\MasterRatecard;
use App\Models\TransactionDetail;
use App\Models\PublicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MasterRatecardStandardController extends Controller
{
        public function index()
        {
            $data = MasterRatecard::select(
                    'master_ratecard.*',
                    'mc.category_name',
                    'mj.job_category_name', // Ambil kolom job_category_name dari tabel master_job_categories
                    'mrs.cost'
                )
                ->join('master_categories AS mc', 'mc.category_code', '=', 'master_ratecard.category_code')
                ->leftJoin('master_ratecard_standard AS mrs', 'mrs.ratecard_id', '=', 'master_ratecard.id')
                ->leftJoin('master_job_categories AS mj', 'mj.job_category_code', '=', 'master_ratecard.job_category_code') // Join tabel master_job_categories
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $data
            ]);
        }

        public function getFilterData()
        {
            $data = MasterRatecard::select(
                    'master_ratecard.id',
                    'mc.category_name',
                    'mj.job_category_name',
                    'master_ratecard.job_description',
                    'master_ratecard.ratecard',
                    'mrs.cost'
                )
                ->join('master_categories AS mc', 'mc.category_code', '=', 'master_ratecard.category_code')
                ->leftJoin('master_job_categories AS mj', 'mj.job_category_code', '=', 'master_ratecard.job_category_code')
                ->leftJoin('master_ratecard_standard AS mrs', 'mrs.ratecard_id', '=', 'master_ratecard.id')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
                'data' => $data
            ]);


        }


    // public function index()
    // {
    //     $data = MasterRatecard::select('master_ratecard.*','mc.category_name', 'mrs.cost')
    //     ->join('master_categories AS mc','mc.category_code', '=', 'master_ratecard.category_code')
    //     ->leftjoin('master_ratecard_standard AS mrs', 'mrs.ratecard_id', '=', 'master_ratecard.id')
    //     ->get();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil',
    //         'data' => $data
    //     ]);
    // }
    

    public function show(String $id)
    {

    }

    
    public function store(Request $request)
    {
        // Validasi input
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'ratecard_id' => 'required|exists:master_ratecard,id', 
            'cost' => 'required|numeric|min:0', 
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }
    
        try {
           
            $ratecardExists = DB::table('master_ratecard')
                ->where('id', $request->ratecard_id)
                ->exists();
    
            if (!$ratecardExists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ratecard ID does not exist in master_ratecard',
                ], 404);
            }
    
          
            $ratecardStandard = MasterRatecardStandard::where('ratecard_id', $request->ratecard_id)->first();
    
            if ($ratecardStandard) {
              
                $ratecardStandard->update([
                    'cost' => $request->cost,
                ]);
            } else {
               
                MasterRatecardStandard::create([
                    'ratecard_id' => $request->ratecard_id,
                    'cost' => $request->cost,
                ]);
            }
    
            return response()->json([
                'status' => true,
                'message' => 'Cost successfully saved!',
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error in store method: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to save cost. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    
    

    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'cost' => 'required|numeric|min:0', // Validasi nilai cost
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Cari data berdasarkan ID
            $ratecardStandard = MasterRatecardStandard::findOrFail($id);

            // Update nilai cost
            $ratecardStandard->update([
                'cost' => $request->cost,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Cost successfully updated!',
            ], 200);
        } catch (\Exception $e) {
            \Log::error("Error in update method: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Failed to update cost. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    public function destroy(String $id)
    {

    }
    public function getData(Request $request)
    {
        
    }
   
}