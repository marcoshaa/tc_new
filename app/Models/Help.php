<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Help extends Model
{
    protected $table = "doubt_of_help";
    protected $fillable = [
        'question',
        'answer',
    ];
}
