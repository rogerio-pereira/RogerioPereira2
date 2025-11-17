<?php

namespace App\Observers;

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
}
