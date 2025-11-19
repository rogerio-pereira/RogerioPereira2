<?php

namespace App\Listeners;

use App\Events\PurchaseConfirmation;
use App\Notifications\SlackNotification;
use Illuminate\Support\Facades\Notification;

class PurchaseSlackListener
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
    public function handle(PurchaseConfirmation $event): void
    {
        $channel = config('services.slack.notifications.channel');
        $value = number_format($event->purchase->amount, 2, '.', '');

        Notification::route('slack', $channel)
            ->notify(new SlackNotification("New Purchase of $value"));
    }
}
