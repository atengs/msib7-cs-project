<?php

namespace App\Models;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_detail'; 

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = $this->select('*')
            ->whereRaw("lower(ratecard_id) like '%" . $search . "%' OR lower(ratecard_nominal) like '%" . $search . "%'")
            ->limit($arr_pagination['limit'])
            ->offset($arr_pagination['offset'])
            ->orderBy('ratecard_nominal', 'asc')
            ->get();
        return $data;
    }
}
