<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderan extends Model
{
    //
    protected $table = 'orderan';
    protected $fillable = [
        'user_id',
        'pelanggan_id',
        'metode_pembayaran',
        'no_kendaraan',
        'merk',
        'catatan',
        'status'
    ];

    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])
            ->format('d-m-Y H:i');
    }

    public function getUpdatedAtAttribute()
    {
        if($this->attributes['updated_at']==null){

            return "-"; 
        }
        else{
            $tgl = \Carbon\Carbon::parse($this->attributes['updated_at'])
            ->format('d-m-Y H:i');
           return $tgl ;
        }
     
    }
}
