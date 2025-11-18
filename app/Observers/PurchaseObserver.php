<?php

namespace App\Observers;

use App\Models\Purchase;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PurchaseObserver
{
    /**
     * Generate a URL-safe confirmation hash.
     */
    private function generateConfirmationHash(Purchase $purchase): string
    {
        $timestamp = Carbon::now();
        $hashString = $purchase->ebook_id.$purchase->email.$timestamp;
        $hash = Hash::make($hashString);

        // Convert to base64url (URL-safe base64 encoding)
        // Replace + with - and / with _ to make it URL-safe
        return strtr(base64_encode($hash), '+/', '-_');
    }

    /**
     * Handle the Purchase "created" event.
     */
    public function created(Purchase $purchase): void
    {
        // Generate confirmation hash if status is already completed
        if ($purchase->status === 'completed' && ! $purchase->confirmation_hash) {
            $purchase->confirmation_hash = $this->generateConfirmationHash($purchase);
            $purchase->saveQuietly(); // Use saveQuietly to avoid triggering another update event
        }
    }

    /**
     * Handle the Purchase "updated" event.
     */
    public function updated(Purchase $purchase): void
    {
        // Generate confirmation hash when status changes to completed
        if ($purchase->isDirty('status') && $purchase->status === 'completed' && ! $purchase->confirmation_hash) {
            $purchase->confirmation_hash = $this->generateConfirmationHash($purchase);
            $purchase->saveQuietly(); // Use saveQuietly to avoid triggering another update event
        }
    }
}
