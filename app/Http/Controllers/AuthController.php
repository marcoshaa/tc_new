<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use JWTAuth;
use Exception;
use Hash;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Authenticatable implements JWTSubject
{
    

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
        $credentials = $request->only('email', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        $user = User::where('email','=',$request->email)->first();
        return json_encode([$token,$user]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    
    public function getJWTIdentifier() 
    { 
        
        return $this->getKey(); 
        
    }

    public function getJWTCustomClaims() 
    { 
        return []; 
    }
}