<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class C19_Ptk extends Model
{
    protected $table = 'c19_ptk';
    protected $fillable = ['di_rs', 'probable', 'discarded', 'isolasi', 'sembuh', 'meninggal', 'tgl'];
    protected $guarded = 'id';
}