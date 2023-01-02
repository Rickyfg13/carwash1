<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    //
    protected $table = 'pelanggan';
    protected $fillable = [
        'nama',
        'nohp'
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
