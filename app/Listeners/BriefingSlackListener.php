<?php

namespace App\Listeners;

use App\Events\BriefingSubmitted;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class BriefingSlackListener
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
    public function handle(BriefingSubmitted $event): void
    {
        $channel = config('services.slack.notifications.channel');

        Notification::route('slack', $channel)
            ->notify(new SlackNotification('New briefing request'));
    }
}
