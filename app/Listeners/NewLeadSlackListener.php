<?php

namespace App\Listeners;

use App\Events\NewLead;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class NewLeadSlackListener
{
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
        $channel = config('services.slack.notifications.channel');

        Notification::route('slack', $channel)
            ->notify(new SlackNotification("New lead ({$event->category})"));
    }
}
