<?php

namespace App\Http\Controllers;

use App\Drawing;
use App\Property;
use App\Act;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class DrawController extends Controller
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
        //
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
    public function store(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        if(!$request->file('drawing')){
            flash('Please select at least 1 file')->error();
            return redirect()->back();
        }
        else{
            $drawings = $request->file('drawing');
        }

        $messages = [];
        $count = 0;

        foreach($drawings as $draw){
            $messages['drawing.'.$count.'.max'] =  $draw->getClientOriginalName().' exceeded max file size of 5MB';
            $messages['drawing.'.$count.'.mimes'] =  $draw->getClientOriginalName().' should be of file type: dwg, image or pdf';
            $count++;
        }

        $this->validate($request,[
            'drawing.*' => 'mimes:dwg,jpg,jpeg,png,pdf|max:5120'
        ],$messages);

        foreach($drawings as $draw){
             $draw->storeAs('public/drawings/'.$property->id.'/',$draw->getClientOriginalName().'.'.$draw->getClientOriginalExtension());
             $property->drawing()->save(New Drawing(['drawing' => url('storage/drawings/').'/'.$property->id.'/'.$draw->getClientOriginalName().'.'.$draw->getClientOriginalExtension()]));
        }

        $this->addLog(\Auth::user()->name.' added drawings to '.$property->name);

        flash('Drawings successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function show(Drawing $drawing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function edit(Drawing $drawing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Drawing $drawing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Drawing  $drawing
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drawing = Drawing::findOrFail($id);

        Storage::delete($drawing->drawingFile);

        Drawing::destroy($id);
        flash('Successfully Deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
