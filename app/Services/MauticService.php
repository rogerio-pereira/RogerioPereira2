<?php

namespace App\Services;

class MauticService extends HttpClient
{
    protected OAuth2ClientCredentialsAuth $auth;

    public function __construct()
    {
        $config = config('services.mautic');

        $url = rtrim($config['url'] ?? '');
        $clientId = $config['client_id'] ?? '';
        $clientSecret = $config['client_secret'] ?? '';

        $this->validateConfiguration($url, $clientId, $clientSecret);

        $this->auth = new OAuth2ClientCredentialsAuth(
            $url,
            $clientId,
            $clientSecret,
            '/oauth/v2/token',
            'mautic_access_token'
        );

        $apiBaseUrl = "{$url}/api";
        parent::__construct($apiBaseUrl);
    }

    /*
     * =====================================================================================================================
     * OVERWRITTEN METHODS
     * =====================================================================================================================
     */
    protected function getBearerToken(): ?string
    {
        return $this->auth->getAccessToken();
    }

    /*
     * =====================================================================================================================
     * CLASS METHODS
     * =====================================================================================================================
     */
    protected function validateConfiguration(string $url, string $clientId, string $clientSecret): void
    {
        if (empty($url)) {
            throw new \RuntimeException('Mautic URL is not configured. Please check your .env file.');
        }

        if (empty($clientId)) {
            throw new \RuntimeException('Mautic Client ID is not configured. Please check your .env file.');
        }

        if (empty($clientSecret)) {
            throw new \RuntimeException('Mautic Client Secret is not configured. Please check your .env file.');
        }
    }

    public function createContactField(string $alias, string $type, string $label, array $properties = []): array
    {
        $data = [
            'alias' => $alias,
            'type' => $type,
            'label' => $label,
            'properties' => $properties,
        ];

        return $this->request('POST', 'fields/contact/new', $data);
    }

    public function updateContactField(int $id, array $data): array
    {
        $endpoint = "fields/contact/{$id}/edit";

        return $this->request('PATCH', $endpoint, $data);
    }

    public function createAsset(string $name, string $url): array
    {
        $data = [
            'title' => $name,
            'storageLocation' => 'remote',
            'remotePath' => $url,
            'isPublished' => true,
        ];

        return $this->request('POST', 'assets/new', $data);
    }

    public function updateAsset(int $id, array $data): array
    {
        $endpoint = "assets/{$id}/edit";

        return $this->request('PATCH', $endpoint, $data);
    }

    public function unpublishAsset(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateAsset($id, $unpublishData);
    }

    public function trackAssetDownload(int $assetId, string $contactEmail): array
    {
        $contact = $this->getContactByEmail($contactEmail);
        $contactId = $this->getOrCreateContactId($contact, $contactEmail);

        $data = ['contact' => $contactId];
        $endpoint = "assets/{$assetId}/contact/{$contactId}/add";

        return $this->request('POST', $endpoint, $data);
    }

    protected function getOrCreateContactId(?array $contact, string $contactEmail): int
    {
        if ($contact !== null) {
            $contactId = $contact['id'] ?? null;
            if ($contactId !== null) {
                return $contactId;
            }
        }

        $contactResponse = $this->createOrUpdateContact($contactEmail, []);
        $contactId = $contactResponse['contact']['id'] ?? null;

        if ($contactId === null) {
            throw new \RuntimeException('Failed to get or create contact for asset download tracking');
        }

        return $contactId;
    }

    public function createEmail(string $name, string $subject, string $html): array
    {
        $data = [
            'name' => $name,
            'subject' => $subject,
            'body' => $html,
            'emailType' => 'template',
            'isPublished' => true,
        ];

        return $this->request('POST', 'emails/new', $data);
    }

    public function updateEmail(int $id, array $data): array
    {
        $endpoint = "emails/{$id}/edit";

        return $this->request('PATCH', $endpoint, $data);
    }

    public function unpublishEmail(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateEmail($id, $unpublishData);
    }

    public function createCampaign(string $name, string $description = ''): array
    {
        $data = [
            'name' => $name,
            'description' => $description,
            'isPublished' => true,
        ];

        return $this->request('POST', 'campaigns/new', $data);
    }

    public function updateCampaign(int $id, array $data): array
    {
        $endpoint = "campaigns/{$id}/edit";

        return $this->request('PATCH', $endpoint, $data);
    }

    public function addEmailActionToCampaign(int $campaignId, int $emailId): array
    {
        $campaign = $this->getCampaign($campaignId);
        $campaignData = $this->extractCampaignData($campaign);

        $emailEventId = $this->generateEmailEventId();
        $sourceEventId = $this->generateSourceEventId();

        $events = $this->buildCampaignEvents($campaignData, $emailId, $emailEventId, $sourceEventId);
        $canvasSettings = $this->buildCanvasSettings($campaignData, $sourceEventId, $emailEventId);

        $updateData = [
            'events' => $events,
            'canvasSettings' => $canvasSettings,
        ];

        return $this->updateCampaign($campaignId, $updateData);
    }

    protected function getCampaign(int $campaignId): array
    {
        $endpoint = "campaigns/{$campaignId}";

        return $this->request('GET', $endpoint);
    }

    protected function extractCampaignData(array $campaign): array
    {
        $campaignData = $campaign['campaign'] ?? [];

        return [
            'events' => $campaignData['events'] ?? [],
            'canvasSettings' => $campaignData['canvasSettings'] ?? [],
        ];
    }

    protected function buildCampaignEvents(
        array $campaignData,
        int $emailId,
        string $emailEventId,
        string $sourceEventId
    ): array {
        $events = $campaignData['events'];

        $emailEvent = $this->createEmailSendEvent($emailEventId, $emailId);
        $sourceEvent = $this->createSourceEvent($sourceEventId);

        $events[$emailEventId] = $emailEvent;
        $events[$sourceEventId] = $sourceEvent;

        return $events;
    }

    protected function generateEmailEventId(): string
    {
        return 'email_send_'.time();
    }

    protected function generateSourceEventId(): string
    {
        return 'source_'.time();
    }

    protected function createEmailSendEvent(string $eventId, int $emailId): array
    {
        return [
            'id' => $eventId,
            'type' => 'email.send',
            'name' => 'Send Email',
            'description' => null,
            'order' => 1,
            'properties' => ['email' => $emailId],
            'triggerMode' => 'immediate',
            'triggerDate' => null,
            'anchor' => 'no',
            'anchorEventType' => null,
        ];
    }

    protected function createSourceEvent(string $eventId): array
    {
        return [
            'id' => $eventId,
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
    }

    protected function buildCanvasSettings(
        array $campaignData,
        string $sourceEventId,
        string $emailEventId
    ): array {
        $canvasSettings = $campaignData['canvasSettings'];

        $sourceNodePosition = $this->createNodePosition(100, 100);
        $emailNodePosition = $this->createNodePosition(300, 100);
        $connection = $this->createConnection($emailEventId);

        $canvasSettings['nodes'][$sourceEventId] = $sourceNodePosition;
        $canvasSettings['nodes'][$emailEventId] = $emailNodePosition;
        $canvasSettings['connections'][$sourceEventId] = $connection;

        return $canvasSettings;
    }

    protected function createNodePosition(int $x, int $y): array
    {
        return [
            'position' => [
                'x' => $x,
                'y' => $y,
            ],
        ];
    }

    protected function createConnection(string $targetEventId): array
    {
        return [
            [
                'target' => $targetEventId,
                'anchors' => [
                    'source' => 'leadsource',
                    'target' => 'top',
                ],
            ],
        ];
    }

    public function unpublishCampaign(int $id): array
    {
        $unpublishData = ['isPublished' => false];

        return $this->updateCampaign($id, $unpublishData);
    }

    public function addContactToCampaign(int $campaignId, int $contactId): array
    {
        $data = ['contact' => $contactId];
        $endpoint = "campaigns/{$campaignId}/contact/{$contactId}/add";

        return $this->request('POST', $endpoint, $data);
    }

    public function getContactByEmail(string $email): ?array
    {
        $query = ['search' => $email];
        $response = $this->request('GET', 'contacts', [], $query);

        $contacts = $response['contacts'] ?? [];

        if (empty($contacts)) {
            return null;
        }

        return $this->findContactByExactEmail($contacts, $email);
    }

    protected function findContactByExactEmail(array $contacts, string $email): ?array
    {
        foreach ($contacts as $contact) {
            $contactEmail = $this->extractContactEmail($contact);

            if ($contactEmail === $email) {
                return $contact;
            }
        }

        return null;
    }

    protected function extractContactEmail(array $contact): ?string
    {
        $contactFields = $contact['fields'] ?? [];
        $allFields = $contactFields['all'] ?? [];

        return $allFields['email'] ?? null;
    }

    public function createOrUpdateContact(string $email, array $data): array
    {
        $data['email'] = $email;

        return $this->request('POST', 'contacts/new', $data);
    }

    public function updateContactFieldValue(int $contactId, string $fieldAlias, string $value): array
    {
        $data = [$fieldAlias => $value];
        $endpoint = "contacts/{$contactId}/edit";

        return $this->request('PATCH', $endpoint, $data);
    }
}
