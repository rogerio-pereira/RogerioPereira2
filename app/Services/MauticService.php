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
