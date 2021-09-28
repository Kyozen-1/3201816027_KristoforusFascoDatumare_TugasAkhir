<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatan';
    protected $fillable = ['nama', 'kord'];
    protected $guarded = 'id';

    public function kelurahan()
    {
        return $this->hasMany('App\Models\Kelurahan','id_kecamatan');
    }
}