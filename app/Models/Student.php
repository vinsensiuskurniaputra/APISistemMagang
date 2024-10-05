<?php

namespace App\Models;

use App\Models\User;
use App\Models\LogBook;
use App\Models\Guidance;
use App\Models\Industry;
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

    public function industries(){
        return $this->hasMany(Industry::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
