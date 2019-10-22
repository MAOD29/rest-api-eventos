<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login(Request $request)
    {
     
       if (! Request()->isJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }
        
       $rules = [
            "password" => "required",
            'email' => 'required',
        ];

        $this->validate(Request(),$rules);


        $user = User::where('email', $request->email)->first();
        if(is_null($user)){
            return response()->json(['error' => 'Usuario no existe'], 404);
        }
        if (! $user && Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'error de credenciales'], 401);
        }

        $user['token'] =  $user->createToken('MyApp')->accessToken;
        return response()->json($user, 200);
       

    }
    public function register(){
         if (! Request()->isJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }
        $this->validate(Request(),User::$rules);
        
        Request()->merge(['role_id' => '2']);


        $user = User::create(Request()->all());
        $user['token'] =  $user->createToken('MyApp')->accessToken;
        return response()->json($user, 201);
    }

  
}
