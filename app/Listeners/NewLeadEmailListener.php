<?php

namespace App\Listeners;

use App\Events\NewLead;
use App\Mail\NewLeadEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class NewLeadEmailListener implements ShouldQueue
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
    public function handle(NewLead $event): void
    {
        Mail::to($event->contact->email)
            ->queue(new NewLeadEmail($event->contact, $event->category));
    }
}
