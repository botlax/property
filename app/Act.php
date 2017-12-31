<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
    protected $table = 'act';

	protected $fillable = [
        'date', 'desc'
    ];

    public $timestamps = false;

    protected $dates = ['date'];

}
