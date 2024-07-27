<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Mail\SendMail;
use Illuminate\Console\Command;
use App\Models\ReceivingSchedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendReceivingNotification;

class CheckReceivingTimes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'receiving:check-times';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check receiving times and send notifications to users';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $time = Carbon::now();
        $now = $time->addHours(3);
        $startOfMinute = $now->copy()->startOfMinute();
            $endOfMinute = $now->copy()->endOfMinute();
            Log::info('Current time: ' . $now->toDateTimeString());
            $schedules = ReceivingSchedule::whereBetween('receiving_time', [$startOfMinute, $endOfMinute])->get();
            // Log::info('schedules: ' . $schedules);
    
            foreach ($schedules as $schedule) {
                $email = $schedule->user->email;
                Log::info('Schedule found for user: ' . $schedule->user->email);
                $data = [
                    'name' => $schedule->user->userInfo->full_name,
                    'time' => $schedule->user->receivingSchedule->receiving_time,
                    'point' => $schedule->user->receivingSchedule->receivingPoint->name
                ];
                // Log::info(  $data);
                // SendReceivingNotification::dispatch($schedule->user);
                Mail::to($email)->send(new SendMail($data));
            }
    
            return 0;
        
    }
}
