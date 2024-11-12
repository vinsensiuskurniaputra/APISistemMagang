<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Student;
use App\Models\Lecturer;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const ROLES = [
        "Lecturer" => "Lecturer",
        "Student" => "Student"
    ];

    protected $guarded = [
        'id',
    ];

    public function student(){
        return $this->hasOne(Student::class);
    }

    public function lecturer(){
        return $this->hasOne(Lecturer::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}
