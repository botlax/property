<?php

namespace App\Http\Controllers;

use App\Setting;
use App\Act;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AppController extends Controller
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
        $year = [];
        for($x = intval(date('Y')); $x >= 2000; $x--){
            $year[$x] = $x;
        }

        $month = [];
        $month[1] = 'January';
        $month[2] = 'February';
        $month[3] = 'March';
        $month[4] = 'April';
        $month[5] = 'May';
        $month[6] = 'June';
        $month[7] = 'July';
        $month[8] = 'August';
        $month[9] = 'September';
        $month[10] = 'October';
        $month[11] = 'November';
        $month[12] = 'December';

        $setting = Setting::first();

        $monthNum = $setting->months;



        return view('dashboard.settings.home',compact('setting','month','year','monthNum'));
    }

    public function update(Request $request)
    {
        $status = $request->input('status');
        $data = [];
        switch ($status) {
            case 'year':
                $this->validate($request,[
                    'year' => 'required',
                    'month' => 'nullable',
                    'month_from' => 'nullable',
                    'year_from' => 'nullable',
                    'month_to' => 'nullable',
                    'year_to' => 'nullable'
                ]);

                $data['status'] = 'year';
                $data['months'] = 12;
                $data['from'] = $request->input('year').'-1-1';
                $data['to'] = $request->input('year').'-12-1';

                break;
            case 'month':
                $this->validate($request,[
                    'year' => 'nullable',
                    'month' => 'required',
                    'month_from' => 'nullable',
                    'year_from' => 'nullable',
                    'month_to' => 'nullable',
                    'year_to' => 'nullable'
                ]);

                $data['status'] = 'month';
                $data['months'] = $request->input('month');
                $data['to'] = Carbon::createFromFormat('Y-m-d',date('Y').'-'.date('m').'-1');
                $data['from'] = Carbon::createFromFormat('Y-m-d',date('Y').'-'.date('m').'-1')->subMonths($request->input('month'));

                break;
            case 'custom':
                $this->validate($request,[
                    'year' => 'nullable',
                    'month' => 'nullable',
                    'month_from' => 'required',
                    'year_from' => 'required',
                    'month_to' => 'required',
                    'year_to' => 'required'
                ]);

                $data['status'] = 'custom';
                $data['from'] = Carbon::createFromFormat('Y-m-d',$request->input('year_from').'-'.$request->input('month_from').'-1');
                $data['to'] = Carbon::createFromFormat('Y-m-d',$request->input('year_to').'-'.$request->input('month_to').'-1');
                $data['months'] = $data['from']->diffInMonths($data['to']) + 1;

                if($data['to']->lt($data['from'])){
                    flash('"From" date cannot be greater than "To" date')->error()->important();
                    return redirect()->back();
                }

                break;
        }

        $setting = Setting::first();
        $setting->update($data);

        $this->addLog(\Auth::user()->name.' updated app settings.');
        flash('Successfully updated')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }

}
