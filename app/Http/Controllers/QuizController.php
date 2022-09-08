<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Help;
use App\Models\RequestHelp;
Use DB;

class QuizController extends Controller
{
    public function standard(Request $request){
        $ajuda = Help::all();
        
        
    }
}
