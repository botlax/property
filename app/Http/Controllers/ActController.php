<?php

namespace App\Http\Controllers;

use App\Act;
use Illuminate\Http\Request;

class ActController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Act::orderBy('date','DESC')->paginate(30);
        return view('dashboard.acts',compact('logs'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function show(Act $act)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function edit(Act $act)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Act $act)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Act  $act
     * @return \Illuminate\Http\Response
     */
    public function destroy(Act $act)
    {
        //
    }
}
