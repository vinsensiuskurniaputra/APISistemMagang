<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}
