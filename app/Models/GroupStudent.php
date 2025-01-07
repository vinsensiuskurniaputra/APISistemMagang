<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupStudent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function group(){
        return $this->belongsTo(GroupStudent::class);
    }

    public function student(){
        return $this->hasOne(Student::class);
    }
}
