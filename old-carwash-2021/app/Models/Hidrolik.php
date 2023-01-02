<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hidrolik extends Model
{
    //
    public $timestamps = false;
    protected $table = 'hidrolik';
    protected $fillable = [
        'keterangan'
    ];
}
