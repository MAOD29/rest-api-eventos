<?php

namespace App\Http\Controllers;

use App\Business;
use App\Typebusiness;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    const MODEL = "App\Business";
    const FOLDER = "Business";
    use ApiResource;

    function __construct()
    {
        $this->middleware('client',['except' => ['index','show']]);
        //$this->middleware('roles:admin',['except' => ['show','index']]);
        
    }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return $this->all();
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {

        return $this->add();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business)
    {
        //
        //return asset("storage/$business->image");
        return $this->getOne($business);
           
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Business $business)
    {
        //
       return $this->change($business);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business)
    {
        //
       return $this->delete($business);

    }
     public function getTypeOfBussines(){
        
        if (!Request()->isJson()) {
            return response()->json(['error' => 'Unauthorized'], 401, []);
        }

        $types = Typebusiness::all();

        return response()->json(['types' => $types],201);

    }
    

}
