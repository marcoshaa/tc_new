<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\User\UserResource;
use App\Transformers\User\UserResourceCollection;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Services\ResponseService;
use Illuminate\Support\Facades\Auth;
use App\Models\Answer;
use App\Models\Log;

class UserController extends Controller
{

    public function index(Request $request){
        $rules = [
            'name'      =>['required','string','max:240'],
            'email'     =>['required','string','email','max:255','unique:users'],
            'password'  =>['required','string','min:6','max:6'],
            // 'occupation'=>['required','string'],
        ];

        $validacao = Validator::make($request->all(),$rules);

        if($validacao->fails()){
            return response()->json(['erro'=> $validacao->messages()],200);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'username'  => $request->username,
                'email'     => $request->email,
                'city'      => $request->city,
                'email'     => $request->email,
                'bio'       => $request->bio,
                'password'  => Hash::make($request->password),
                'occupation'=> $request->occupation,
                'birth'     => $request->birth,
                'cor'       => $request->cor
            ]);
            if(!empty($user)){
                return response()->json([
                    'name'  => $user->name,
                    'email' => $user->email,
                    'token' => $user->createToken('Token Name')->accessToken,
                    'status'=> 'Cadastro realizado com sucesso'
                ],200);
            }
        }
    }

    public function updateProfile(Request $request){        
        
        $rules = [
            'name'     =>['required','string','max:240'],
            'email'    =>['required','string','email','max:255','unique:users'],
            'birth'    =>['required','date']
        ];
        
        $user = User::where('email','=',$request->email)->update([
            'name'     => $request->name,
            'birth'    => $request->birth,
            'bio'      => $request->bio,
            'city'     => $request->city,
            'username' => $request->username,
        ]);
        if($user == 0){
            $x ="Erro na Atualiza????o";
        }else{
            $x ="Sucesso na Atualiza????o";
        }
        return json_encode($x);
    }

    public function allTeacher(){
        $professor = User::where('occupation','=','teacher')->get();
        return response()->json($professor);
    }

    public function selectTeacher(Request $request){
        $professor = User::where('id','=',$request->id_teacher)->where('occupation','=','teacher')->first();
        if(empty($professor)){
            $professor='Professor n??o localizado';
        }
        return response()->json($professor);
    }

    public function alunos(){
        $alunos = User::where('occupation','=','student')->get();
        $x = array();
        $x[0] = $alunos;
        $x[1] = 'todos alunos';
        return json_encode($x);
    }

    public function alunosHistorico(Request $request){
        $historico = Answer::where('id_user','=',$request->id)->get();
        $x = array();
        $x[0] = $historico;
        if(!empty($historico)){
            $x[1]="Historico localizado";
        }else{
            $x[1]="Historico do aluno n??o localizado";
        }
        return json_encode($x);
    }

    public function logAdm(){
        $log = Log::all();
        return json_encode($log);
    }    

    public function allUser(){
        $user = User::all();
        $y=array();
        foreach($user as $use){
            $y[] = array(
                'id' =>$use->id,
                'name' =>$use->name,
                'email' =>$use->email,
                'cor' =>$use->cor,
                'occupation' =>$use->occupation,
            );
        }
        $user1 = User::where('occupation','=','student')->count();
        $user2 = User::where('occupation','=','teacher')->count();
        $user3 = User::where('occupation','=','adm')->count();
        $y[] = array(
            'Alunos' => $user1,
            'Professor' => $user2,
            'ADM' => $user3,
        );
        return json_encode($y);
    }
}
