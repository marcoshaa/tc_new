<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = "courses";
    protected $fillable = [
        'name',
        'teacher_code',
        'status',
    ];
}
