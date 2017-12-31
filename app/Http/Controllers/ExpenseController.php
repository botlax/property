<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Property;
use App\Act;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Setting;

class ExpenseController extends Controller
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
        $expenses = $property->expense()->get();

        $from = Setting::first()->from;
        $to = Setting::first()->to;
        
        $otherExpense = [];
        $ms = [];

        for($from; $from->lte($to); $from = $from->addMonth()){
            $otherExpense[] = $property->expense()->whereMonth('date',$from->format('m'))->sum('cost');
            $ms[] = $from->format('F');
        }

        return view('dashboard.expenses',compact('expenses','property','otherExpense','ms'));
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
            'date' => 'required|date',
            'cost' => 'nullable|numeric',
            'desc' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg|max:2048'
        ]);

        $expense = Expense::create($request->except('file'));

        $file = $request->file('file');

        if($file){
            $file->storeAs('public/expense/'.$property->id,$file->getClientOriginalName());

            $expense->file = url('storage/expense/').'/'.$property->id.'/'.$file->getClientOriginalName();
        }

        $expense->save();

        $property->expense()->save($expense);

        $this->addLog(\Auth::user()->name.' added an expense to ' .$property->name);
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $expense = Expense::findOrFail($id);
        $property = $expense->property()->first();
        $this->validate($request,[
            'date' => 'required|date',
            'cost' => 'nullable|numeric',
            'desc' => 'required',
            'file' => 'nullable|mimes:pdf,jpg,jpeg|max:2048'
        ]);

        $expense->update($request->except('file'));

        $file = $request->file('file');

        if($file){
            Storage::delete($expense->expenseFile);
            $file->storeAs('public/expense/'.$property->id,$file->getClientOriginalName());

            $expense->file = url('storage/expense/').'/'.$property->id.'/'.$file->getClientOriginalName();
        }

        $expense->save();
        $this->addLog(\Auth::user()->name.' updated an expense of ' .$property->name);
        flash('Successfully updated')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::findOrFail($id);
        Storage::delete($expense->expenseFile);
        Expense::destroy($id);

        $this->addLog(\Auth::user()->name.' deleted an expense');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
