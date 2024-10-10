<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterJobCategory extends Model
{
    protected $table = 'master_job_categories';
    protected $fillable = [
        'job_category_code',
        'job_category_name',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
