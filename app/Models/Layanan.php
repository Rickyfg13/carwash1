<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    //
    public $timestamps = false;
    protected $table = 'layanan';
    protected $fillable = [
        'nama_layanan'
    ];
}
