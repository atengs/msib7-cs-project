<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use App\Models\PublicModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class RevisionController extends Controller
{
    public function index()
    {
        $data = Revision::all();
        return response()->json([
            'status' => true,
            'message' => 'Berhasil',
            'data' => $data
        ],200 );
    }

    public function store (Request $request)
    {

        $this->validate($request, [
            'transaction_number' => 'required',
            
        ]);

        $item = new Revision;
        $item->transaction_number = $request->input('transaction_number');
        $item->revision_note = $request->input('revision_note');

        if ($item->save()){
            return response()->json([
                'status' => true,
                'message' => 'Berhasil',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Failed',
            ], 400);    
        }
        
    }

    public function update(Request $request, $id)
    {
         // Validate the incoming request data
         $this->validate($request, [

            'trans_number' => 'required',
            'ratecard_id' => 'required',
            'ratecard_nominal' => 'required',   
            'note' => 'required|string',
            'business_type' => 'required',

        ]);

        // Find the item by ID
        $item = Revision::findOrFail($id);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        $item->trans_number = $request->input('trans_number');
        $item->ratecard_id = $request->input('ratecard_id');
        $item->ratecard_nominal = $request->input('ratecard_nominal');
        $item->note = $request->input('note');
        $item->business_type = $request->input('business_type');
        $item->qty = $request->input('qty');

        // Save the updated item
        if ($item->save()) {
            return response()->json(['message' => 'Item updated successfully'], 200);
        }

        return response()->json(['message' => 'Failed to update item'], 500);

    }

    public function destroy($id)
    {
        // Find the item by ID
        $item = Revision::findOrFail($id);

        // Check if the item exists
        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Delete the item
        if ($item->delete()) {
            return response()->json(['message' => 'Item deleted successfully'], 200);
        }

        // If delete fails, return an error
        return response()->json(['message' => 'Failed to delete item'], 500);
    }

    public function edit($id)
     {
         $data = ['transaction_detail' => $r->transaction_detail];
             if (!($id = (new Revision)->edit($data , $r->id))) {
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

     public function getData(Request $request)
    {
        $URL =  URL::current();

        if (!isset($request->search)) {
            $count = (new Revision)->count();
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = (new Revision)->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel)->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos =  (new Revision)->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }

        return response()->json(
            (new PublicModel())->array_respon_200_table($todos, $count, $arr_pagination),
            200
     );

   }   

}
