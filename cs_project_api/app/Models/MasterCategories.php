<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterCategories extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'master_categories';
    protected $fillable = [
        'category_code',
        'category_name',
        'category_prefix',
        'category_status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = MasterCategories::select('*')
            ->whereRaw(" lower(category_name) like '%$search%' ")
            ->whereNull('deleted_by')
            ->offset($arr_pagination['offset'])->limit($arr_pagination['limit'])
            ->orderBy('category_name', 'ASC')
            ->get();
        return $data;
    }
}
