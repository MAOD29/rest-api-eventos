<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('auth:api',['except' => ['store']]);
        //$this->middleware('roles:admin',['except' => ['show','index']]);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Request()->expectsJson()) {
            return response()->json(['message' => 'No json'], 401, []);
        }
      
        $user = Request()->user();
        if (! $user->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 401, []);
        }
       
        $data = User::paginate(10);
        return Response()->json($data, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
        if (! Request()->isJson()) {
            return response()->json(['message' => 'no json'], 401);
        }
        $this->validate(Request(),User::$rules);
        $user = User::create(Request()->all());
        return response()->json(['message' => 'ok', 'data' => $user], 201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        if (! Request()->isJson()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {

            $this->authorize('view',$user);
            return Response()->json($user, Response::HTTP_OK);
           
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'No content'], 406);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        //
        if (! Request()->isJson()) {
            return response()->json(['message' => 'No json'], 401);
        }

        $this->validate(Request(),User::$rules);

       
            $this->authorize('view',$user);
            $user->update(Request()->all());
            return response()->json(['message' => 'ok', 'data' => $user], 200);

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        
        if (! Request()->isJson()) {
            return response()->json(['error' => 'No json'], 401, []);
        }

        $this->authorize('view',$user);
        $user->delete();
        return response()->json($user, 200);
       
    }

    public function getAllBusinessForUser()
    {
        return $this->getAllForUser('business','Business',Request()->user());
    }
    public function getAllEventsForUser()
    {
       return $this->getAllForUser('events','Eventos',Request()->user());
    }


    public function getAllForUser($type,$folderName,$user){

        if (!Request()->isJson()) {
            return response()->json(['message' => 'no es json'], 401);
        }
        $this->authorize('view',$user);

        try {
            $user->$type->map(function ($item) use($folderName){

                $item->image =  asset("storage/$folderName/$item->image"); 
                
            });
            return response()->json( $user->$type, 200);

        } catch (ModelNotFoundException $e) { 
            return response()->json(['error' => 'No content'], 406);
        }
    }

}
