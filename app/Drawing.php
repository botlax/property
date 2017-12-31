<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Drawing extends Model
{
    protected $table = 'drawings';

	protected $fillable = [
        'drawing', 'prop_id'
    ];

    public $timestamps = false;

    public function property(){
    	return $this->belongsTo('App\Property', 'prop_id');
    }

    public function getDrawingFileAttribute(){
        return str_replace(url('storage'), 'public', $this->drawing);
    }

    public function getDrawingFileNameAttribute(){
        return str_replace(url('storage').'/drawings/'.$this->property()->first()->id.'/', '', $this->drawing);
    }
}
