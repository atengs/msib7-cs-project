<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRatecard extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'master_ratecard';
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

    public function get_data_($search, $arr_pagination, $category_code = null)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
    
        // Mulai query utama dengan select dan join
        $data = MasterRatecard::select('master_ratecard.*', 'master_categories.category_name', 'master_job_categories.job_category_name')
            ->join('master_categories', 'master_categories.category_code', '=', 'master_ratecard.category_code')
            ->join('master_job_categories', 'master_job_categories.job_category_code', '=', 'master_ratecard.job_category_code')
            ->where(function ($query) use ($search) {
                $query->whereRaw("LOWER(master_ratecard.job_description) LIKE ?", ["%$search%"])
                      ->orWhereRaw("LOWER(master_categories.category_name) LIKE ?", ["%$search%"]);
            });
    
        // Jika `category_code` ada, tambahkan filter
        if ($category_code) {
            $data->where('master_ratecard.category_code', $category_code);
        }
    
        // Tambahkan kondisi untuk mengabaikan deleted_by
        $data = $data->whereNull('master_ratecard.deleted_by')
            ->offset($arr_pagination['offset'])
            ->limit($arr_pagination['limit'])
            ->orderBy('job_description', 'ASC')
            ->get();
    
        return $data;
    }
    
    
}
