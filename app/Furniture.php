<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    protected $table = 'furnitures';

	protected $fillable = [
        'name'
    ];

    public function property(){
        return $this->belongsToMany('App\Property', 'prop_fur', 'furniture_id', 'property_id')->withPivot('num');
    }

    public $timestamps = false;
}
