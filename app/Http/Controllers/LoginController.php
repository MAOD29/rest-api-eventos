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

        $validator = Validator::make(Request()->all(),$rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);   
        }

        try {

            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                    return response()->json($user, 200);
            } else {
                    return response()->json(['error' => 'error de credenciales'], 401);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No content'], 406);
        }

    }
    public function register(Request $request){
         if (! Request()->isJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }

        $validator = Validator::make(Request()->all(),User::$rules);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);   
        }
       
        Request()->merge(['api_token' => Str::random(60)]);
        Request()->merge(['role_id' => '2']);


        $user = User::create(Request()->all());
        return response()->json($user, 201);
    }

  
}
