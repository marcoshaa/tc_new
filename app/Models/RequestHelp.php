<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestHelp extends Model
{
    protected $table = "request_help";
    protected $fillable = [
        'subject',
        'message',
    ];
}
