<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use App\Models\User;

class UserController extends Controller
{
    use RegistersUsers;

    public function index(Request $request){
        $rules = [
            'name'     =>['required','string','max:240'],
            'email'    =>['required','string','email','max:255','unique:users'],
            'password' =>['required','string','min:6'],
        ];

        $validacao = Validator::make($request->all(),$rules);

        if($validacao->fail()){
            return response()->json(['erro'=> $validacao->messages()],200);
        }else{
            $user = User::create([
                'name'      => $request->name,
                'email'     => $request->email,
                'password'  => Hash::make($request->password)
            ]);

            if(!empty($user)){
                return response()->json([
                    'name'  => $user->name,
                    'email' => $user->email,
                    'token' => $user->createToken('Token Name')->accessToken
                ],200);
            }
        }
    }

    public function update(Request $request){
        
        $user = User::where('id','=',$request->id)->first();

    }
}
