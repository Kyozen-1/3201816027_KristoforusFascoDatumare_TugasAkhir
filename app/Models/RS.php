<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RS extends Model
{
    protected $table = 'rs';
    protected $fillable = ['nama', 'lng', 'lat'];
    protected $guarded = 'id';

    public function data_rs()
    {
        return $this->hasOne('App\Models\RS_Data', 'id_rs');
    }
}