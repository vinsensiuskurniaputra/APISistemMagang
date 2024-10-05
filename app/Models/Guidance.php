<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guidance extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public const STATUSES = ['approved', 'rejected', 'in-progress', 'updated'];
}
