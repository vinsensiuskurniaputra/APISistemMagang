<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    
    protected $guarded = [
        'id',
    ];
    
    protected $fillable = [
        'lecturer_id', 
        'title', 
        'icon', 
        'color'
    ];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student');
    }
}
