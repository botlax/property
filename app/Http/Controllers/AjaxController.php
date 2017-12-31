<?php

namespace App\Http\Controllers;

use App\Property;
use App\Act;
use Illuminate\Http\Request;
use App\Furniture;
use Carbon\Carbon;
use JsonResponse;

class AjaxController extends Controller
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
    
    public function getPendingPayment(Request $request){
        
        $property = Property::findOrFail($request->input('id'));
        $payment = $property->payment()->whereNull('paydate')->select('month', 'year')->get()->toArray();

        $payment['count'] = count($payment);

        if($payment['count'] == 0){
            echo json_encode([]);
        }
        else{
            echo json_encode($payment);
        }

    }   

    public function storeFurn(Request $request){
    	$this->validate($request,[
    		'name' => 'required|unique:furnitures'
    	]);

    	$furniture = Furniture::create($request->all());
    	$this->addLog(\Auth::user()->name.' added an asset.');
    	echo json_encode(['message' => 'Successfully added.','id' => $furniture->id]);
    }

    public function deleteFurn(Request $request){
    	
        $furn = Furniture::findOrFail($request->input('id'));

        if($furn->property()->first()){
            $properties = $furn->property()->get();
            foreach ($properties as $prop) {
                $prop->furniture()->detach($request->input('id'));
            }
        }

    	if(Furniture::destroy($request->input('id'))){
    		echo json_encode(['message' => 'Successfully deleted.']);
    	}
    	else{
    		return response()->json(['error' => $request->input('id')], 422);
    	}

    	$this->addLog(\Auth::user()->name.' deleted an asset.');
    	
    }

    public function updateFurn(Request $request){

    	$furniture = Furniture::findOrFail($request->input('id'));

    	$this->validate($request,[
    		'name' => 'required|unique:furnitures,name,'.$furniture->id
    	]);

    	$furniture->name = $request->input('name');
    	$furniture->save();

    	$this->addLog(\Auth::user()->name.' updated an asset.');
    	echo json_encode(['message' => 'Successfully updated.','id' => $furniture->id,'name' => $furniture->name]);
    	
    }

    public function addLog($log){
        $data['date'] = Carbon::now();
        $data['desc'] = $log;
        Act::create($data);
    }
}
