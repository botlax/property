<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress';

	protected $fillable = [
        'desc', 'log_date', 'log_id'
    ];

    protected $dates = ['log_date'];

    public $timestamps = false;

    public function log(){
    	return $this->belongsTo('App\Log', 'log_id');
    }
}
