<?php

namespace App\Jobs;

use App\Models\Ebook;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SetupEbookJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Ebook $ebook
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Implementation will be done in Phase 2.2
    }
}
