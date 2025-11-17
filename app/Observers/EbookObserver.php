<?php

namespace App\Observers;

use App\Jobs\DeactivateEbookJob;
use App\Jobs\SetupEbookJob;
use App\Jobs\UpdateEbookJob;
use App\Models\Ebook;
use Illuminate\Support\Str;

class EbookObserver
{
    /**
     * Handle the Ebook "creating" event.
     */
    public function creating(Ebook $ebook): void
    {
        $slug = Str::slug($ebook->name);

        // Generate slug automatically if not provided
        if (empty($ebook->slug) && ! empty($ebook->name)) {
            $ebook->slug = $slug;
        }
    }

    /**
     * Handle the Ebook "created" event.
     */
    public function created(Ebook $ebook): void
    {
        SetupEbookJob::dispatch($ebook);
    }

    /**
     * Handle the Ebook "updated" event.
     */
    public function updated(Ebook $ebook): void
    {
        UpdateEbookJob::dispatch($ebook);
    }

    /**
     * Handle the Ebook "deleted" event.
     */
    public function deleted(Ebook $ebook): void
    {
        DeactivateEbookJob::dispatch($ebook);
    }
}
