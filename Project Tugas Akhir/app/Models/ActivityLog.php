<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ActivityLog extends Model
{
    use LogsActivity;
    protected $table = 'activity_log';
    public function user()
    {
        return $this->belongsTo('App\User', 'causer_id');
    }
}