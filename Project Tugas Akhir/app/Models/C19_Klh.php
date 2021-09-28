<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class C19_Klh extends Model
{
    protected $table = 'klh_cvd';
    protected $fillable = ['id_kelurahan', 'kontak_erat', 'suspek', 'positif', 'positif_isolasi', 'meninggal','color', 'tgl'];
    protected $guarded = 'id';

    public function kelurahan()
    {
        return $this->belongsTo('App\Models\Kelurahan', 'id_kelurahan');
    }
}