<?php

namespace App\Http\Controllers;

use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\PublicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;

class TransactionHeaderController extends Controller
{

    public function index()
    {
        $data = TransactionHeader::all();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ],200 );
    }

    // public function show(String $id)
    // {
    //     // $data = TransactionHeader::find($id);
    //     $data = TransactionHeader::select('transaction_header.*', 'mj.job_description', 'td.ratecard_id', 'td.ratecard_nominal')
    //     ->leftJoin('transaction_detail AS td', 'td.trans_number','=','transaction_header.trans_number')
    //     ->leftJoin('master_ratecard as mj','mj.id', '=', 'td.ratecard_id')
    //     ->whereNull('transaction_header.deleted_at')
    //     ->where('transaction_header.id', $id)
    //     ->first();
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil',
    //         'data' => $data
    //     ],200 );
    // }

    public function show(String $id)
    {
        // Ambil header transaksi berdasarkan ID
        $header = TransactionHeader::whereNull('deleted_at')
            ->where('id', $id)
            ->first();

        // Jika header tidak ditemukan, kembalikan respon 404
        if (!$header) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 404);
        }

        // Ambil detail transaksi dengan join ke master_ratecard dan master_ratecard_standard
        $details = TransactionDetail::select(
            'transaction_detail.id',
            'mr.job_description',
            'transaction_detail.ratecard_id',
            'transaction_detail.ratecard_nominal',
            'transaction_detail.note',
            'transaction_detail.business_type',
            'transaction_detail.qty',
            'mrs.cost' // Ambil nilai cost langsung dari master_ratecard_standard
        )
        ->join('master_ratecard as mr', 'mr.id', '=', 'transaction_detail.ratecard_id')
        ->join('master_ratecard_standard as mrs', 'mrs.id', '=', 'transaction_detail.ratecard_id') // Join ke tabel master_ratecard_standard
        ->where('transaction_detail.trans_number', $header->trans_number)
        ->get();

        // Kembalikan response dengan header dan details
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => [
                'header' => $header,
                'ratecards' => $details
            ]
        ], 200);
    }

    

    public function store (Request $request)
    {
        DB::beginTransaction();
        $this->validate($request, [
            'trans_number' => 'required|string',
            'customer' => 'required|string',
            // 'trans_date' => 'required|date',
            'person_in_charge' => 'required|string',
            'address' => 'required|string',
            'project' => 'required|string',
            'job' => 'required|string',
            'acount_executive' => 'required|string',
            'acount_manager' => 'required|string',
            'finance_manager' => 'required|string',
            'payment_status' => 'required|string',
            'jenis_pembayaran' => 'required|string',
            // 'term' => 'required|string',
            // 'pph23' => 'required|boolean', 
            'ppn' => 'required|boolean', 
            'ppn_percent' => 'nullable|numeric|min:0|max:100',
            'agency_fee' => 'required|string',
            // 'status' => 'required|string',
            
        ]);
        
        $item = new TransactionHeader;
 
        $item->trans_number = $request->input('trans_number');
        $item->customer = $request->input('customer');
        // $item->trans_date = $request->input('trans_date');
        $item->trans_date = date('Y-m-d'); 
        $item->person_in_charge = $request->input('person_in_charge');
        $item->address = $request->input('address');
        $item->project = $request->input('project');
        $item->job = $request->input('job');
        $item->acount_executive = $request->input('acount_executive');
        $item->acount_manager = $request->input('acount_manager');
        $item->finance_manager = $request->input('finance_manager');
        $item->payment_status = $request->input('payment_status');
        $item->jenis_pembayaran = $request->input('jenis_pembayaran');
        $item->term = $request->input('term');
        $item->pph23 = $request->input('pph23');
        $item->ppn = $request->input('ppn');
        $item->ppn_percent = $request->input('ppn_percent');
        $item->agency_fee = $request->input('agency_fee');
        $item->status = $request->input('status');
        $item->discount = $request->input('discount');
        $item->created_by = $request->input('created_by');
        
        if ($item->save()){ 

            if (!is_array($request->input('ratecard'))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Ratecard must be an array',
                ], 400);
            }

            foreach($request->input('ratecard') as $key => $value) {
                // $detail = new TransactionDetail;
                $detail[] = [
                    "trans_number" => $request->input('trans_number'),
                    "ratecard_id" => $value['ratecard_id'],
                    "ratecard_nominal" => $value['ratecard_nominal'],
                    "note" => $value['note'],
                    "business_type" => $value['business_type'],
                    "qty" => $value['qty'],
                    "created_by" => $request->input('created_by')
                ];
            }

            if($save = TransactionDetail::insert($detail)) {
                DB::commit();
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil',
                ], 200);
            } else {
                DB::rollback();
                return response()->json([
                    'status' => false,
                    'message' => 'Gagal',
                ], 401);  
            }
        } else {
            DB::rollback();
            return response()->json([
                'status' => false,
                'message' => 'Error',
            ], 400);
        }
        
    }

    public function update(Request $request, $id)
    {
         // Validate the incoming request data
         $this->validate($request, [
            'trans_number' => 'required|string',
            'customer' => 'required|string',
            'trans_date' => 'required|date',
            'person_in_charge' => 'required|string',
            'address' => 'required|string',
            'project' => 'required|string',
            'job' => 'required|string',
            'acount_executive' => 'required|string',
            'acount_manager' => 'required|string',
            'finance_manager' => 'required|string',
            'payment_status' => 'required|string',
            'jenis_pembayaran' => 'required|string',
            // 'term' => 'required|string',
            'pph23' => 'required|boolean', 
            'ppn' => 'required|boolean', 
            'ppn_percent' => 'nullable|numeric|min:0|max:100',
            'agency_fee' => 'required|string',
            // 'status' => 'required|string',
          
        ]);

        $item = TransactionHeader::findOrFail($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->trans_number = $request->input('trans_number');
        $item->customer = $request->input('customer');
        $item->trans_date = $request->input('trans_date');
        $item->person_in_charge = $request->input('person_in_charge');
        $item->address = $request->input('address');
        $item->project = $request->input('project');
        $item->job = $request->input('job');
        $item->acount_executive = $request->input('acount_executive');
        $item->acount_manager = $request->input('acount_manager');
        $item->finance_manager = $request->input('finance_manager');
        $item->payment_status = $request->input('payment_status');
        $item->jenis_pembayaran = $request->input('jenis_pembayaran');
        $item->term = $request->input('term');
        $item->pph23 = $request->input('pph23');
        $item->ppn = $request->input('ppn');
        $item->ppn_percent = $request->input('ppn_percent');
        $item->agency_fee = $request->input('agency_fee');
        $item->status = $request->input('status');
        $item->discount = $request->input('discount');
    
        if ($item->save()) {
            foreach ($request->input('ratecard') as $value) {
                if (isset($value['id']) && !empty($value['id'])) {
                    $detail = [
                        "trans_number" => $request->input('trans_number'),
                        "ratecard_id" => $value['ratecard_id'],
                        "ratecard_nominal" => $value['ratecard_nominal'],
                        "note" => $value['note'],
                        "business_type" => $value['business_type'],
                        "qty" => $value['qty'],
                        "updated_by" => $request->input('userid'),
                    ];
                    TransactionDetail::where('id', $value['id'])->update($detail);
                } else {
                    $newDetail = new TransactionDetail();
                    $newDetail->trans_number = $request->input('trans_number');
                    $newDetail->ratecard_id = $value['ratecard_id'];
                    $newDetail->ratecard_nominal = $value['ratecard_nominal'];
                    $newDetail->note = $value['note'];
                    $newDetail->business_type = $value['business_type'];
                    $newDetail->qty = $value['qty'];
                    $newDetail->created_by = $request->input('userid');
                    $newDetail->save();
                }
            }
    
            if ($request->has('deletedRatecards')) {
                foreach ($request->input('deletedRatecards') as $deletedId) {
                   
                    TransactionDetail::where('id', $deletedId)->update([
                        'deleted_by' => $request->input('userid') 
                    ]);

                    TransactionDetail::where('id', $deletedId)->delete();
                }
            }
    
            return response()->json(['message' => 'Data updated successfully'], 200);
        }
    
        return response()->json(['message' => 'Failed to update data'], 500);
    }

    public function edit($id)
     {
         $data = ['transaction_header' => $r->master_header];
             if (!($id = (new TransactionHeader)->edit($data , $r->id))) {
                 $this->return = array_merge((array)$this->return, [
                     'status' => false,
                     'message' => 'Gagal mengubah data',
                     'code' => 401
                 ]);
             }else{
                 $this->return = array_merge((array)$this->return, [
                     'data'  => $id
                 ]);
             } 
 
         return response()->json($this->return, $this->return['code']);
     }

     
     public function destroy($id)
{
    
    $item = TransactionHeader::find($id);

    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    $item->deleted_by = 'ADMIN';
    $item->save();
    $item->delete();

    TransactionDetail::where('trans_number', $item->trans_number)->update([
        'deleted_by' => 'ADMIN',
    ]);
    TransactionDetail::where('trans_number', $item->trans_number)->delete();

    return response()->json([
        'status' => true,
        'message' => 'Success delete data',
    ], 200);
}



    public function getData(Request $request)
    {
        $URL =  URL::current();

        if (!isset($request->search)) {
            $count = (new TransactionHeader)->count();
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = (new TransactionHeader)->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos =  (new TransactionHeader)->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }

        return response()->json(
            (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
            200
     );

   }   

   public function generateCode()
    {
        $romanMonth = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'];
        $kode =  '001';

        // $count = MasterCategories::count();
        $count = TransactionHeader::whereMonth('created_at', date('m'))
        ->withTrashed()
        ->count();

        if ($count > 0) {
            $kode = str_pad($kode + $count, 3, '0', STR_PAD_LEFT);
            return 'EX/' . $kode . '/' . $romanMonth[date('m')] . '/' . date('Y') . '/CS';
        } else {
            return 'EX/' . $kode . '/' . $romanMonth[date('m')] . '/' . date('Y') . '/CS';
        }
    }

    public function generatePDF()
    {
        ob_start();
        include base_path('public/docs/po.php');
        $html = ob_get_clean();
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        return response($dompdf->output(), 200)
        ->header('Content-Type','application/pdf')
        ->header('Content-Disposition','inline; filename="PO NAMA PERUSAHAAN.pdf"');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            \Log::info('Update status request received', [
                'id' => $id,
                'status' => $request->input('status'),
            ]);

            $this->validate($request, [
                'status' => 'required|integer|in:1,2',
            ]);

            $transaction = TransactionHeader::findOrFail($id);
            $transaction->status = $request->input('status');
            $transaction->save();

            \Log::info('Status updated successfully', [
                'id' => $id,
                'status' => $transaction->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Status updated successfully',
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Failed to update status', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Failed to update status: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saveRevision(Request $request)
    {
        $this->validate($request, [
            'transaction_number' => 'required|exists:transaction_header,trans_number',
            'revision_note' => 'required|string',
        ]);
    
        DB::beginTransaction();
    
        try {
            // Simpan data ke tabel revision
            DB::table('revision')->insert([
                'transaction_number' => $request->input('transaction_number'),
                'revision_note' => $request->input('revision_note'),
                'revision_date' => Carbon::now(), // Gunakan Carbon::now()
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
    
            // Update status di tabel transaction_header
            DB::table('transaction_header')
                ->where('trans_number', $request->input('transaction_number'))
                ->update(['status' => 3]);
    
            DB::commit();
    
            return response()->json([
                'status' => true,
                'message' => 'Revision saved successfully.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Failed to save revision: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    

}
