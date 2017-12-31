<?php

namespace App;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payment';

	protected $fillable = [
        'paydate', 'month', 'year', 'prop_id', 'amount', 'renter_id', 'cheque'
    ];

    public $timestamps = false;

    protected $dates = ['paydate'];

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function getChequeFileAttribute(){
        return str_replace(url('storage'), 'public', $this->cheque);
    }
}
