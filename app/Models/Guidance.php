<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Guidance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public const STATUSES = ['approved', 'rejected', 'in-progress', 'updated'];

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
