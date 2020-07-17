<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Role extends Model
{
    protected $fillable =[
        'name'
    ];

    /**
     * Set format date
     */
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('m-d-Y H:i:s');
    }

    /**
     * Relation to users
     */
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }
}
