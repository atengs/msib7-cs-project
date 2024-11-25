<?php

namespace App\Models;

use illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterRatecardStandard extends Model
{
    protected $table = 'master_ratecard_standard';

    protected $fillable = [
        'ratecard_id',
        'cost',
    ]; 

    

    public function get_data_($search, $arr_pagination)
    {
        if (!empty($search)) $arr_pagination['offset'] = 0;
        $search = strtolower($search);
        $data = $this->select('*')
            ->whereRaw("lower(ratecard_id) like '%" . $search . "%' OR lower(cost) like '%" . $search . "%'")
            ->limit($arr_pagination['limit'])
            ->offset($arr_pagination['offset'])
            ->orderBy('cost', 'asc')
            ->get();
        return $data;
    }
}
