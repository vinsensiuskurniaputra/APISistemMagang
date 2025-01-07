<?php

namespace App\Models;

use App\Models\User;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lecturer extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function students() {
        return $this->hasMany(Student::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class);
    }
}
