<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Renter;
use App\Property;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Mail\Invoice;
use Illuminate\Support\Facades\Storage;
use Mail;

class PaymentController extends Controller
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
        $payments = $property->payment()->whereNotNull('paydate')->orderBy('year','DESC')->orderBy('month','DESC')->get();
        $pending = $property->payment()->whereNull('paydate')->orderBy('year','ASC')->orderBy('month','ASC')->get();
        $renter = $property->renter()->first();
        $renters = Renter::current()->pluck('name','id')->toArray();
        $year = [];

        for($x = date('Y')+2; $x >= 2000; $x--){
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

        return view('dashboard.payments',compact('property','payments','renter','renters','pending','year','month')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request, $id)
    {
        $this->validate($request,[
            'month_from' => 'required',
            'year_from' => 'required',
            'month_to' => 'required',
            'year_to' => 'required',
        ]);

        $from = Carbon::create($request->input('year_from'), $request->input('month_from'), 1);
        $to = Carbon::create($request->input('year_to'), $request->input('month_to'), 1)->addMonth();
        $to = $to->subDay();

        if($from->gt($to)){
            flash('"From" date cannot be beyond "To" date.')->error()->important();
            return redirect()->back();
        }

        $property = Property::findOrFail($id);
        $payments = $property->payment()->whereNotNull('paydate')->where(function($query)use($from,$to){
            for($from; $from->lte($to); $from->addMonth()){
                $query;
                $query = $query->orWhere(function($q)use($from,$to){
                    $q->where('month',$from->format('n'))->where('year',$from->format('Y'));
                });
            }
        });

        $payments = $payments->orderBy('year','DESC')->orderBy('month','DESC')->get();

        $pending = $property->payment()->whereNull('paydate')->orderBy('year','ASC')->orderBy('month','ASC')->get();
        $renter = $property->renter()->first();
        $renters = Renter::current()->pluck('name','id')->toArray();
        $year = [];

        for($x = date('Y')+2; $x >= 2000; $x--){
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

        return view('dashboard.payments',compact('property','payments','renter','renters','pending','year','month')); 
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
        $this->validate($request,[
            'amount' => 'required|numeric',
            'paydate' => 'required|date',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'renter_id' => 'required|numeric',
            'cheque' => 'nullable|mimes:pdf,jpg,jpeg|max:2048'
        ]);

        $property = Property::findOrFail($id);

        $payments = $property->payment()->orderBy('year','DESC')->orderBy('month','DESC')->get();

        $current = $request->input('year').$request->input('month');
        $record = [];

        foreach($payments as $pay){
            $record[] = $pay->year.$pay->month;
        }

        if(in_array($current, $record)){
            if($request->input('overwrite')){
                $property->payment()->where('year',$request->input('year'))->where('month',$request->input('month'))->delete();
            }else{
                if($property->payment()->where('year',$request->input('year'))->where('month',$request->input('month'))->first()->paydate){
                    flash('A payment for the given month already exist.')->error()->important();
                    return redirect()->back();
                }else{
                    flash('A pending payment for the given month already exist. Please delete the pending payment first or click the "Pay" button.')->error()->important();
                    return redirect()->back();
                }
            }
        }

        $payment = Payment::create($request->all());

        $file = $request->file('cheque');

        if($file){
            $file->storeAs('public/cheque/'.$payment->id,$file->getClientOriginalName());

            $payment->cheque = url('storage/cheque/').'/'.$payment->id.'/'.$file->getClientOriginalName();
        }

        $property->payment()->save($payment);

        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function batch(Request $request, $id)
    {
        $this->validate($request,[
            'amount' => 'required|numeric',
            'paydate' => 'required|date',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'month_to' => 'required|numeric',
            'year_to' => 'required|numeric',
            'renter_id' => 'required|numeric'
        ]);

        $property = Property::findOrFail($id);

        $payments = $property->payment()->orderBy('year','DESC')->orderBy('month','DESC')->get();

        $record = [];

        foreach($payments as $pay){
            $record[] = $pay->year.$pay->month;
        }

        $from = Carbon::create($request->input('year'),$request->input('month'),1);
        $to = Carbon::create($request->input('year_to'),$request->input('month_to'),1);

        if($to->lt($from)){
            flash('"From" month cannot be beyond "To" month.')->error()->important();
            return redirect()->back();
        }

        $data = [];

        for($from; $from->lte($to); $from->addMonth()){
            if(in_array($from->format('Yn'), $record)){
                if($request->input('overwrite')){
                    $property->payment()->where('month',$from->format('n'))->where('year',$from->format('Y'))->delete();
                }else{
                    flash('A payment / pending payment for the given date range already exist.')->error()->important();
                    return redirect()->back();
                }
            }

            $data['amount'] = $request->input('amount');
            $data['paydate'] = $request->input('paydate');
            $data['month'] = $from->format('n');
            $data['year'] = $from->format('Y');
            $data['renter_id'] = $request->input('renter_id');

            $payment = Payment::create($data);

            $invoiceRaw = $payment->id.Carbon::now()->format('Ymdgis').Renter::findOrFail($payment->renter_id)->name.'pydl';
            $payment->invoice = bcrypt($invoiceRaw);
            $payment->save();

            $property->payment()->save($payment);
        }

        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $property = $payment->property->first();
        
        if($property->fee){
            $payment->amount = $property->fee;
            $payment->paydate = Carbon::today();
            $invoiceRaw = $payment->id.Carbon::now()->format('Ymdgis').Renter::findOrFail($payment->renter_id)->name.'pydl';
            $payment->invoice = bcrypt($invoiceRaw);
        }
        else{
            flash('Please add Payment Fee for '.$property->name)->error()->important();
            return redirect()->back();
        }

        $payment->save();
        flash('Successfully paid')->success();
        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request, $id)
    {
        $this->validate($request,[
            'amount' => 'required|numeric',
            'paydate' => 'required|date',
            'month' => 'required|numeric',
            'year' => 'required|numeric',
            'cheque' => 'nullable|mimes:pdf,jpg,jpeg|max:2048',
            'renter_id' => 'required|numeric'
        ]);

        $payment = Payment::findOrFail($id);
        $property = $payment->property()->first();


        $payments = $property->payment()->where('id','!=',$id)->orderBy('year','DESC')->orderBy('month','DESC')->get();
        $current = $request->input('year').$request->input('month');

        $record = [];

        foreach($payments as $pay){
            $record[] = $pay->year.$pay->month;
        }

        if(in_array($current, $record)){
            if($property->payment()->where('year',$request->input('year'))->where('month',$request->input('month'))->first()->paydate){
                flash('A payment for the given month already exist.')->error()->important();
                return redirect()->back();
            }else{
                flash('A pending payment for the given month already exist. Please delete the pending payment first or click the "Pay" button to add payment.')->error()->important();
                return redirect()->back();
            }
            
        }

        $payment->update($request->except('cheque'));

        $file = $request->file('cheque');

        if($file){
            Storage::delete($payment->chequeFile);
            $file->storeAs('public/cheque/'.$payment->id,$file->getClientOriginalName());

            $payment->cheque = url('storage/cheque/').'/'.$payment->id.'/'.$file->getClientOriginalName();
        }

        $payment->save();

        flash('Successfully updated')->success();
        return redirect()->back();

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function invoice(Request $request)
    {
        $invoice = Payment::where('invoice',$request->input('id'))->first();
        $property = $invoice->property()->first();
        $renter = Renter::findOrFail($invoice->renter_id);

        if($invoice){
            return view('dashboard.invoice',compact('invoice','property','renter'));
        }else{
            abort(404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        $payment = Payment::findOrFail($id);
        $renter = Renter::findOrFail($payment->renter_id);

        if(!$renter->email){
            flash('Please add email details for '.$renter->name)->error()->important();
            return redirect()->back();
        }

        Mail::to($renter->email)->send(New Invoice($renter, $payment));
        flash('Invoice successfully sent to '.$renter->email)->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $payment = Payment::findOrFail($id);
        Storage::deleteDirectory('public/cheque/'.$id);
        if(Payment::destroy($id)){
            flash('Successfully deleted')->success();
            return redirect()->back();
        }
        flash('An error has occured. Refresh the page and try again.')->error()->important();
        return redirect()->back();
    }
}
