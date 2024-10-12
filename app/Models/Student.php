<?php

namespace App\Models;

use App\Models\User;
use App\Models\LogBook;
use App\Models\Guidance;
use App\Models\Industry;
use App\Models\Lecturer;
use App\Models\Assessment;
use App\Models\Internship;
use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];


    public function guidances(){
        return $this->hasMany(Guidance::class);
    }

    public function logBooks(){
        return $this->hasMany(LogBook::class);
    }

    public function internships(){
        return $this->hasMany(Internship::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function lecturer(){
        return $this->belongsTo(Lecturer::class);
    }

    public function studyProgram(){
        return $this->belongsTo(StudyProgram::class);
    }

    public function assessments(){
        return $this->hasMany(Assessment::class);
    }
}
