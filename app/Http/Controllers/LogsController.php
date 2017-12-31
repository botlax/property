<?php

namespace App\Http\Controllers;

use App\Log;
use App\Property;
use App\Act;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Setting;

class LogsController extends Controller
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
    public function create($id)
    {
        $property = Property::findOrFail($id);
        return view('dashboard.logs-add',compact('property'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $this->validate($request,[
            'log_date' => 'required|date',
            'desc' => 'required',
            'complainer' => 'nullable',
            'mobile' => 'nullable|numeric',
        ]);

        $log = New Log($request->all());
        $property = Property::findOrFail($id);
        $property->log()->save($log);

        $this->addLog(\Auth::user()->name.' added a complaint from '.$property->name);
        flash('Successfully Added')->success();
        return redirect('maintenance'.'/'.$property->id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function close(Request $request, $id)
    {

        $log = Log::findOrFail($id);

        $this->validate($request,[
            'close_date' => 'required|date',
            'cost' => 'nullable|numeric'
        ]);

        $log->close_date = $request->input('close_date');
        $log->cost = $request->input('cost');
        $log->status = 'close';

        $log->save();
        
        $this->addLog(\Auth::user()->name.' closed a complaint');
        flash('Complaint Closed');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function open(Request $request, $id)
    {
        $log = Log::findOrFail($id);

        $log->close_date = null;
        $log->cost = null;
        $log->status = 'open';

        $log->save();

        $this->addLog(\Auth::user()->name.' reopened a complaint.');
        flash('Complaint Opened');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $property = Property::findOrFail($id);
        $logs = $property->log()->where('status','open')->orderBy('log_date','DESC')->paginate(20);

        $from = Setting::first()->from;
        $to = Setting::first()->to;
        
        $logExpense = [];
        $ms = [];

        for($from; $from->lte($to); $from = $from->addMonth()){
            $logExpense[] = $property->log()->where('status','close')->whereMonth('close_date',$from->format('m'))->sum('cost');
            $ms[] = $from->format('F');
        }

        return view('dashboard.logs',compact('property','logs','logExpense','ms'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function showClosed($id)
    {
        $property = Property::findOrFail($id);
        $logs = $property->log()->where('status','close')->orderBy('log_date','DESC')->paginate(20);

        $from = Setting::first()->from;
        $to = Setting::first()->to;
        
        $logExpense = [];
        $ms = [];

        for($from; $from->lte($to); $from = $from->addMonth()){
            $logExpense[] = $property->log()->where('status','close')->whereMonth('close_date',$from->format('m'))->sum('cost');
            $ms[] = $from->format('F');
        }

        return view('dashboard.logs-closed',compact('property','logs','logExpense','ms'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $id)
    {
        $this->validate($request,[
            'from' => 'required|date',
            'to' => 'required|date'
        ]);

        $from = new Carbon($request->input('from'));
        $to = new Carbon($request->input('to'));

        if($from > $to){
            flash('"From" date cannot be beyond "To" date')->error()->important();
            return redirect()->back();
        }

        $property = Property::findOrFail($id);
        $logs = $property->log()->where('log_date','>=',$from)->where('log_date','<=',$to)->orderBy('log_date','DESC')->paginate(20);

        return view('dashboard.logs',compact('property','logs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $log = Log::findOrFail($id);
        return view('dashboard.logs-edit',compact('log'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $log = Log::findOrFail($id);

        if($log->status == 'open'){
            $this->validate($request,[
                'log_date' => 'required|date',
                'desc' => 'required',
                'complainer' => 'nullable',
                'mobile' => 'nullable|numeric',
            ]);
        }
        else{
            $this->validate($request,[
                'log_date' => 'required|date',
                'close_date' => 'required|date',
                'desc' => 'required',
                'complainer' => 'nullable',
                'mobile' => 'nullable|numeric',
                'cost' => 'nullable|numeric'
            ]);
        }
        
        $property = $log->property()->first();
        $log->update($request->all());

        $this->addLog(\Auth::user()->name.' updated a complaint from '.$property->name);

        flash('Successfully Updated')->success();
        if($log->status == 'open'){
            return redirect(url('maintenance').'/'.$property->id);
        }
        else{
            return redirect(url('maintenance-closed').'/'.$property->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Storage::deleteDirectory('public/invoice/'.$id);

        if(Log::destroy($id)){
            flash('successfully deleted')->success();
        }
        else{
            flash('An error has occured while deleting the entry. Please refresh the page then try again.')->error();
        }

        $this->addLog(\Auth::user()->name.' deleted a complaint.');

        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
