<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'kelurahan';
    protected $fillable = ['id_kecamatan','nama', 'kord'];
    protected $guarded = 'id';

    public function kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan','id_kecamatan');
    }

    public function klh_cvd()
    {
        return $this->hasOne('App\Models\C19_Klh', 'id_kelurahan');
    }
}