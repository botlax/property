<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Renter;
use App\Payment;
use Carbon\Carbon;

class Invoice extends Mailable
{
    use Queueable, SerializesModels;

    public $renter;
    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Renter $renter, Payment $payment)
    {
        $this->renter = $renter;
        $this->payment = $payment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Invoice '. $this->payment->paydate->format('d/m/Y') )
                    ->from('it@talalcontracting.com','App Name')
                    ->view('vendor.notifications.invoice');
    }
}
