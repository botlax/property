<?php

namespace App\Http\Controllers;

use App\Renter;
use App\Property;
use App\Act;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class RenterController extends Controller
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
        $renters = Renter::current()->get();
        return view('dashboard.renters',compact('renters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::whereDoesntHave('renter')->whereDoesntHave('owner')->where('for_rent','yes')->pluck('name','id')->toArray();

        return view('dashboard.renter-add',compact('properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'nullable|email:users,email',
            'qid' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'contract' => 'nullable|mimes:pdf,jpg,jpeg,doc,docx|max:2048',
            'p_contract' => 'nullable|mimes:pdf,jpg,jpeg,doc,docx|max:2048',
            'cr' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'permit' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'properties' => 'nullable',
            'mobile' => 'nullable|numeric',
            'address' => 'nullable',
            'company' => 'nullable',
            'co_contact' => 'nullable|numeric',
            'co_mobile' => 'nullable|numeric',
            'co_address' => 'nullable',
            'co_person' => 'nullable',
        ]);

        $renter = Renter::create($request->only(['name','email','mobile','address','company','co_person','co_mobile','co_address','co_contact']));

        if($request->input('properties')){
            $property = Property::findOrFail($request->input('properties'));
            $property->renter()->save($renter);
        }

        $qid = $request->file('qid');

        if($qid){
            $qid->storeAs('public/qid/renter/',$renter->id.'.'.$qid->getClientOriginalExtension());
            $renter->qid = url('storage/qid/renter/').'/'.$renter->id.'.'.$qid->getClientOriginalExtension();
        }

        $cr = $request->file('cr');

        if($cr){
            $cr->storeAs('public/cr/renter/',$renter->id.'.'.$cr->getClientOriginalExtension());
            $renter->cr = url('storage/cr/renter/').'/'.$renter->id.'.'.$cr->getClientOriginalExtension();
        }

        $permit = $request->file('permit');

        if($permit){
            $permit->storeAs('public/permit/renter/',$renter->id.'.'.$permit->getClientOriginalExtension());
            $renter->permit = url('storage/permit/renter/').'/'.$renter->id.'.'.$permit->getClientOriginalExtension();
        }

        $contract = $request->file('contract');

        if($contract){
            $contract->storeAs('public/contract/renter/',$renter->id.'.'.$contract->getClientOriginalExtension());
            $renter->contract = url('storage/contract/renter/').'/'.$renter->id.'.'.$contract->getClientOriginalExtension();
        }

        $p_contract = $request->file('p_contract');

        if($p_contract){
            $p_contract->storeAs('public/p_contract/renter/',$renter->id.'.'.$p_contract->getClientOriginalExtension());
            $renter->p_contract = url('storage/p_contract/renter/').'/'.$renter->id.'.'.$p_contract->getClientOriginalExtension();
        }

        $renter->save();

        $this->addLog(\Auth::user()->name.' added renter '.$renter->name);
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $renter = Renter::findOrFail($id);

        $prop = $renter->property()->first();

        $propOpt = Property::where('for_rent','yes')->where('id','!=',$prop?$prop->id:0)->whereDoesntHave('renter')->pluck('name','id')->toArray();

        //dd($user->property()->first()->toArray());
        return view('dashboard.renter',compact('renter','propOpt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function edit(Renter $renter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $process = $request->input('process');
        $field = $request->input('field');
        $renter = Renter::findOrFail($id);

        //-----DELETE
        if($process == 'delete'){
            switch ($field) {
                case 'qid':
                    Storage::delete($renter->qidFile);
                    $renter->qid = null;
                    break;
                case 'cr':
                    Storage::delete($renter->crFile);
                    $renter->cr = null;
                    break;
                case 'permit':
                    Storage::delete($renter->permitFile);
                    $renter->permit = null;
                    break;
                case 'contract':
                    Storage::delete($renter->contractFile);
                    $renter->contract = null;
                    break;
                case 'p_contract':
                    Storage::delete($renter->pcontractFile);
                    $renter->p_contract = null;
                    break;
                case 'email':
                    $renter->email = null;
                    break;
                case 'mobile':
                    $renter->mobile = null;
                    break;
                case 'address':
                    $renter->address = null;
                    break;
                case 'company':
                    $renter->company = null;
                    break;
                case 'co_address':
                    $renter->co_address = null;
                    break;
                case 'co_person':
                    $renter->co_person = null;
                    break;
                case 'co_contact':
                    $renter->co_contact = null;
                    break;
                case 'co_mobile':
                    $renter->co_mobile = null;
                    break;
                case 'property':
                    $renter->prop_id = null;
                    break;
            }

            flash('Successfully deleted')->success();
        }

        //-----ADD and UPDATE
        if($process == 'add' || $process == 'update'){
            switch ($field) {
                case 'name':
                    $this->validate($request,[
                        'name' => 'required'
                    ]);
                    $renter->name = $request->input('name');
                    break;
                case 'email':
                    $this->validate($request,[
                        'email' => 'required|email'
                    ]);
                    $renter->email = $request->input('email');
                    break;
                case 'mobile':
                    $this->validate($request,[
                        'mobile' => 'required|numeric'
                    ]);
                    $renter->mobile = $request->input('mobile');
                    break;
                case 'address':
                    $this->validate($request,[
                        'address' => 'required'
                    ]);
                    $renter->address = $request->input('address');
                    break;
                case 'company':
                    $this->validate($request,[
                        'company' => 'required'
                    ]);
                    $renter->company = $request->input('company');
                    break;
                case 'co_address':
                    $this->validate($request,[
                        'co_address' => 'required'
                    ]);
                    $renter->co_address = $request->input('co_address');
                    break;
                case 'co_contact':
                    $this->validate($request,[
                        'co_contact' => 'required|numeric'
                    ]);
                    $renter->co_contact = $request->input('co_contact');
                    break;
                case 'co_mobile':
                    $this->validate($request,[
                        'co_mobile' => 'required|numeric'
                    ]);
                    $renter->co_mobile = $request->input('co_mobile');
                    break;
                case 'co_person':
                    $this->validate($request,[
                        'co_person' => 'required'
                    ]);
                    $renter->co_person = $request->input('co_person');
                    break;
                case 'qid':
                    $this->validate($request,[
                        'qid' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'qid.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $qid = $request->file('qid');
                    $qid->storeAs('public/qid/renter/',$renter->id.'.'.$qid->getClientOriginalExtension());

                    $renter->qid = url('storage/qid/renter/').'/'.$renter->id.'.'.$qid->getClientOriginalExtension();
                    break;
                case 'contract':
                    $this->validate($request,[
                        'contract' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'contract.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $contract = $request->file('contract');
                    $contract->storeAs('public/contract/renter/',$renter->id.'.'.$contract->getClientOriginalExtension());

                    $renter->contract = url('storage/contract/renter/').'/'.$renter->id.'.'.$contract->getClientOriginalExtension();
                    break;
                case 'p_contract':
                    $this->validate($request,[
                        'p_contract' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'p_contract.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $p_contract = $request->file('p_contract');
                    $p_contract->storeAs('public/p_contract/renter/',$renter->id.'.'.$p_contract->getClientOriginalExtension());

                    $renter->p_contract = url('storage/p_contract/renter/').'/'.$renter->id.'.'.$p_contract->getClientOriginalExtension();
                    break;
                case 'cr':
                    $this->validate($request,[
                        'cr' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'cr.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $cr = $request->file('cr');
                    $cr->storeAs('public/cr/renter/',$renter->id.'.'.$cr->getClientOriginalExtension());

                    $renter->cr = url('storage/cr/renter/').'/'.$renter->id.'.'.$cr->getClientOriginalExtension();
                    break;
                case 'permit':
                    $this->validate($request,[
                        'permit' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'permit.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $permit = $request->file('permit');
                    $permit->storeAs('public/permit/renter/',$renter->id.'.'.$permit->getClientOriginalExtension());

                    $renter->permit = url('storage/permit/renter/').'/'.$renter->id.'.'.$permit->getClientOriginalExtension();
                    break;
                case 'property':
                    $renter->prop_id = $request->input('property');
                    break;
            }

            flash('Process Successfull')->success();
        }

        $renter->save();

        $this->addLog(\Auth::user()->name.' updated details of '.$renter->name);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Renter  $renter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $renter = Renter::findOrFail($id);
        $renter->prev = 'yes';
        $renter->prop_id = null;
        $renter->save();

        $this->addLog(\Auth::user()->name.' deleted a renter.');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
