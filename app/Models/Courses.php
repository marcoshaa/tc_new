<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courses extends Models
{
    protected $table = "courses";
    protected $fillable = [
        'name',
        'route',
        'teacher_code',
    ];
}
