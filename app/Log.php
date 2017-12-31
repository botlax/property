<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

	protected $fillable = [
        'desc', 'log_date', 'prop_id', 'cost', 'close_date', 'complainer', 'mobile', 'status'
    ];

    public $timestamps = false;

    protected $dates = ['log_date', 'close_date'];

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function invoice(){
    	return $this->hasMany('App\LInvoice', 'log_id');
    }

    public function progress(){
        return $this->hasMany('App\Progress', 'log_id');
    }
}
