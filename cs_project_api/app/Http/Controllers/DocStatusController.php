<?php

namespace App\Http\Controllers;

use App\Models\DocStatus;
use App\Models\PublicModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\{Request, JsonResponse};

use illuminate\Support\str;
use Carbon\Support\Carbon;
use Exception;

use illuminate\Support\Facades\URL;


class DocStatusController extends Controller
{   

    protected $judul_halaman_notif;
    public function __construct()
    {
        $this->judul_halaman_notif = "DOC STATUS";
    }

    public function paging(Request $request):JsonResponse
    {
        $URL = URL::current();
        if (!isset($request->search)) {
            $count= ( new DocStatus())->count();
            $arr_pagination = (new PublicModel())->pagination_without_search($URL, $request->limit, $request->offset);
            $todos = ( new DocStatus())->get_data_($request->search, $arr_pagination);
        } else {
            $arr_pagination = (new PublicModel())->pagination_without_search($URL, $request->limit, $request->offset, $request->search);
            $todos = ( new DocStatus())->get_data_($request->search, $arr_pagination);
            $count = $todos->count();
        }
        return response()->json(
            (new PublicModel())->array_respon_200_table($todos,$count,$arr_pagination),
            200
        );

     }
    

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();
        $user_id = 'USER TEST';
        $data = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'desc' => 'required',
        ]);
        try {
            $data['created_by'] = $user_id;
            $todos = DocStatus::create($data);
            DB::commit();
            return response()->json([
                'code' => '200',
                'status' => true,
                'message' => 'created successfully'
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 409,
                'status' => false,
                'message' => 'failed created data',
            ], 409);
        }
    }


    public function storebulky(Request $request): JsonResponse
    {
        DB::beginTransaction();

        $user_id = $request->user_id;
        try {
            // $data_csv= json_decode(json_encode($request->csv), true);
            $data_csv = $request->csv;
            foreach ($data_csv as $value)  {
            $data = [];
            $data['name'] = $value['name'];
            $data['code'] = $value['code'];
            $data['desc'] = $value['desc'];
            $data['created_by'] = $user_id;
            $data['updated_by'] = $user_id;
            $todos = DocStatus::create($data);
            }

            DB::commit();
            return response()->json([
                'code' => '201',
                'status' => true,
                'message' => 'created successfully.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => '409',
                'status' => false,
                'message' => 'created failed',
                'e' => $e
            ], 409);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $todos = DocStatus::findOrFail($id);
            return response()->json([
                'code' => '200',
                'status' => true,
                'data' => $todos
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 409,
                'status' => false,
                'message' => 'failed get data',

            ], 409);
        }
    }

    public function update(Request $request, int $id)
    {
        DB::beginTransaction();
        $user_id = 'USER TEST';
        $data = $this->validate($request, [
            'name' => 'required',
            'code' => 'required',
            'desc' => 'required',
            
        ]);
        try {
            $data['updated_by'] = $user_id;
            $todo = DocStatus::findOrFail($id);
            $todo->fill($data);
            $todo->save();
            $todo->update(['updated_by' => $user_id]);
            DB::commit();
            return response()->json([
                'code' => '200',
                'status' => true,
                'message' => 'successfully update'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 409,
                'status' => false,
                'message' => 'failed updated data',
            ], 409);
        }
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        DB::beginTransaction();
        $user_id = "USER TEST";
        try {
            $todo = DocStatus::findOrFail($id);
            DocStatus::where('id', $id)->update(['deleted_by' => $user_id]);
            $todo->delete();
            DB::commit();
            return response()->json([
                'code' => '200',
                'status' => true,
                'message' => 'deleted successfully'
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'code' => 409,
                'status' => false,
                'message' => 'failed delete',
            ], 409);
        }
    }








    
}
