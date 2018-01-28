<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Renter extends Model
{
	use Notifiable;

	protected $table = 'renter';

	protected $fillable = [
        'name', 'contract', 'p_contract', 'email', 'prop_id', 'qid', 'prev', 'cr', 'permit', 'mobile', 'address', 'company', 'co_address', 'co_person', 'co_mobile', 'co_contact'
    ];

    public $timestamps = false;
    
    public function payment(){
    	return $this->hasMany('App\Payment', 'renter_id');
    }

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function scopeCurrent($query){
        return $query->whereNull('prev');
    }

    public function scopePast($query){
        return $query->whereNotNull('prev');
    }

    public function getQidFileAttribute(){
        return str_replace(url('storage'), 'public', $this->qid);
    }

    public function getCrFileAttribute(){
        return str_replace(url('storage'), 'public', $this->cr);
    }

    public function getPermitFileAttribute(){
        return str_replace(url('storage'), 'public', $this->permit);
    }

    public function getContractFileAttribute(){
        return str_replace(url('storage'), 'public', $this->contract);
    }

    public function getPcontractFileAttribute(){
        return str_replace(url('storage'), 'public', $this->p_contract);
    }

}
