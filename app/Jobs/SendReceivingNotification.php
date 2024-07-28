<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendReceivingNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = $this->user->email;
        $data = [
            'name' => $this->user->userInfo->full_name,
            'time' => $this->user->receivingSchedule->receiving_time,
            'point' => $this->user->receivingSchedule->receivingPoint->name
        ];
        // dd($data);
        Log::info('Sending email to ' . $email);
        Mail::send('emails.receiving_notification', $data, function($message) use ($email) {
            $message->to($email)->subject('موعد استلامك للمساعدات');
        });
        Log::info('Email sent to ' . $email);
    }
}
