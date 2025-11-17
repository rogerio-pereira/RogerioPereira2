<?php

namespace App\Jobs;

use App\Models\Ebook;
use App\Services\MauticService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
    public function handle(MauticService $mauticService): void
    {
        $ebook = $this->ebook->fresh(['category']);

        // Verify ebook has slug
        if (empty($ebook->slug)) {
            $slug = Str::slug($ebook->name);
            $ebook->update(['slug' => $slug]);
            $ebook->refresh();
        }

        // Verify ebook has file
        if (empty($ebook->file)) {
            Log::warning('SetupEbookJob: Ebook does not have a file', [
                'ebook_id' => $ebook->id,
                'ebook_name' => $ebook->name,
            ]);
            throw new \RuntimeException('Ebook must have a file to create Mautic asset');
        }

        $createdResources = [];
        $rollbackNeeded = false;

        try {
            // Create custom contact field
            $fieldAlias = "ebook_{$ebook->slug}_purchased";
            $fieldLabel = "E-book {$ebook->name} - Download Hash";
            $fieldResponse = $mauticService->createContactField($fieldAlias, 'text', $fieldLabel);
            $fieldId = $fieldResponse['field']['id'] ?? null;

            if ($fieldId === null) {
                throw new \RuntimeException('Failed to create Mautic contact field');
            }

            $createdResources['field'] = $fieldId;
            $ebook->mautic_field_id = $fieldId;
            $ebook->mautic_field_alias = $fieldAlias;
            $ebook->save();

            // Create asset
            $downloadUrl = route('ebooks.download', $ebook);
            $assetResponse = $mauticService->createAsset($ebook->name, $downloadUrl);
            $assetId = $assetResponse['asset']['id'] ?? null;

            if ($assetId === null) {
                throw new \RuntimeException('Failed to create Mautic asset');
            }

            $createdResources['asset'] = $assetId;
            $ebook->mautic_asset_id = $assetId;
            $ebook->save();

            // Create email
            $emailName = "deliver_ebook_{$ebook->slug}";
            $emailSubject = "Your e-book: {$ebook->name}";
            $emailHtml = $this->generateEmailTemplate($ebook, $fieldAlias);
            $emailResponse = $mauticService->createEmail($emailName, $emailSubject, $emailHtml);
            $emailId = $emailResponse['email']['id'] ?? null;

            if ($emailId === null) {
                throw new \RuntimeException('Failed to create Mautic email');
            }

            $createdResources['email'] = $emailId;
            $ebook->mautic_email_id = $emailId;
            $ebook->mautic_email_name = $emailName;
            $ebook->last_email_html = $emailHtml;
            $ebook->save();

            // Create campaign
            $campaignName = "campaign_deliver_ebook_{$ebook->slug}";
            $campaignDescription = "Automatic delivery of e-book {$ebook->name}";
            $campaignResponse = $mauticService->createCampaign($campaignName, $campaignDescription);
            $campaignId = $campaignResponse['campaign']['id'] ?? null;

            if ($campaignId === null) {
                throw new \RuntimeException('Failed to create Mautic campaign');
            }

            $createdResources['campaign'] = $campaignId;

            // Add email action to campaign
            $mauticService->addEmailActionToCampaign($campaignId, $emailId);

            $ebook->mautic_campaign_id = $campaignId;
            $ebook->save();

        } catch (\Exception $e) {
            $rollbackNeeded = true;
            Log::error('SetupEbookJob failed', [
                'ebook_id' => $ebook->id,
                'error' => $e->getMessage(),
                'created_resources' => $createdResources,
            ]);

            // Rollback created resources
            $this->rollbackResources($mauticService, $createdResources);

            throw $e;
        }
    }

    /**
     * Generate email template HTML.
     *
     * @todo: In Phase 4.1, replace contact.email with contact.{$fieldAlias} (purchase hash)
     */
    private function generateEmailTemplate(Ebook $ebook, string $fieldAlias): string
    {
        $downloadUrl = route('ebooks.download', $ebook);
        // For now, use contact email as hash (will be replaced with purchase hash in Phase 4.1)
        $hashPlaceholder = '{{contact.email}}';

        $categoryName = $ebook->category->name;
        $categoryName = strtolower($categoryName);
        $categoryName = str_replace(' ', '_', $categoryName);
        $templateName = "emails.ebook_delivery_{$categoryName}";

        // Fallback to marketing template if template doesn't exist
        if (! view()->exists($templateName)) {
            $templateName = 'emails.ebook_delivery_marketing';
        }

        return view($templateName, [
            'ebookName' => $ebook->name,
            'downloadUrl' => $downloadUrl,
            'hashPlaceholder' => $hashPlaceholder,
        ])->render();
    }

    /**
     * Rollback created resources in case of error.
     */
    private function rollbackResources(MauticService $mauticService, array $createdResources): void
    {
        if (isset($createdResources['campaign'])) {
            try {
                $mauticService->unpublishCampaign($createdResources['campaign']);
            } catch (\Exception $e) {
                Log::warning('Failed to rollback campaign', [
                    'campaign_id' => $createdResources['campaign'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if (isset($createdResources['email'])) {
            try {
                $mauticService->unpublishEmail($createdResources['email']);
            } catch (\Exception $e) {
                Log::warning('Failed to rollback email', [
                    'email_id' => $createdResources['email'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if (isset($createdResources['asset'])) {
            try {
                $mauticService->unpublishAsset($createdResources['asset']);
            } catch (\Exception $e) {
                Log::warning('Failed to rollback asset', [
                    'asset_id' => $createdResources['asset'],
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Note: Contact fields cannot be deleted via API, so we skip rollback for fields
    }
}
