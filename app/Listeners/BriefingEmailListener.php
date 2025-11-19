<?php

namespace App\Listeners;

use App\Events\BriefingSubmitted;
use App\Mail\BriefingConfirmationEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class BriefingEmailListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BriefingSubmitted $event): void
    {
        Mail::to($event->briefing->email)
            ->queue(new BriefingConfirmationEmail($event->briefing));
    }
}
