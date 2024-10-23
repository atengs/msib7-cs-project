<?php

namespace App\Models;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionHeader extends Model
{
    use SoftDeletes;
    protected $table = 'transaction_header'; 

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = $this->select('*')
            ->whereRaw("(lower(customer) like '%" . $search . "%' OR lower(payment_status) like '%" . $search . "%')")
            ->whereNull('deleted_at')
            ->limit($arr_pagination['limit'])
            ->offset($arr_pagination['offset'])
            ->orderBy('payment_status', 'asc')
            ->get();
        return $data;
    }
}
