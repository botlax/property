<?php

namespace App\Http\Controllers;

use App\Progress;
use App\Log;
use App\Act;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProgController extends Controller
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
    public function index($id)
    {
        $log = Log::findOrFail($id);
        $property = $log->property()->first();
        $progress = $log->progress()->orderBy('log_date','DESC')->get();
        return view('dashboard.log-progress',compact('log','progress','property'));
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
        $log = Log::findOrFail($id);

        $this->validate($request,[
            'desc' => 'required',
            'log_date' => 'required|date'
        ]);

        /*
        if(Carbon::createFromFormat('Y-m-d',$request->input('log_date'))->lt($log->log_date) ){
            flash('Progress date cannot be before the Maintenance Opening date')->error()->important();
            return redirect()->back();
        }*/

        $progress = Progress::create($request->all());

        $log->progress()->save($progress);
		//dd($progress);
        $this->addLog(\Auth::user()->name.' added a complaint progress.');
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $progress = Progress::findOrFail($id);
        $log = $progress->log()->first();

        $this->validate($request,[
            'desc' => 'required',
            'log_date' => 'required|date'
        ]);

        $progress->desc = $request->input('desc');
        $progress->log_date = $request->input('log_date');

        $progress->save();

        $this->addLog(\Auth::user()->name.' updated a complaint progress.');
        flash('Successfully updated')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Progress::destroy($id);

        $this->addLog(\Auth::user()->name.' deleted a progress.');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
