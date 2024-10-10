<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterJoblist extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'master_joblists';
    protected $fillable = [
        'category_code',
        'job_category_code',
        'job_description',
        'ratecard',
        'remarks',
        'status',
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
        $data = MasterJoblist::select('master_joblists.*','master_categories.category_name', 'master_job_categories.job_category_name')
            ->join('master_categories','master_categories.category_code','=','master_joblists.category_code')
            ->join('master_job_categories','master_job_categories.job_category_code','=','master_joblists.job_category_code')
            ->whereRaw(" lower(master_joblists.job_description) like '%$search%' ")
            ->whereNull('master_joblists.deleted_by')
            ->offset($arr_pagination['offset'])->limit($arr_pagination['limit'])
            ->orderBy('job_description', 'ASC')
            ->get();
        return $data;
    }
}
