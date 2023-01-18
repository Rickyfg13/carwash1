<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gambar extends Model
{
    public $timestamps = false;
    protected $table = 'gambar';
    protected $fillable = ['orderan_id', 'path'];

    public function orderan()
    {
        return $this->belongsTo(Orderan::class, 'orderan_id', 'id');
    }

    public function getPathAttribute() {
        return url('/'.$this->attributes['path']);
    }
}
