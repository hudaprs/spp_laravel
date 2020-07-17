<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Student;

class Student extends Model
{
    protected $fillable = [
        'nisn',
        'nis',
        'name',
        'grade_id',
        'address',
        'phone',
        'spp_id',
    ];

    public function grade()
    {
        return $this->belongsTo('App\Models\Grade', 'grade_id');
    }

    public function spp()
    {
        return $this->belongsTo('App\Models\Spp', 'spp_id');
    }
}
