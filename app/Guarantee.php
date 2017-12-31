<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    protected $table = 'guarantees';

	protected $fillable = [
        'file', 'desc', 'from', 'to', 'prop_id'
    ];

    public $timestamps = false;

    protected $dates = ['to', 'from'];

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function getGuaranteeFileAttribute(){
        return str_replace(url('storage'), 'public', $this->file);
    }
}
