<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RentangWarnaZona extends Model
{
    protected $table = 'rentang_warna_zona';
    protected $fillable = ['zona_id', 'nama', 'hexa_warna','awal', 'akhir'];
    protected $guarded = 'id';

    public function zona()
    {
        return $this->belongsTo('App\Models\Zona','zona_id');
    }
}