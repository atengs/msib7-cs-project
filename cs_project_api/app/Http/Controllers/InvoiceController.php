<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\PublicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Invoice::all();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ],200 );
    }

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
    
        // Ambil data invoice berdasarkan trans_number dari header
        $invoice = DB::table('invoice')
            ->where('trans_number', $header->trans_number)
            ->select('invoice_number', 'due_date')
            ->first();
    
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
    
        // Kembalikan response dengan header, invoice, dan details
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => [
                'header' => $header,
                'invoice' => $invoice, // Tambahkan data invoice
                'ratecards' => $details
            ]
        ], 200);
    }


    public function store(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            
            'due_date'       => 'required|string',
            'total_invoice'  => 'required|numeric|min:0',
            'created_by'     => 'required|string|max:255',
        ]);
        
       
        // Create a new invoice
        $save = Invoice::create([
            'invoice_number' => $this->generateCode(),
            'trans_number'   => $request->post('trans_number'),
            'due_date'       => $request->post('due_date'),
            'total_invoice'  => $request->post('total_invoice'),
            'created_by'     => $request->post('created_by'),
        ]);

        if ($save) {
            return response()->json([
                'status'  => true,
                'message' => 'Berhasil menyimpan data',
                'data'    => $save,
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menyimpan data',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
       
    }

    public function edit($id)
     {
       
     }

     public function getData(Request $request)
    {
        $URL =  URL::current();

        if (!isset($request->search)) {
            $count = (new Invoice)->count();
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = (new Invoice)->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos =  (new Invoice)->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }

        return response()->json(
            (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
            200
        );

     }    

     public function generateCode()
    {
        // Definisikan bulan dalam angka Romawi
        $romanMonth = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V',
            6 => 'VI', 7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 
            11 => 'XI', 12 => 'XII'
        ];

        // Hitung jumlah record dalam tabel Invoice berdasarkan bulan saat ini
        $currentMonth = date('m');
        $currentYear = date('Y');

        $count = Invoice::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        // Increment kode berdasarkan jumlah record
        $kode = $count + 1;

        // Format kode menjadi string
        return sprintf(
            "%d/%s/%d/CS",
            $kode,
            $romanMonth[(int)$currentMonth],
            $currentYear
        );
    }


}
