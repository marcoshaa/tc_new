<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = "quiz";
    protected $fillable = [
        'title',
        'alternative_1',
        'alternative_2',
        'alternative_3',
        'alternative_4',
        'answer',
    ];
}
