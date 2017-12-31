<?php

namespace App\Http\Controllers;

use App\Guarantee;
use App\Property;
use App\Act;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class GuaranteeController extends Controller
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
        $property = Property::findOrFail($id);
        $guarantees = $property->guarantee()->get();
        return view('dashboard.guarantees',compact('guarantees','property'));
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
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date',
            'desc' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg|max:2048'
        ]);

        if(Carbon::createFromFormat('Y-m-d',$request->input('from'))->gt(Carbon::createFromFormat('Y-m-d',$request->input('to')))){
            flash('"From" date cannot be greater than "To" date')->error();
            return redirect()->back();
        }

        $guarantee = Guarantee::create($request->except('file'));

        $file = $request->file('file');

        if($file){
            $file->storeAs('public/guarantee/'.$property->id,$file->getClientOriginalName());

            $guarantee->file = url('storage/guarantee/').'/'.$property->id.'/'.$file->getClientOriginalName();
        }

        $guarantee->save();

        $property->guarantee()->save($guarantee);
        $this->addLog(\Auth::user()->name.' added a guarantee for '.$property->name);
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function show(Guarantee $guarantee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function edit(Guarantee $guarantee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $guarantee = Guarantee::findOrFail($id);
        $property = $guarantee->property()->first();
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date',
            'desc' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg|max:2048'
        ]);

        if(Carbon::createFromFormat('Y-m-d',$request->input('from'))->gt(Carbon::createFromFormat('Y-m-d',$request->input('to')))){
            flash('"From" date cannot be greater than "To" date')->error();
            return redirect()->back();
        }

        $guarantee->update($request->except('file'));

        $file = $request->file('file');

        if($file){
            Storage::delete($guarantee->guaranteeFile);
            $file->storeAs('public/guarantee/'.$property->id,$file->getClientOriginalName());

            $guarantee->file = url('storage/guarantee/').'/'.$property->id.'/'.$file->getClientOriginalName();
        }

        $guarantee->save();

        $this->addLog(\Auth::user()->name.' updated a guarantee of '.$property->name);

        flash('Successfully updated')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guarantee  $guarantee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guarantee = Guarantee::findOrFail($id);
        Storage::delete($guarantee->guaranteeFile);
        Guarantee::destroy($id);
        $this->addLog(\Auth::user()->name.' deleted a guarantee.');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
