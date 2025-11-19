<?php

namespace App\Listeners;

use App\Events\PurchaseConfirmation;
use App\Mail\EbookDownloadEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class PurchaseEmailListener implements ShouldQueue
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
    public function handle(PurchaseConfirmation $event): void
    {
        // Load the ebook relationship to access category
        $event->purchase->load('ebook.category');

        Mail::to($event->purchase->email)
            ->queue(new EbookDownloadEmail($event->purchase));
    }
}
