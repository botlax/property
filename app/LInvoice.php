<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LInvoice extends Model
{
    protected $table = 'log_invoice';

	protected $fillable = [
        'desc', 'invoice', 'log_id'
    ];

    public $timestamps = false;

    public function log(){
    	return $this->belongsTo('App\Log', 'log_id');
    }

    public function getInvoiceFileAttribute(){
        return str_replace(url('storage'), 'public', $this->invoice);
    }
}
