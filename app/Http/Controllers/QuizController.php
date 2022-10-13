<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Help;
use App\Models\RequestHelp;
use App\Models\Answer;
use App\Models\Quiz;
use App\Models\Log;
Use DB;

class QuizController extends Controller
{
    public function standard(){
        $ajuda = Help::all();
        return json_encode($ajuda);        
    }

    public function creatStandard(Request $request){
        $ajuda = new Help;
        $ajuda->id_user = $request->id_user;
        $ajuda->question = $request->question;
        $ajuda->answer = $request->answer;
        $ajuda->save();
        $newLog = new Log;
        $newLog->title = 'Duvidas Frequentes';
        $newLog->mensage = 'Foi criado um pedido de suporte ('.$ajuda->id.') pelo user id ('.$ajuda->id_user.'), com a seguinte mensagem ('.$ajuda->question.')';
        $newLog->save();
        return response()->json([
            'question'  => $ajuda->question,
            'answer' => $ajuda->answer,
            'status'=> 'Ajuda cadastrada com sucesso'
        ],200);      
    }

    public function creatRequestHelp(Request $request){
        $ajuda = new RequestHelp;
        $ajuda->id_user = $request->id_user;
        $ajuda->subject = $request->subject;
        $ajuda->message = $request->message;
        $ajuda->save();
        $newLog = new Log;
        $newLog->title = 'Pedido de Suporte';
        $newLog->mensage = 'Foi criado um pedido de suporte ('.$ajuda->id.') pelo user id ('.$ajuda->id_user.'), com a seguinte mensagem ('.$ajuda->message.')';
        $newLog->save();
        return response()->json([
            'subject'  => $ajuda->subject,
            'message' => $ajuda->message,
            'status'=> 'Pedido  de  ajuda cadastrada com sucesso'
        ],200);      
    }

    //Respostas recebidas.
    public function  responseForm(Request $request){
        $questao = new Answer;
        $questao->id_user = $request->id_user;
        $questao->id_questao = $request->id_questao;
        //tratativa do acerto, fazer em uma função a parte
        
        $questao->nota = $request->nota;
        return json_encode('Resposta salva com sucesso'); 
    }

    public function creatQuiz(Request $request){
        $quiz = new Quiz;
        $quiz->id_courses = $request->id_courses;
        $quiz->id_teacher = $request->id_teacher;
        $quiz->id_matter = $request->id_matter;
        $quiz->title = $request->title;
        $quiz->alternative_1 = $request->alternative_1;
        $quiz->alternative_2 = $request->alternative_2;
        $quiz->alternative_3 = $request->alternative_3;
        $quiz->alternative_4 = $request->alternative_4;
        $quiz->answer = $request->answer;
        if(!empty($quiz)){
            $quiz->save();
            $log = new Log;
            $log->title = 'Criação de questionário';
            $log->mensage = 'Foi criado a questão de id ('.$quiz->id.') para o curso de id ('.$quiz->id_courses.') pelo usuário de id ('.$quiz->id_teacher.')';

            return json_encode('sucess');
        }
        
        return json_encode('erro');
    }
}
