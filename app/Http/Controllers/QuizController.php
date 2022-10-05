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
    public function standard(){
        $ajuda = Help::all();
        return json_encode($ajuda);        
    }

    public function creatStandard(Request $request){
        $ajuda = new Help;
        $ajuda->question = $request->question;
        $ajuda->answer = $request->answer;
        $ajuda->save();
        return response()->json([
            'question'  => $ajuda->question,
            'answer' => $ajuda->answer,
            'status'=> 'Ajuda cadastrada com sucesso'
        ],200);      
    }

    public function creatRequestHelp(Request $request){
        $ajuda = new RequestHelp;
        $ajuda->subject = $request->question;
        $ajuda->message = $request->answer;
        $ajuda->save();

        return response()->json([
            'subject'  => $ajuda->subject,
            'message' => $ajuda->message,
            'status'=> 'Pedido  de  ajuda cadastrada com sucesso'
        ],200);      
    }

    public function  responseForm(){
        
    }
}
