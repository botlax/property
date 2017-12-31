<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';

	protected $fillable = [
        'file', 'desc', 'cost', 'prop_id', 'date'
    ];

    public $timestamps = false;

    protected $dates = ['date'];

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function getExpenseFileAttribute(){
        return str_replace(url('storage'), 'public', $this->file);
    }
}
