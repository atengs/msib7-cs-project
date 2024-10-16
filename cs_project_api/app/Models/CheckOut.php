<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckOut extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'check_out';
    protected $fillable = [
        'code_barang',
        'nama_barang',
        'kategori',
        'transaksi_date',
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
        $data = CheckOut::whereRaw("( 
        lower(nama_barang) like '%$search%' OR 
        lower(kategori) like '%$search%')
        AND deleted_by is NULL")
         ->select('id', 'code_barang', 'nama_barang', 'kategori', 'transaksi_date' )
         ->offset($arr_pagination['offset'])->limit($arr_pagination['limit']) 
         ->orderBy('id', 'ASC')->get();
         return $data;
    }
}
