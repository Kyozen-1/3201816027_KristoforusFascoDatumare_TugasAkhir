<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'colors';
    protected $fillable = ['nama', 'color', 'keterangan'];
    protected $guarded = 'id';
}