<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

	protected $fillable = [
        'from', 'to', 'status', 'months'
    ];

    public $timestamps = false;

    protected $dates = ['from', 'to'];
}
