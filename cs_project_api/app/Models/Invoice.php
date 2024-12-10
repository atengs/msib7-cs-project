<?php

namespace App\Models;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    protected $table = 'invoice'; 
    use SoftDeletes; 

    protected $fillable = [
        'invoice_number',
        'trans_number',
        'due_date',
        'total_invoice',
        'created_by',
    ];

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = $this->select('*')
            ->whereRaw("lower(trans_number) like '%" . $search . "%' OR lower(total_invoice) like '%" . $search . "%'")
            ->limit($arr_pagination['limit'])
            ->offset($arr_pagination['offset'])
            ->orderBy('total_invoice', 'asc')
            ->get();
        return $data;
    }
}
