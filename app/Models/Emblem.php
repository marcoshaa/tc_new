<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emblem extends Model
{
    protected $table = "emblem";
    protected $fillable = [
        'name',
        'description',
        'img_route',
    ];
}
