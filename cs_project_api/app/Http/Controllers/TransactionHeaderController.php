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
        $header = TransactionHeader::whereNull('deleted_at')
            ->where('id', $id)
            ->first();
    
        if (!$header) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found',
            ], 404);
        }
    
        $details = TransactionDetail::select('transaction_detail.id', 'mr.job_description', 'ratecard_id', 'ratecard_nominal', 'note')
            ->join('master_ratecard as mr', 'mr.id', '=','transaction_detail.ratecard_id')
            ->where('trans_number', $header->trans_number)
            ->get();
    
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
            'payment_status' => 'required|string',
            'person_in_charge' => 'required|string',
            'address' => 'required|string',
            'project' => 'required|string',
            'job' => 'required|string',
            'acount_executive' => 'required|string',
            'acount_manager' => 'required|string',
            'finance_manager' => 'required|string',
            
        ]);
        
        $item = new TransactionHeader;
 
        $item->trans_number = $request->input('trans_number');
        $item->customer = $request->input('customer');
        // $item->trans_date = $request->input('trans_date');
        $item->trans_date = date('Y-m-d');
        $item->payment_status = $request->input('payment_status');
        $item->person_in_charge = $request->input('person_in_charge');
        $item->address = $request->input('address');
        $item->project = $request->input('project');
        $item->job = $request->input('job');
        $item->acount_executive = $request->input('acount_executive');
        $item->acount_manager = $request->input('acount_manager');
        $item->finance_manager = $request->input('finance_manager');
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
            'payment_status' => 'required|string',
            'person_in_charge' => 'required|string',
            'address' => 'required|string',
            'project' => 'required|string',
            'job' => 'required|string',
            'acount_executive' => 'required|string',
            'acount_manager' => 'required|string',
            'finance_manager' => 'required|string',
        ]);

        // Find the item by ID
        $item = TransactionHeader::findOrFail($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->trans_number = $request->input('trans_number');
        $item->customer = $request->input('customer');
        $item->trans_date = $request->input('trans_date');
        $item->payment_status = $request->input('payment_status');
        $item->person_in_charge = $request->input('person_in_charge');
        $item->address = $request->input('address');
        $item->project = $request->input('project');
        $item->job = $request->input('job');
        $item->acount_executive = $request->input('acount_executive');
        $item->acount_manager = $request->input('acount_manager');
        $item->finance_manager = $request->input('finance_manager');

        // Save the updated item
        if ($item->save()) {if (!is_array($request->input('ratecard'))) {
            return response()->json([
                'status' => false,
                'message' => 'Ratecard must be an array',
            ], 400);
        }

        foreach($request->input('ratecard') as $key => $value) {
            // $detail = new TransactionDetail;
            $detail = [
                "trans_number" => $request->input('trans_number'),
                "ratecard_id" => $value['ratecard_id'],
                "ratecard_nominal" => $value['ratecard_nominal'],
                "note" => $value['note'],
                "created_by" => $request->input('created_by')
            ];
            $save = TransactionDetail::where('id', $value['id'])->update($detail);
        }

        if($save) {
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

    // Pastikan data ditemukan
    if (!$item) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    // Tandai sebagai soft delete dan isi kolom deleted_by
    $item->deleted_by = 'ADMIN'; // Ganti dengan user yang sedang login
    $item->save();

    // Lakukan soft delete
    $item->delete();

    // Hapus juga transaction_detail yang terkait secara soft delete
    TransactionDetail::where('trans_number', $item->trans_number)->update([
        'deleted_by' => 'ADMIN', // Ganti dengan user yang sedang login
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

}
