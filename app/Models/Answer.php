<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = "resposta";
    protected $fillable = [
        'id_user',
        'id_questao',
        'nota',
    ];
}
