<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Services\MauticService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EbookDownloadController extends Controller
{
    /**
     * Download the ebook file.
     *
     * Note: Purchase validation will be implemented in Phase 4.
     * For now, uses email from hash parameter for Mautic tracking.
     *
     * @todo: In Phase 4.1, replace email with purchase hash for validation
     */
    public function download(Ebook $ebook, MauticService $mauticService): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        if (! $ebook->file || ! Storage::exists($ebook->file)) {
            abort(404, __('File not found.'));
        }

        // Track download in Mautic if asset ID exists
        if ($ebook->mautic_asset_id) {
            $hash = request()->query('hash');

            if ($hash) {
                // For now, hash is the contact email (will be purchase hash in Phase 4.1)
                $contactEmail = $hash;

                try {
                    $mauticService->trackAssetDownload($ebook->mautic_asset_id, $contactEmail);
                } catch (\Exception $e) {
                    // Log error but don't block download
                    Log::warning('Failed to track asset download in Mautic', [
                        'ebook_id' => $ebook->id,
                        'asset_id' => $ebook->mautic_asset_id,
                        'email' => $contactEmail,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return Storage::download($ebook->file);
    }
}
