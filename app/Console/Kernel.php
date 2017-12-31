<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use App\Payment;
use App\Property;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function () {
            $currentMonth = Carbon::today()->format('n');
            $currentYear = Carbon::today()->format('Y');
            $current = $currentYear.$currentMonth;
            $properties = Property::where('for_rent','yes')->get();

            foreach($properties as $prop){

                $lastPayment = $prop->payment()->orderBy('year','DESC')->orderBy('month','DESC')->get();
                $hasRenter = $prop->renter()->first();
                $record = [];

                foreach($lastPayment as $pay){
                     $record[] = $pay->year.$pay->month;
                }

                if((empty($lastPayment) || !in_array($current, $record)) && $hasRenter){

                    $data['month'] = intval($currentMonth);
                    $data['year'] = intval($currentYear);
                    $data['renter_id'] = intval($hasRenter->id);

                    $payment = Payment::create($data);

                    $prop->payment()->save($payment);
                }
            }
                
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
