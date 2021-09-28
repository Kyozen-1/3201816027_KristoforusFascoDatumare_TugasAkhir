<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RS_Data extends Model
{
    protected $table = 'data_rs';
    protected $fillable = ['id_rs','k_icu', 'jlh_tmpt_icu', 'k_isolasi', 'jlh_tmpt_positif', 'jlh_tmpt_suspek', 'tgl'];
    protected $guarded =  'id';

    public function rs()
    {
        return $this->belongsTo('App\Models\RS', 'id_rs');
    }
}