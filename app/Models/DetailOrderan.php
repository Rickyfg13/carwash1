<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailOrderan extends Model
{
    //
    public $timestamps = false;
    protected $table = 'detail_orderan';
    protected $fillable = [
        'orderan_id',
        'layanan_id',
        'layanan_detail',
        'harga'
    ];
}
