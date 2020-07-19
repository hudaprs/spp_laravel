<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'date',
        'month',
        'year',
        'spp_id',
        'amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Models\Student', 'student_id');
    }

    public function spp()
    {
        return $this->belongsTo('App\Models\Spp', 'spp_id');
    }
}
