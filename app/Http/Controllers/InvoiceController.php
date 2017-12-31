<?php

namespace App\Http\Controllers;

use App\LInvoice;
use App\Log;
use App\Act;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
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
        $invoices = $log->invoice()->orderBy('id','DESC')->get();
        return view('dashboard.log-invoice',compact('log','invoices','property'));
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
            'invoice' => 'required|mimes:jpeg,jpg,pdf'
        ]);

        $invoice = Linvoice::create(['desc' => $request->input('desc')]);

        $file = $request->file('invoice');

        if($file){
            $file->storeAs('public/invoice/'.$log->id,$file->getClientOriginalName());

            $invoice->invoice = url('storage/invoice/').'/'.$log->id.'/'.$file->getClientOriginalName();
        }

        $log->invoice()->save($invoice);
        $this->addLog(\Auth::user()->name.' added an invoice.');
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LInvoice  $lInvoice
     * @return \Illuminate\Http\Response
     */
    public function show(LInvoice $lInvoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LInvoice  $lInvoice
     * @return \Illuminate\Http\Response
     */
    public function edit(LInvoice $lInvoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LInvoice  $lInvoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $invoice = lInvoice::findOrFail($id);
        $log = $invoice->log()->first();

        $this->validate($request,[
            'desc' => 'required',
            'invoice' => 'nullable|mimes:jpeg,jpg,pdf'
        ]);

        $invoice->desc = $request->input('desc');

        $file = $request->file('invoice');

        if($file){
            $file->storeAs('public/invoice/'.$log->id,$file->getClientOriginalName());

            $invoice->invoice = url('storage/invoice/').'/'.$log->id.'/'.$file->getClientOriginalName();
        }

        $invoice->save();

        $this->addLog(\Auth::user()->name.' updated an invoice.');
        flash('Successfully updated')->success();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LInvoice  $lInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = lInvoice::findOrFail($id);
        Storage::delete($invoice->invoiceFile);
        lInvoice::destroy($id);
        $this->addLog(\Auth::user()->name.' deleted an invoice.');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
