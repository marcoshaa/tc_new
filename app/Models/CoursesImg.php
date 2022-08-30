<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesImg extends Model
{
    protected $table = "courses_img";
    protected $fillable = [
        'id_courses',
        'route',
    ];
}
