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
                'birth'     => $request->birth
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
        return response()->json('Perfil Atualizado');
    }

    public function allTeacher(){
        $professor = User::where('occupation','=','teacher')->get();
        return response()->json($professor);
    }

    public function selectTeacher(Request $request){
        $professor = User::where('id','=',$request->id_teacher)->where('occupation','=','teacher')->first();
        if(empty($professor)){
            $professor='Professor não localizado';
        }
        return response()->json($professor);
    }
    
}
