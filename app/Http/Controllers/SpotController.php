<?php

namespace App\Http\Controllers;
use App\Spot;
use Illuminate\Http\Request;

class SpotController extends Controller
{

    const MODEL = "App\Spot";
    const FOLDER = "Spot";
    use ApiResource;

    function __construct()
    {
        $this->middleware('auth:api',['except' => ['index','show']]);
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
    public function store(Request $request)
    {
        //
        return $this->add();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Spot $spot )
    {
        //
        return $this->getOne($spot);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Spot $spot)
    {
        //
        return $this->change($spot);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Spot $spot)
    {
        //
        return $this->delete($spot);
        
    }
}
