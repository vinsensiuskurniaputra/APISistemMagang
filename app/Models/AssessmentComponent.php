<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailedAssessmentComponent;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentComponent extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    function detailedAssessmentComponents(){
        return $this->hasMany(DetailedAssessmentComponent::class);
    }
}
