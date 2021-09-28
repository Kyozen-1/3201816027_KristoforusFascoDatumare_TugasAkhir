<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $table = 'zona';
    protected $fillable = ['nama'];
    protected $guarded = 'id';

    public function rentangwarnazona()
    {
        return $this->hasMany('App\Models\RentangWarnaZona','zona_id');
    }
}