<?php

namespace App\Services;

use Triibo\Mautic\Facades\Mautic;

class MauticService
{
    /**
     * Create a custom contact field.
     */
    public function createContactField(string $alias, string $type, string $label, array $properties = []): array
    {
        $data = [
            'alias' => $alias,
            'type' => $type,
            'label' => $label,
            'properties' => $properties,
        ];

        return Mautic::request('POST', 'fields/contact/new', $data);
    }

    /**
     * Update a contact field.
     */
    public function updateContactField(int $id, array $data): array
    {
        return Mautic::request('PATCH', "fields/contact/{$id}/edit", $data);
    }

    /**
     * Create an asset.
     */
    public function createAsset(string $name, string $url): array
    {
        $data = [
            'title' => $name,
            'storageLocation' => 'remote',
            'remotePath' => $url,
            'isPublished' => true,
        ];

        return Mautic::request('POST', 'assets/new', $data);
    }

    /**
     * Update an asset.
     */
    public function updateAsset(int $id, array $data): array
    {
        return Mautic::request('PATCH', "assets/{$id}/edit", $data);
    }

    /**
     * Unpublish an asset.
     */
    public function unpublishAsset(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateAsset($id, $unpublishData);
    }

    /**
     * Track asset download.
     * This registers a download event for the asset in Mautic.
     */
    public function trackAssetDownload(int $assetId, string $contactEmail): array
    {
        // Get or create contact by email
        $contact = $this->getContactByEmail($contactEmail);
        $contactId = null;

        if ($contact === null) {
            $contactResponse = $this->createOrUpdateContact($contactEmail, []);
            $contactId = $contactResponse['contact']['id'] ?? null;
        } else {
            $contactId = $contact['id'] ?? null;
        }

        if ($contactId === null) {
            throw new \RuntimeException('Failed to get or create contact for asset download tracking');
        }

        // Track asset download by adding contact to asset
        $data = [
            'contact' => $contactId,
        ];

        return Mautic::request('POST', "assets/{$assetId}/contact/{$contactId}/add", $data);
    }

    /**
     * Create an email.
     */
    public function createEmail(string $name, string $subject, string $html): array
    {
        $data = [
            'name' => $name,
            'subject' => $subject,
            'body' => $html,
            'emailType' => 'template',
            'isPublished' => true,
        ];

        return Mautic::request('POST', 'emails/new', $data);
    }

    /**
     * Update an email.
     */
    public function updateEmail(int $id, array $data): array
    {
        return Mautic::request('PATCH', "emails/{$id}/edit", $data);
    }

    /**
     * Unpublish an email.
     */
    public function unpublishEmail(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateEmail($id, $unpublishData);
    }

    /**
     * Create a campaign.
     */
    public function createCampaign(string $name, string $description = ''): array
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'isPublished' => true,
        ];

        return Mautic::request('POST', 'campaigns/new', $data);
    }

    /**
     * Update a campaign.
     */
    public function updateCampaign(int $id, array $data): array
    {
        return Mautic::request('PATCH', "campaigns/{$id}/edit", $data);
    }

    /**
     * Add email action to a campaign.
     */
    public function addEmailActionToCampaign(int $campaignId, int $emailId): array
    {
        // Get campaign details first
        $campaign = Mautic::request('GET', "campaigns/{$campaignId}");
        $campaignData = $campaign['campaign'] ?? [];

        // Get existing events or initialize empty array
        $events = $campaignData['events'] ?? [];
        $canvasSettings = $campaignData['canvasSettings'] ?? [];

        // Create email send action event
        $eventId = 'email_send_'.time();
        $emailActionEvent = [
            'id' => $eventId,
            'type' => 'email.send',
            'name' => 'Send Email',
            'description' => null,
            'order' => 1,
            'properties' => [
                'email' => $emailId,
            ],
            'triggerMode' => 'immediate',
            'triggerDate' => null,
            'anchor' => 'no',
            'anchorEventType' => null,
        ];

        // Add event to events array
        $events[$eventId] = $emailActionEvent;

        // Create source event (campaign source)
        $sourceEventId = 'source_'.time();
        $sourceEvent = [
            'id' => $sourceEventId,
            'type' => 'campaign.source',
            'name' => 'Campaign Source',
            'description' => null,
            'order' => 0,
            'properties' => [],
            'triggerMode' => 'immediate',
            'triggerDate' => null,
            'anchor' => 'no',
            'anchorEventType' => null,
        ];

        $events[$sourceEventId] = $sourceEvent;

        // Update canvas settings to connect source to email action
        $canvasSettings['nodes'][$sourceEventId] = [
            'position' => [
                'x' => 100,
                'y' => 100,
            ],
        ];

        $canvasSettings['nodes'][$eventId] = [
            'position' => [
                'x' => 300,
                'y' => 100,
            ],
        ];

        $canvasSettings['connections'][$sourceEventId] = [
            [
                'target' => $eventId,
                'anchors' => [
                    'source' => 'leadsource',
                    'target' => 'top',
                ],
            ],
        ];

        // Update campaign with events and canvas settings
        $updateData = [
            'events' => $events,
            'canvasSettings' => $canvasSettings,
        ];

        return $this->updateCampaign($campaignId, $updateData);
    }

    /**
     * Unpublish a campaign.
     */
    public function unpublishCampaign(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateCampaign($id, $unpublishData);
    }

    /**
     * Add a contact to a campaign.
     */
    public function addContactToCampaign(int $campaignId, int $contactId): array
    {
        $data = [
            'contact' => $contactId,
        ];

        return Mautic::request('POST', "campaigns/{$campaignId}/contact/{$contactId}/add", $data);
    }

    /**
     * Get contact by email.
     */
    public function getContactByEmail(string $email): ?array
    {
        $response = Mautic::request('GET', 'contacts', ['search' => $email]);

        $contacts = $response['contacts'] ?? [];
        if (empty($contacts)) {
            return null;
        }

        // Find contact with exact email match
        foreach ($contacts as $contact) {
            $contactFields = $contact['fields'] ?? [];
            $allFields = $contactFields['all'] ?? [];
            $contactEmail = $allFields['email'] ?? null;
            $isEmailMatch = $contactEmail === $email;

            if ($isEmailMatch) {
                return $contact;
            }
        }

        return null;
    }

    /**
     * Create or update a contact.
     * Mautic API automatically updates existing contact if email already exists.
     */
    public function createOrUpdateContact(string $email, array $data): array
    {
        $data['email'] = $email;

        return Mautic::request('POST', 'contacts/new', $data);
    }

    /**
     * Update a contact field value.
     */
    public function updateContactFieldValue(int $contactId, string $fieldAlias, string $value): array
    {
        $data = [
            $fieldAlias => $value,
        ];

        return Mautic::request('PATCH', "contacts/{$contactId}/edit", $data);
    }
}
