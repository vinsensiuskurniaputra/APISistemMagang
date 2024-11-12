<?php

namespace App\Models;

use App\Models\AssessmentComponent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailedAssessmentComponent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function assessmentComponent()
    {
        return $this->belongsTo(AssessmentComponent::class);
    }
    
}
