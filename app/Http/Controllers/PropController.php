<?php

namespace App\Http\Controllers;

use App\Property;
use App\Furniture;
use App\Renter;
use App\User;
use App\Payment;
use App\Act;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PropController extends Controller
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
        $for_rent = Property::where('for_rent','yes')->get();
        $owner_prop = Property::where('for_rent','no')->get();

        return view('dashboard.properties',compact('for_rent', 'owner_prop'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owners = User::current()->pluck('name','id')->toArray();
        return view('dashboard.prop-add',compact('owners'));
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
            'location' => 'nullable',
            'desc' => 'nullable',
            'elec' => 'nullable|numeric',
            'water' => 'nullable|numeric',
            'p_area' => 'nullable|numeric',
            'b_area' => 'nullable|numeric',
            'loc_lat' => 'nullable|required_with:loc_long|numeric',
            'loc_long' => 'nullable|required_with:loc_lat|numeric',
            'bldg_permit' => 'max:5120|nullable|mimes:pdf,jpg,jpeg',
            'floor' => 'max:5120|nullable|mimes:pdf,jpg,jpeg',
            'deed' => 'max:5120|nullable|mimes:pdf,jpg,jpeg',
            'layout' => 'max:5120|nullable|mimes:pdf,jpg,jpeg',
            'completion' => 'max:5120|nullable|mimes:pdf,jpg,jpeg',
        ],[
            'bldg_permit.mimes' => 'Only pdf & jpg are allowed',
            'completion.mimes' => 'Only pdf & jpg are allowed',
            'layout.mimes' => 'Only pdf & jpg are allowed',
            'deed.mimes' => 'Only pdf & jpg are allowed',
            'floor.mimes' => 'Only pdf & jpg are allowed'
        ]);

        $property = Property::create($request->except(['bldg_permit','for_rent','floor','deed','layout','completion']));

        $owners = $request->input('owner');
        if($owners){
            $property->god()->attach($owners);
        }

        $bldg_permit = $request->file('bldg_permit');

        if($bldg_permit){
             $bldg_permit->storeAs('public/files/'.$property->id.'/','bldg_permit'.'.'.$bldg_permit->getClientOriginalExtension());

            $property->bldg_permit = url('storage/files/').'/'.$property->id.'/'.'bldg_permit'.'.'.$bldg_permit->getClientOriginalExtension();
        }

        $floor = $request->file('floor');

        if($floor){
             $floor->storeAs('public/files/'.$property->id.'/','floor'.'.'.$floor->getClientOriginalExtension());

            $property->floor = url('storage/files/').'/'.$property->id.'/'.'floor'.'.'.$floor->getClientOriginalExtension();
        }

        $deed = $request->file('deed');

        if($deed){
             $deed->storeAs('public/files/'.$property->id.'/','deed'.'.'.$deed->getClientOriginalExtension());

            $property->deed = url('storage/files/').'/'.$property->id.'/'.'deed'.'.'.$deed->getClientOriginalExtension();
        }

        $layout = $request->file('layout');

        if($layout){
             $layout->storeAs('public/files/'.$property->id.'/','layout'.'.'.$layout->getClientOriginalExtension());

            $property->layout = url('storage/files/').'/'.$property->id.'/'.'layout'.'.'.$layout->getClientOriginalExtension();
        }

        $completion = $request->file('completion');

        if($completion){
             $completion->storeAs('public/files/'.$property->id.'/','completion'.'.'.$completion->getClientOriginalExtension());

            $property->completion = url('storage/files/').'/'.$property->id.'/'.'completion'.'.'.$completion->getClientOriginalExtension();
        }

        if($request->input('for_rent')){
            $property->for_rent = 'yes';            
        }
        else{
            $property->for_rent = 'no';
        }

        $property->save();

        $this->addLog(\Auth::user()->name.' Added a property.');
        flash('Successfully Added!')->success();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $property = Property::findOrFail($id);
        $asBuilt = $property->drawing()->get();
        $renterOpt = Renter::current()->whereDoesntHave('property')->pluck('name','id')->toArray();
        $ownerOpt = User::current()->whereDoesntHave('property')->pluck('name','id')->toArray();
        $furnitures = $property->furniture()->get();
        $furnIds = $property->furniture()->pluck('id')->toArray();
        $furnOpt = Furniture::whereNotIn('id',$furnIds)->pluck('name','id')->toArray();
        $renter = $property->renter()->current()->first();
        $gods = $property->god()->current()->pluck('id')->toArray();
        $owners = User::whereNotIn('id',$gods)->current()->pluck('name','id')->toArray();

        if($renter){
            $pendingPayment = $property->payment()->whereNull('paydate')->where('renter_id',$renter->id)->get();
        }else{
            $pendingPayment = null;
        }
        //dd($pendingPayment);

        return view('dashboard.property',compact('property','asBuilt','furnitures','furnOpt','renterOpt','ownerOpt','pendingPayment','owners'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function furnStore(Request $request, $id)
    {
        $amount = $request->input('amount');
        $furniture = $request->input('furniture');

        $property = Property::findOrFail($id);
        $property->furniture()->attach([$furniture => ['num' => $amount]]);
        $property->save();
        $this->addLog(\Auth::user()->name.' Added an asset to '.$property->name);
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function furnUpdate(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $furniture = $property->furniture()->where('id',$request->input('furn_id'))->first();
        $furniture->pivot->num = $request->input('num');
        $furniture->pivot->save();
        $this->addLog(\Auth::user()->name.' updated an asset of ' .$property->name);
        flash('Successfully updated')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function furnDestroy(Request $request, $id)
    {
        $property = Property::findOrFail($id);

        $property->furniture()->detach($request->input('furn_id'));
        $property->save();
        $this->addLog(\Auth::user()->name.' deleted an asset.');
        flash('Successfully delete')->success();
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $process = $request->input('process');
        $field = $request->input('field');
        $property = Property::findOrFail($id);

        //-----DELETE
        if($process == 'delete'){
            switch ($field) {
                case 'location':
                    $property->location = null;
                    break;
                case 'desc':
                    $property->desc = null;
                    break;
                case 'elec':
                    $property->elec = null;
                    break;
                case 'water':
                    $property->water = null;
                    break;
                case 'p_area':
                    $property->p_area = null;
                    break;
                case 'b_area':
                    $property->b_area = null;
                    break;
                case 'fee':
                    $property->fee = null;
                    break;
                case 'map':
                    $property->loc_lat = null;
                    $property->loc_long = null;
                    break;
                case 'renter':
                    $renter = $property->renter()->first();
                    $property->payment()->whereNull('paydate')->where('renter_id',$renter->id)->delete();
                    $renter->prop_id = null;
                    $renter->save();
                    break;
                case 'owner':
                    $owner = $property->owner()->first();
                    $owner->prop_id = null;
                    $owner->save();
                    break;
                case 'god':
                    $owner = $request->input('god');
                    $property->god()->detach($owner);
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
                    $property->name = $request->input('name');
                    break;

                case 'location':
                    $this->validate($request,[
                        'location' => 'required'
                    ]);
                    $property->location = $request->input('location');
                    break;

                case 'desc':
                    $this->validate($request,[
                        'desc' => 'required'
                    ]);
                    $property->desc = $request->input('desc');
                    break;

                case 'elec':
                    $this->validate($request,[
                        'elec' => 'required|numeric'
                    ]);
                    $property->elec = $request->input('elec');
                    break;

                case 'water':
                    $this->validate($request,[
                        'water' => 'required|numeric'
                    ]);
                    $property->water = $request->input('water');
                    break;

                case 'p_area':
                    $this->validate($request,[
                        'p_area' => 'required|numeric'
                    ]);
                    $property->p_area = $request->input('p_area');
                    break;

                case 'b_area':
                    $this->validate($request,[
                        'b_area' => 'required|numeric'
                    ]);
                    $property->b_area = $request->input('b_area');
                    break;

                case 'fee':
                    $this->validate($request,[
                        'fee' => 'required|numeric'
                    ]);
                    $property->fee = $request->input('fee');
                    break;

                case 'renter':
                    $renter = Renter::findOrFail($request->input('renter'));
                    $property = Property::findOrFail($id);

                    if($property->renter()->first()){
                        $prevRenter = $property->renter()->first();
                        $prevRenter->prop_id = null;
                        $prevRenter->save();
                    }

                    $property->renter()->save($renter);
                    break;

                case 'owner':
                    $owner = User::findOrFail($request->input('owner'));
                    $property = Property::findOrFail($id);

                    if($property->owner()->first()){
                        $prevOwner = $property->owner()->first();
                        $prevOwner->prop_id = null;
                        $prevOwner->save();
                    }

                    $property->owner()->save($owner);
                    break;

                case 'god':
                    $owner = $request->input('owner');
                    $property = Property::findOrFail($id);

                    $property->god()->attach($owner);
                    break;

                case 'for_rent':
                    if($request->input('for_rent')){
                        if($property->for_rent == 'no'){
                            if($property->owner()->first()){
                                $owner = $property->owner()->first();
                                $owner->prop_id = null;
                                $owner->save();
                            }
                            if($property->god()->first()){
                                foreach($property->god()->get() as $god){
                                    $god->asset()->detach($property->id);
                                }
                            } 
                            $property->for_rent = 'yes';
                        }
                    }
                    else{
                        if($property->for_rent == 'yes'){
                            $property->payment()->whereNull('paydate')->delete();
                            if($property->renter()->first()){
                                $renter = $property->renter()->first();
                                $renter->prop_id = null;
                                $renter->save();
                            } 
                            $property->for_rent = 'no';
                        }
                    }
                    break;

                case 'map':
                    $validator = Validator::make($request->all(),[
                        'loc_long' => 'required|numeric',
                        'loc_lat' => 'required|numeric'
                    ],[
                        'loc_long.required' => 'Longitude field is required',
                        'loc_lat.required' => 'Latitude field is required',
                        'loc_long.numeric' => 'Longitude field must be of numeric value',
                        'loc_lat.numeric' => 'Latitude field must be of numeric value',
                    ]);

                    if($validator->fails()){
                        flash('An error has occured. Please try again and review the errors.')->error()->important();
                        return redirect()->back()->withErrors($validator);
                    }
                    
                    $property->loc_long = $request->input('loc_long');
                    $property->loc_lat = $request->input('loc_lat');
                    break;
            }

            flash('Process Successfull')->success();
        }

        $property->save();
        $this->addLog(\Auth::user()->name.' updated a property.');

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function updateFile(Request $request, $id)
    {
        $process = $request->input('process');
        $field = $request->input('field');
        $property = Property::findOrFail($id);

        //-----DELETE
        if($process == 'delete'){
            switch ($field) {
                case 'bldg_permit':
                    Storage::delete($property->bldgPermitFile);
                    $property->bldg_permit = null;
                    break;
                case 'completion':
                    Storage::delete($property->completionFile);
                    $property->completion = null;
                    break;
                case 'deed':
                    Storage::delete($property->deedFile);
                    $property->deed = null;
                    break;
                case 'layout':
                    Storage::delete($property->layoutFile);
                    $property->layout = null;
                    break;
                case 'floor':
                    Storage::delete($property->floorFile);
                    $property->floor = null;
                    break;
            }

            flash('Successfully deleted')->success();
        }

        //-----ADD and UPDATE
        if($process == 'add' || $process == 'update'){
            switch ($field) {
                case 'bldg_permit':
                    $this->validate($request,[
                        'bldg_permit' => 'max:5120|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'bldg_permit.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $bldg_permit = $request->file('bldg_permit');
                    $bldg_permit->storeAs('public/files/'.$property->id.'/','bldg_permit'.'.'.$bldg_permit->getClientOriginalExtension());

                    $property->bldg_permit = url('storage/files/').'/'.$property->id.'/'.'bldg_permit'.'.'.$bldg_permit->getClientOriginalExtension();
                    break;
                case 'completion':
                    $this->validate($request,[
                        'completion' => 'max:5120|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'completion.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $completion = $request->file('completion');
                    $completion->storeAs('public/files/'.$property->id.'/','completion'.'.'.$completion->getClientOriginalExtension());

                    $property->completion = url('storage/files/').'/'.$property->id.'/'.'completion'.'.'.$completion->getClientOriginalExtension();
                    break;
                case 'deed':
                    $this->validate($request,[
                        'deed' => 'max:5120|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'deed.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $deed = $request->file('deed');
                    $deed->storeAs('public/files/'.$property->id.'/','deed'.'.'.$deed->getClientOriginalExtension());

                    $property->deed = url('storage/files/').'/'.$property->id.'/'.'deed'.'.'.$deed->getClientOriginalExtension();
                    break;
                case 'floor':
                    $this->validate($request,[
                        'floor' => 'max:5120|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'floor.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $floor = $request->file('floor');
                    $floor->storeAs('public/files/'.$property->id.'/','floor'.'.'.$floor->getClientOriginalExtension());

                    $property->floor = url('storage/files/').'/'.$property->id.'/'.'floor'.'.'.$floor->getClientOriginalExtension();
                    break;
                case 'layout':
                    $this->validate($request,[
                        'layout' => 'max:5120|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'layout.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $layout = $request->file('layout');
                    $layout->storeAs('public/files/'.$property->id.'/','layout'.'.'.$layout->getClientOriginalExtension());

                    $property->layout = url('storage/files/').'/'.$property->id.'/'.'layout'.'.'.$layout->getClientOriginalExtension();
                    break;
            }

            flash('Process Successfull')->success();
        }

        $property->save();
        $this->addLog(\Auth::user()->name.' updated a file in '.$property->name);
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $property = Property::findOrFail($id);
        if($property->owner()->first()){
            $owner = $property->owner()->first();
            $owner->prop_id = null;
            $owner->save();
        }

        if($property->renter()->first()){
            $renter = $property->renter()->first();
            $renter->prop_id = null;
            $renter->save();
        }

        if($property->god()->first()){
            $gods = $property->god()->get();
            foreach($gods as $god){
                $god->asset()->detach($id);
            }
        }

        if($property->furniture()->first()){
            $furns = $property->furniture()->get();
            foreach($furns as $furn){
                $furn->property()->detach($id);
            }
        }

        if($property->log()->first()){
            foreach($property->log()->get() as $log){
                if($log->invoice()->first()){
                    foreach($log->invoice()->get() as $invoice){
                        Storage::deleteDirectory('public/invoice/'.$log->id);
                    }
                }
            }
        }

        Storage::deleteDirectory('public/expense/'.$id);
        Storage::deleteDirectory('public/guarantee/'.$id);
        Storage::deleteDirectory('public/drawings/'.$id);

        Storage::delete($property->bldgPermitFile);
        Storage::delete($property->layoutFile);
        Storage::delete($property->deedFile);
        Storage::delete($property->floorFile);
        Storage::delete($property->completionFile);

        Property::destroy($id);
        $this->addLog(\Auth::user()->name.' deleted a property.');
        flash('Successfully Deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
