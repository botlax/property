<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

	protected $fillable = [
        'name', 'bldg_permit', 'loc_long', 'loc_lat', 'location', 'fee', 'desc', 'p_area', 'b_area', 'elec', 'water', 'completion', 'deed', 'layout', 'floor'
    ];

    public function renter(){
    	return $this->hasOne('App\Renter', 'prop_id');
    }

    public function payment(){
        return $this->hasMany('App\Payment', 'prop_id');
    }

    public function owner(){
        return $this->hasOne('App\User', 'prop_id');
    }

    public function god(){
        return $this->belongsToMany('App\User', 'prop_user', 'property_id', 'user_id');
    }

    public function log(){
    	return $this->hasMany('App\Log', 'prop_id');
    }

    public function drawing(){
        return $this->hasMany('App\Drawing', 'prop_id');
    }

    public function furniture(){
        return $this->belongsToMany('App\Furniture', 'prop_fur', 'property_id', 'furniture_id')->withPivot('num');
    }

    public function expense(){
        return $this->hasMany('App\Expense', 'prop_id');
    }

    public function guarantee(){
        return $this->hasMany('App\Guarantee', 'prop_id');
    }

    public $timestamps = false;

    public function getBldgPermitFileAttribute(){
        return str_replace(url('storage'), 'public', $this->bldg_permit);
    }

    public function getCompletionFileAttribute(){
        return str_replace(url('storage'), 'public', $this->completion);
    }

    public function getDeedFileAttribute(){
        return str_replace(url('storage'), 'public', $this->deed);
    }

    public function getLayoutFileAttribute(){
        return str_replace(url('storage'), 'public', $this->layout);
    }

    public function getFloorFileAttribute(){
        return str_replace(url('storage'), 'public', $this->floor);
    }
}
