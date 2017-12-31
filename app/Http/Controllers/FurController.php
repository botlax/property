<?php

namespace App\Http\Controllers;

use App\Furniture;
use Illuminate\Http\Request;

class FurController extends Controller
{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $furnitures = Furniture::orderBy('id','ASC')->get();

        return view('dashboard.furnitures',compact('furnitures'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|unique'
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Furniture  $furniture
     * @return \Illuminate\Http\Response
     */
    public function show(Furniture $furniture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Furniture  $furniture
     * @return \Illuminate\Http\Response
     */
    public function edit(Furniture $furniture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Furniture  $furniture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $furniture = Furniture::findOrFail($id);
        $this->validate($request,[
            'name' => 'required|unique:furnitures,name,'.$furniture->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Furniture  $furniture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Furniture $furniture)
    {
        //
    }
}
