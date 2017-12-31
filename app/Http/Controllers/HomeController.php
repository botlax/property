<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Expense;
use App\Log;
use App\Setting;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $from = Setting::first()->from;
        $to = Setting::first()->to;
        
        $logExpense = []; $otherExpense = [];

        $ms = [];

        for($from; $from->lte($to); $from = $from->addMonth()){
            $logExpense[] = Log::where('status','close')->whereMonth('close_date',$from->format('m'))->sum('cost');
            $otherExpense[] = Expense::whereMonth('date',$from->format('m'))->sum('cost');
            $ms[] = $from->format('F');
        }

        return view('dashboard.home',compact('logExpense', 'otherExpense', 'ms'));
    }
}
