<?php

namespace App\Models;

use App\Models\Lecturer;
use App\Models\GroupStudent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }
    
    public function groupStudents(){
        return $this->hasMany(GroupStudent::class);
    }
}
