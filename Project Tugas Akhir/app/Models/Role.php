<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    protected $table = 'roles';
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public static function isRole($check_role)
    {
        $user_roles = self::where([
            'user_id' => \Auth::user()->id,
            'roles' => $check_role
        ])
        ->first();

        return $user_roles ? true:false;
    }
}