<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = "spp";

    protected $fillable = [
        'year',
        'nominal'
    ];

    public function students()
    {
        return $this->hasMany('App\Models\Student');
    }
}
