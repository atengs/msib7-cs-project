<?php

namespace App\Models;

use DateTimeInterface;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocStatus extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'doc_statuses';
    // protected $fillable = ['name', 'code', 'desc',];
    protected $guarded = [];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = DocStatus::whereRaw("( 
        lower(name) like '%$search%' OR 
        lower(code) like '%$search%')
        AND deleted_by is NULL")
         ->select('id', 'name', 'code', 'desc' )
         ->offset($arr_pagination['offset'])->limit($arr_pagination['limit']) 
         ->orderBy('id', 'ASC')->get();
         return $data;
    }

}