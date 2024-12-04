<?php

namespace App\Models;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    protected $table = 'revision'; 
    use SoftDeletes; 

    protected $fillable = [
        'transaction_number',
        'revision_note',
        'revision_date',
    ];

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = $this->select('*')
            ->whereRaw("lower(transaction_number) like '%" . $search . "%' OR lower(revision_note) like '%" . $search . "%'")
            ->limit($arr_pagination['limit'])
            ->offset($arr_pagination['offset'])
            ->orderBy('revision_note', 'asc')
            ->get();
        return $data;
    }
}
