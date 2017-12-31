<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'admin', 'prop_id', 'property_id', 'mobile', 'address', 'job', 'company', 'co_address', 'co_contact', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function property(){
        return $this->belongsTo('App\Property', 'prop_id');
    }

    public function asset(){
        return $this->belongsToMany('App\Property', 'prop_user', 'user_id', 'property_id');
    }

    public function getQidFileAttribute(){
        return str_replace(url('storage'), 'public', $this->qid);
    }

    public function scopeCurrent($query){
        return $query->whereNull('prev')->where('admin','!=','admin');
    }

    public function scopePast($query){
        return $query->whereNotNull('prev');
    }

    public function isAdmin(){
        if($this->admin == "no"){
            return false;
        }
        else{
            return true;
        }
    }

    public function isGod(){
        if($this->role == "admin"){
            return true;
        }
        else{
            return false;
        }
    }

    public function isPower(){
        if($this->role == "power"){
            return true;
        }
        else{
            return false;
        }
    }

    public function isSpec(){
        if($this->role == "spec"){
            return true;
        }
        else{
            return false;
        }
    }
}
