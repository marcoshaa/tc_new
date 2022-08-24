<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\User;


class ApiUserController extends Controller
{
    use RegistersUsers;
    

    public function index(Request $request){
        $rules = [
            'name'     =>['required','string','max:240'],
            'email'    =>['required','string','email','max:255','unique:users'],
            'password' =>['required','string','min:6','max:6'],
            'level' =>['required','string','max:2'],
        ];

        $validacao = Validator::make($request->all(),$rules);

        if($validacao->fails()){
            return response()->json(['erro'=> $validacao->messages()],200);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'level'     => $request->level,
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
            'password' => Hash::make($request->password),
        ]);
        return response()->json('Perfil Atualizado');
    }
}
