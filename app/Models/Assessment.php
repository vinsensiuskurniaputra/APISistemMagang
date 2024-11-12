<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetailedAssessmentComponent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assessment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function detailedComponent()
    {
        return $this->belongsTo(DetailedAssessmentComponent::class);
    }

}
