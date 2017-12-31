<?php

namespace App\Http\Controllers;

use App\User;
use App\Property;
use App\Act;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
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
        $owners = User::current()->get();
        return view('dashboard.users',compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::whereDoesntHave('renter')->whereDoesntHave('owner')->where('for_rent','no')->pluck('name','id')->toArray();

        $assets = Property::all()->pluck('name','id')->toArray();

        //dd($properties);

        return view('dashboard.user-add',compact('properties','assets'));
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
            'email' => 'required|email|unique:users,email',
            'qid' => 'nullable|mimes:pdf,jpg,jpeg,png|max:2048',
            'password' => 'confirmed|required|min:6',
            'properties' => 'nullable',
            'mobile' => 'nullable|numeric',
            'co_contact' => 'nullable|numeric',
            'co_address' => 'nullable',
            'address' => 'nullable',
            'company' => 'nullable',
            'job' => 'nullable',
            'role' => 'nullable',
        ]);

        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = bcrypt($request->input('password'));
        $data['address'] = $request->input('address');
        $data['mobile'] = $request->input('mobile');
        $data['job'] = $request->input('job');
        $data['company'] = $request->input('company');
        $data['co_address'] = $request->input('co_address');
        $data['co_contact'] = $request->input('co_contact');

        $owner = User::create($data);

        if($request->input('properties')){
            $property = Property::findOrFail($request->input('properties'));
            $property->owner()->save($owner);
        }

        if($request->input('asset')){
            $owner->asset()->attach($request->input('asset'));
        }

        $qid = $request->file('qid');

        if($qid){
            $qid->storeAs('public/qid/user/',$renter->id.'.'.$qid->getClientOriginalExtension());
            $renter->qid = url('storage/qid/user/').'/'.$renter->id.'.'.$qid->getClientOriginalExtension();
        }

        $admin = $request->input('admin');
        $role = $request->input('role');

        if($admin){
            $owner->admin = 'yes';
            if($role){
            	$owner->role = $role;
            }
            else{
            	$owner->role = 'spec';
            }
        }
        else{
            $owner->admin = 'no';
        }

        $owner->save();

        $this->addLog(\Auth::user()->name.' added an owner.');
        flash('Successfully added')->success();
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAdmin(Request $request)
    {
    	$this->validate($request,[
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'confirmed|required|min:6',
            'role' => 'nullable',
        ]);

        $data = [];
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['password'] = bcrypt($request->input('password'));
        $data['admin'] = 'admin';

        if($request->input('role')){
        	$data['role'] = $request->input('role');
        }else{
        	$data['role'] = 'spec';
        }

        //dd($data);

        $admin = User::create($data);

        $this->addLog(\Auth::user()->name.' added an administrator.');
        flash('Successfully created')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $prop = $user->property()->first();

        if($user->asset()->first()){
            $asset = $user->asset()->pluck('id')->toArray();
        }else{
            $asset = [];
        }

        $propOpt = Property::where('for_rent','no')->where('id','!=',$prop?$prop->id:0)->whereDoesntHave('owner')->pluck('name','id')->toArray();

        $assetOpt = Property::whereNotIn('id',$asset)->pluck('name','id')->toArray();

        //dd($user->property()->first()->toArray());
        return view('dashboard.user',compact('user','propOpt','assetOpt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function admins()
    {
    	$owners = User::where('admin','yes')->where('id','!=',\Auth::user()->id)->get();
    	$admins = User::where('admin','admin')->where('id','!=',\Auth::user()->id)->get();
        return view('dashboard.admins',compact('admins','owners'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function passwords()
    {
    	$self = \Auth::user();
    	$owners = User::where('admin','yes')->where('id','!=',\Auth::user()->id)->get();
    	$admins = User::where('admin','admin')->where('id','!=',\Auth::user()->id)->get();
        return view('dashboard.passwords',compact('admins','owners','self'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $process = $request->input('process');
        $field = $request->input('field');
        $user = User::findOrFail($id);

        //-----DELETE
        if($process == 'delete'){
            switch ($field) {
                case 'qid':
                    Storage::delete($user->qidFile);
                    $user->qid = null;
                    break;
                case 'property':
                    $user->prop_id = null;
                    break;
                case 'mobile':
                    $user->mobile = null;
                    break;
                case 'address':
                    $user->address = null;
                    break;
                case 'job':
                    $user->job = null;
                    break;
                case 'co_address':
                    $user->co_address = null;
                    break;
                case 'co_contact':
                    $user->co_contact = null;
                    break;
                case 'asset':
                    $user->asset()->detach($request->input('asset'));
                    break;
                case 'admin':
                    $user->admin = 'no';
                    $user->role = null;
                    break;
                case 'god':
                    User::destroy($id);
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
                    $user->name = $request->input('name');
                    break;
                case 'email':
                    $this->validate($request,[
                        'email' => 'required|email|unique:users,email,'.$user->id
                    ]);
                    $user->email = $request->input('email');
                    break;
                case 'mobile':
                    $this->validate($request,[
                        'mobile' => 'required|numeric'
                    ]);
                    $user->mobile = $request->input('mobile');
                    break;
                case 'address':
                    $this->validate($request,[
                        'address' => 'required'
                    ]);
                    $user->address = $request->input('address');
                    break;
                case 'job':
                    $this->validate($request,[
                        'job' => 'required'
                    ]);
                    $user->job = $request->input('job');
                    break;
                case 'co_address':
                    $this->validate($request,[
                        'co_address' => 'required'
                    ]);
                    $user->co_address = $request->input('co_address');
                    break;
                case 'co_contact':
                    $this->validate($request,[
                        'co_contact' => 'required|numeric'
                    ]);
                    $user->co_contact = $request->input('co_contact');
                    break;
                case 'password':
                    $this->validate($request,[
                        'current_password' => 'required',
                        'password' => 'required|confirmed',
                    ]);

                    if(!Hash::check($request->input('current_password'),$user->password)){
                        flash('Your current password did not match your input.')->error()->important();
                        return redirect()->back();
                    }
                    $user->password = bcrypt($request->input('password'));
                    break;
                case 'qid':
                    $this->validate($request,[
                        'qid' => 'max:2048|required|mimes:pdf,jpg,jpeg',
                    ],[
                        'qid.mimes' => 'Only pdf & jpg are allowed'
                    ]);

                    $qid = $request->file('qid');
                    $qid->storeAs('public/qid/user/',$user->id.'.'.$qid->getClientOriginalExtension());

                    $user->qid = url('storage/qid/user/').'/'.$user->id.'.'.$qid->getClientOriginalExtension();
                    break;
                case 'property':
                    $user->prop_id = $request->input('property');
                    break;
                case 'asset':
                    $user->asset()->attach($request->input('asset'));
                    break;

                case 'admin':
                	if($request->input('admin')){
                		$user->admin = 'yes';
                		if($request->input('role')){
                			$user->role = $request->input('role');
                		}
                		else{
                			$user->role = 'spec';
                		}
                	}else{
                		$user->admin = 'no';
                		$user->role = null;
                	}
                    break;
                case 'god':
                    $user->role = $request->input('role');
                    break;
                case 'passcode':
                    $this->validate($request,[
                        'password' => 'required|confirmed',
                    ]);
                    $user->password = bcrypt($request->input('password'));
                    break;
            }

            flash('Process Successfull')->success();
        }

        $user->save();

        $this->addLog(\Auth::user()->name.' updated a user.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->property()->first()){
            $user->prop_id = null;
        }

        if($user->asset()->first()){
            $assets = $user->asset()->get();
            foreach ($assets as $asset) {
                $asset->god()->detach($id);
            }
        }

        $user->prev = 'yes';
        $user->save();

        $this->addLog(\Auth::user()->name.' deleted a user.');
        flash('Successfully deleted')->success();
        return redirect()->back();
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
