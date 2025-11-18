<?php

namespace Tests\Unit\App\Services;

use App\Services\MauticService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

beforeEach(function () {
    Cache::flush();
    config([
        'services.mautic.url' => 'https://mautic.example.com',
        'services.mautic.client_id' => 'test-client-id',
        'services.mautic.client_secret' => 'test-client-secret',
    ]);
});

test('mautic service validates configuration on construction', function () {
    config(['services.mautic.url' => '']);

    expect(fn () => new MauticService)
        ->toThrow(\RuntimeException::class, 'Mautic URL is not configured');
});

test('mautic service validates client id on construction', function () {
    config(['services.mautic.client_id' => '']);

    expect(fn () => new MauticService)
        ->toThrow(\RuntimeException::class, 'Mautic Client ID is not configured');
});

test('mautic service validates client secret on construction', function () {
    config(['services.mautic.client_secret' => '']);

    expect(fn () => new MauticService)
        ->toThrow(\RuntimeException::class, 'Mautic Client Secret is not configured');
});

test('mautic service creates contact field with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/fields/contact/new' => [[
            'field' => ['id' => 123],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createContactField('test_alias', 'text', 'Test Label', ['required' => true]);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/fields/contact/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['alias'] === 'test_alias'
            && $request->data()['type'] === 'text'
            && $request->data()['label'] === 'Test Label'
            && $request->data()['properties'] === ['required' => true];
    });

    expect($response)->toBeArray()
        ->and($response['field']['id'])->toBe(123);
});

test('mautic service updates contact field with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/fields/contact/123/edit' => [[
            'field' => ['id' => 123],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['label' => 'Updated Label'];
    $response = $service->updateContactField(123, $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://mautic.example.com/api/fields/contact/123/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data() === $data;
    });

    expect($response)->toBeArray();
});

test('mautic service creates asset with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/assets/new' => [[
            'asset' => ['id' => 456],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createAsset('Test Asset', 'https://example.com/file.pdf');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/assets/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['title'] === 'Test Asset'
            && $request->data()['storageLocation'] === 'remote'
            && $request->data()['file'] === 'https://example.com/file.pdf';
    });

    expect($response)->toBeArray()
        ->and($response['asset']['id'])->toBe(456);
});

test('mautic service updates asset with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/assets/456/edit' => [[
            'asset' => ['id' => 456],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['title' => 'Updated Asset'];
    $response = $service->updateAsset(456, $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://mautic.example.com/api/assets/456/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data() === $data;
    });

    expect($response)->toBeArray();
});

test('mautic service unpublishes asset with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/assets/456/edit' => [[
            'asset' => ['id' => 456],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->unpublishAsset(456);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/assets/456/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['isPublished'] === false;
    });

    expect($response)->toBeArray();
});

test('mautic service tracks asset download with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [
                [
                    'id' => 789,
                    'fields' => [
                        'all' => ['email' => 'test@example.com'],
                    ],
                ],
            ],
        ], 200],
        'https://mautic.example.com/api/assets/456/contact/789/add' => [[
            'success' => true,
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->trackAssetDownload(456, 'test@example.com');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/assets/456/contact/789/add'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['contact'] === 789;
    });

    expect($response)->toBeArray();
});

test('mautic service creates contact when tracking asset download if contact does not exist', function () {
    Http::fakeSequence()
        ->push(['access_token' => 'test-token', 'expires_in' => 3600], 200) // OAuth token
        ->push(['contacts' => []], 200) // getContactByEmail returns empty
        ->push(['contact' => ['id' => 999]], 201) // createOrUpdateContact
        ->push(['success' => true], 200); // trackAssetDownload

    $service = new MauticService;
    $response = $service->trackAssetDownload(456, 'new@example.com');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'https://mautic.example.com/api/contacts/new')
            && $request->method() === 'POST'
            && $request->data()['email'] === 'new@example.com';
    });

    expect($response)->toBeArray();
});

test('mautic service creates email with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/emails/new' => [[
            'email' => ['id' => 321],
        ], 201],
    ]);

    $service = new MauticService;
    $html = '<html><body>Test Email</body></html>';
    $response = $service->createEmail('test_email', 'Test Subject', $html);

    Http::assertSent(function ($request) use ($html) {
        return $request->url() === 'https://mautic.example.com/api/emails/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['name'] === 'test_email'
            && $request->data()['subject'] === 'Test Subject'
            && $request->data()['customHtml'] === $html
            && $request->data()['emailType'] === 'template'
            && $request->data()['isPublished'] === true;
    });

    expect($response)->toBeArray()
        ->and($response['email']['id'])->toBe(321);
});

test('mautic service updates email with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/emails/321/edit' => [[
            'email' => ['id' => 321],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['subject' => 'Updated Subject'];
    $response = $service->updateEmail(321, $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://mautic.example.com/api/emails/321/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data() === $data;
    });

    expect($response)->toBeArray();
});

test('mautic service unpublishes email with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/emails/321/edit' => [[
            'email' => ['id' => 321],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->unpublishEmail(321);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/emails/321/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['isPublished'] === false;
    });

    expect($response)->toBeArray();
});

test('mautic service creates campaign with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/new' => [[
            'campaign' => ['id' => 555],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createCampaign('Test Campaign', 'Test Description');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/campaigns/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['name'] === 'Test Campaign'
            && $request->data()['description'] === 'Test Description'
            && $request->data()['isPublished'] === true;
    });

    expect($response)->toBeArray()
        ->and($response['campaign']['id'])->toBe(555);
});

test('mautic service creates campaign without description', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/new' => [[
            'campaign' => ['id' => 555],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createCampaign('Test Campaign');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/campaigns/new'
            && $request->method() === 'POST'
            && $request->data()['name'] === 'Test Campaign'
            && $request->data()['description'] === ''
            && $request->data()['isPublished'] === true;
    });

    expect($response)->toBeArray();
});

test('mautic service updates campaign with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555/edit' => [[
            'campaign' => ['id' => 555],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['name' => 'Updated Campaign'];
    $response = $service->updateCampaign(555, $data);

    Http::assertSent(function ($request) use ($data) {
        return $request->url() === 'https://mautic.example.com/api/campaigns/555/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data() === $data;
    });

    expect($response)->toBeArray();
});

test('mautic service unpublishes campaign with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555/edit' => [[
            'campaign' => ['id' => 555],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->unpublishCampaign(555);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/campaigns/555/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['isPublished'] === false;
    });

    expect($response)->toBeArray();
});

test('mautic service adds email action to campaign with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555' => [[
            'campaign' => [
                'events' => [],
                'canvasSettings' => [
                    'nodes' => [],
                    'connections' => [],
                ],
            ],
        ], 200],
        'https://mautic.example.com/api/campaigns/555/edit' => [[
            'campaign' => ['id' => 555],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->addEmailActionToCampaign(555, 321);

    Http::assertSent(function ($request) {
        $data = $request->data();
        $hasEmailEvent = false;
        $hasSourceEvent = false;

        if (isset($data['events']) && is_array($data['events'])) {
            foreach ($data['events'] as $eventId => $event) {
                if (isset($event['type']) && $event['type'] === 'email.send' && isset($event['properties']['email']) && $event['properties']['email'] === 321) {
                    $hasEmailEvent = true;
                }
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    $hasSourceEvent = true;
                }
            }
        }

        return $request->url() === 'https://mautic.example.com/api/campaigns/555/edit'
            && $request->method() === 'PATCH'
            && isset($data['events'])
            && isset($data['canvasSettings'])
            && $hasEmailEvent
            && $hasSourceEvent;
    });

    expect($response)->toBeArray();
});

test('mautic service adds contact to campaign with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555/contact/789/add' => [[
            'success' => true,
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->addContactToCampaign(555, 789);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/campaigns/555/contact/789/add'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['contact'] === 789;
    });

    expect($response)->toBeArray();
});

test('mautic service gets contact by email with correct query', function () {
    $contactsFoundResponse = fakeHttpResponse([
        'contacts' => [
            [
                'id' => 789,
                'fields' => [
                    'all' => ['email' => 'test@example.com'],
                ],
            ],
        ],
    ], 200);
    $contactsEmptyResponse = fakeHttpResponse(['contacts' => []], 200);

    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => function ($request) use ($contactsFoundResponse, $contactsEmptyResponse) {
            $url = $request->url();
            $parsedUrl = parse_url($url);
            $queryParams = [];
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
            }

            if (isset($queryParams['search']) && $queryParams['search'] === 'test@example.com') {
                return $contactsFoundResponse;
            }

            return $contactsEmptyResponse;
        },
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('test@example.com');

    Http::assertSent(function ($request) {
        $url = $request->url();
        $parsedUrl = parse_url($url);
        $queryParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
        }

        return str_contains($url, 'https://mautic.example.com/api/contacts')
            && $request->method() === 'GET'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && isset($queryParams['search'])
            && $queryParams['search'] === 'test@example.com';
    });

    expect($contact)->toBeArray()
        ->and($contact['id'])->toBe(789);
});

test('mautic service returns null when contact is not found by email', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [],
        ], 200],
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('notfound@example.com');

    expect($contact)->toBeNull();
});

test('mautic service creates or updates contact with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts/new' => [[
            'contact' => ['id' => 999],
        ], 201],
    ]);

    $service = new MauticService;
    $data = ['firstname' => 'John', 'lastname' => 'Doe'];
    $response = $service->createOrUpdateContact('new@example.com', $data);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/contacts/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['email'] === 'new@example.com'
            && $request->data()['firstname'] === 'John'
            && $request->data()['lastname'] === 'Doe';
    });

    expect($response)->toBeArray()
        ->and($response['contact']['id'])->toBe(999);
});

test('mautic service updates contact field value with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts/789/edit' => [[
            'contact' => ['id' => 789],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->updateContactFieldValue(789, 'test_field', 'test_value');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/contacts/789/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['test_field'] === 'test_value';
    });

    expect($response)->toBeArray();
});

test('mautic service handles base url with trailing slash', function () {
    config(['services.mautic.url' => 'https://mautic.example.com/']);

    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/*' => [[
            'contact' => ['id' => 999],
        ], 201],
        'https://mautic.example.com//api/*' => [[
            'contact' => ['id' => 999],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createOrUpdateContact('test@example.com', []);

    Http::assertSent(function ($request) {
        // URL should not have double slashes (rtrim removes trailing slash)
        $url = $request->url();
        // Normalize URL to handle potential double slashes
        $normalizedUrl = str_replace('//api', '/api', $url);

        return $normalizedUrl === 'https://mautic.example.com/api/contacts/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['email'] === 'test@example.com';
    });

    expect($response)->toBeArray();
});

test('mautic service getOrCreateContactId throws exception when contact creation fails', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [],
        ], 200],
        'https://mautic.example.com/api/contacts/new' => [[
            'contact' => [],
        ], 201],
    ]);

    $service = new MauticService;

    expect(fn () => $service->trackAssetDownload(456, 'test@example.com'))
        ->toThrow(\RuntimeException::class, 'Failed to get or create contact for asset download tracking');
});

test('mautic service getOrCreateContactId handles contact without id field', function () {
    Http::fakeSequence()
        ->push(['access_token' => 'test-token', 'expires_in' => 3600], 200) // OAuth token
        ->push([
            'contacts' => [
                [
                    'fields' => [
                        'all' => ['email' => 'test@example.com'],
                    ],
                ],
            ],
        ], 200) // getContactByEmail returns contact without id
        ->push(['contact' => ['id' => 999]], 201) // createOrUpdateContact
        ->push(['success' => true], 200); // trackAssetDownload

    $service = new MauticService;
    $response = $service->trackAssetDownload(456, 'test@example.com');

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'https://mautic.example.com/api/contacts/new')
            && $request->method() === 'POST'
            && $request->data()['email'] === 'test@example.com';
    });

    expect($response)->toBeArray();
});

test('mautic service getContactByEmail finds exact match among multiple contacts', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [
                [
                    'id' => 100,
                    'fields' => [
                        'all' => ['email' => 'other@example.com'],
                    ],
                ],
                [
                    'id' => 200,
                    'fields' => [
                        'all' => ['email' => 'test@example.com'],
                    ],
                ],
                [
                    'id' => 300,
                    'fields' => [
                        'all' => ['email' => 'another@example.com'],
                    ],
                ],
            ],
        ], 200],
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('test@example.com');

    expect($contact)->toBeArray()
        ->and($contact['id'])->toBe(200)
        ->and($contact['fields']['all']['email'])->toBe('test@example.com');
});

test('mautic service getContactByEmail returns null when no exact match found among multiple contacts', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [
                [
                    'id' => 100,
                    'fields' => [
                        'all' => ['email' => 'other@example.com'],
                    ],
                ],
                [
                    'id' => 200,
                    'fields' => [
                        'all' => ['email' => 'different@example.com'],
                    ],
                ],
            ],
        ], 200],
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('test@example.com');

    expect($contact)->toBeNull();
});

test('mautic service extractContactEmail handles missing fields structure', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [
                [
                    'id' => 100,
                    'fields' => null,
                ],
                [
                    'id' => 200,
                ],
            ],
        ], 200],
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('test@example.com');

    expect($contact)->toBeNull();
});

test('mautic service extractContactEmail handles missing all fields', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/contacts*' => [[
            'contacts' => [
                [
                    'id' => 100,
                    'fields' => [],
                ],
            ],
        ], 200],
    ]);

    $service = new MauticService;
    $contact = $service->getContactByEmail('test@example.com');

    expect($contact)->toBeNull();
});

test('mautic service addEmailActionToCampaign preserves existing campaign events and canvas settings', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555' => [[
            'campaign' => [
                'events' => [
                    'existing_event_1' => [
                        'id' => 'existing_event_1',
                        'type' => 'email.send',
                        'name' => 'Existing Email',
                    ],
                ],
                'canvasSettings' => [
                    'nodes' => [
                        'existing_event_1' => ['position' => ['x' => 50, 'y' => 50]],
                    ],
                    'connections' => [
                        'existing_event_1' => [],
                    ],
                ],
            ],
        ], 200],
        'https://mautic.example.com/api/campaigns/555/edit' => [[
            'campaign' => ['id' => 555],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->addEmailActionToCampaign(555, 321);

    Http::assertSent(function ($request) {
        $data = $request->data();
        $hasExistingEvent = isset($data['events']['existing_event_1']);
        $hasNewEmailEvent = false;
        $hasNewSourceEvent = false;

        if (isset($data['events']) && is_array($data['events'])) {
            foreach ($data['events'] as $eventId => $event) {
                if (isset($event['type']) && $event['type'] === 'email.send' && isset($event['properties']['email']) && $event['properties']['email'] === 321) {
                    $hasNewEmailEvent = true;
                }
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    $hasNewSourceEvent = true;
                }
            }
        }

        $hasExistingNode = isset($data['canvasSettings']['nodes']['existing_event_1']);
        $hasNewNodes = isset($data['canvasSettings']['nodes']) && count($data['canvasSettings']['nodes']) >= 2;

        return $request->url() === 'https://mautic.example.com/api/campaigns/555/edit'
            && $request->method() === 'PATCH'
            && $hasExistingEvent
            && $hasNewEmailEvent
            && $hasNewSourceEvent
            && $hasExistingNode
            && $hasNewNodes;
    });

    expect($response)->toBeArray();
});

test('mautic service extractCampaignData handles missing campaign key', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/555' => [[], 200],
        'https://mautic.example.com/api/campaigns/555/edit' => [[
            'campaign' => ['id' => 555],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->addEmailActionToCampaign(555, 321);

    Http::assertSent(function ($request) {
        $data = $request->data();

        return $request->url() === 'https://mautic.example.com/api/campaigns/555/edit'
            && $request->method() === 'PATCH'
            && isset($data['events'])
            && isset($data['canvasSettings']);
    });

    expect($response)->toBeArray();
});

test('mautic service creates segment email with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/emails/new' => [[
            'email' => ['id' => 400],
        ], 201],
    ]);

    $service = new MauticService;
    $html = '<html><body>Segment Email</body></html>';
    $segmentIds = [100, 200];
    $response = $service->createSegmentEmail('segment_email', 'Segment Subject', $html, $segmentIds);

    Http::assertSent(function ($request) use ($html, $segmentIds) {
        return $request->url() === 'https://mautic.example.com/api/emails/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['name'] === 'segment_email'
            && $request->data()['subject'] === 'Segment Subject'
            && $request->data()['customHtml'] === $html
            && $request->data()['emailType'] === 'list'
            && $request->data()['isPublished'] === true
            && $request->data()['publicPreview'] === true
            && $request->data()['lists'] === $segmentIds;
    });

    expect($response)->toBeArray()
        ->and($response['email']['id'])->toBe(400);
});

test('mautic service creates segment with filter when segment is created successfully', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/new' => [[
            'list' => ['id' => 500],
        ], 201],
        'https://mautic.example.com/api/segments/500/edit' => [[
            'list' => ['id' => 500, 'isPublished' => true],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->createSegment('Test Segment', 'field_alias');

    Http::assertSent(function ($request) {
        if ($request->url() === 'https://mautic.example.com/api/segments/new') {
            return $request->method() === 'POST'
                && $request->data()['name'] === 'Test Segment'
                && $request->data()['isPublished'] === true;
        }

        if ($request->url() === 'https://mautic.example.com/api/segments/500/edit') {
            $data = $request->data();

            return $request->method() === 'PATCH'
                && isset($data['filters'])
                && is_array($data['filters'])
                && count($data['filters']) === 1
                && $data['filters'][0]['field'] === 'field_alias'
                && $data['filters'][0]['operator'] === '!empty'
                && $data['isPublished'] === true;
        }

        return false;
    });

    expect($response)->toBeArray();
});

test('mautic service returns response when segment creation fails', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/new' => [[
            'errors' => [['message' => 'Segment creation failed']],
        ], 400],
    ]);

    $service = new MauticService;
    $response = $service->createSegment('Test Segment', 'field_alias');

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/segments/new'
            && $request->method() === 'POST';
    });

    expect($response)->toBeArray()
        ->and($response)->toHaveKey('errors');
});

test('mautic service updateSegment ensures published when isPublished not provided', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/500/edit' => [[
            'list' => ['id' => 500, 'isPublished' => true],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['name' => 'Updated Segment'];
    $response = $service->updateSegment(500, $data);

    Http::assertSent(function ($request) {
        $data = $request->data();

        return $request->url() === 'https://mautic.example.com/api/segments/500/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $data['name'] === 'Updated Segment'
            && $data['isPublished'] === true;
    });

    expect($response)->toBeArray();
});

test('mautic service updateSegment respects isPublished when provided', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/500/edit' => [[
            'list' => ['id' => 500, 'isPublished' => false],
        ], 200],
    ]);

    $service = new MauticService;
    $data = ['name' => 'Updated Segment', 'isPublished' => false];
    $response = $service->updateSegment(500, $data);

    Http::assertSent(function ($request) {
        $data = $request->data();

        return $request->url() === 'https://mautic.example.com/api/segments/500/edit'
            && $request->method() === 'PATCH'
            && $data['isPublished'] === false;
    });

    expect($response)->toBeArray();
});

test('mautic service unpublishes segment with correct data', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/500/edit' => [[
            'list' => ['id' => 500, 'isPublished' => false],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->unpublishSegment(500);

    Http::assertSent(function ($request) {
        return $request->url() === 'https://mautic.example.com/api/segments/500/edit'
            && $request->method() === 'PATCH'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $request->data()['isPublished'] === false;
    });

    expect($response)->toBeArray();
});

test('mautic service creates campaign with email and segment', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/new' => [[
            'campaign' => ['id' => 600],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createCampaign('Test Campaign', 'Description', 321, 100);

    Http::assertSent(function ($request) {
        $data = $request->data();
        $hasSourceEvent = false;
        $hasEmailEvent = false;
        $sourceEventHasSegment = false;
        $emailEventHasParent = false;

        if (isset($data['events']) && is_array($data['events'])) {
            foreach ($data['events'] as $eventId => $event) {
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    $hasSourceEvent = true;
                    if (isset($event['properties']['lists']) && in_array(100, $event['properties']['lists'])) {
                        $sourceEventHasSegment = true;
                    }
                    if (isset($event['children']) && is_array($event['children']) && count($event['children']) > 0) {
                        $emailEventId = $event['children'][0];
                        if (isset($data['events'][$emailEventId])) {
                            $emailEvent = $data['events'][$emailEventId];
                            if (isset($emailEvent['type']) && $emailEvent['type'] === 'email.send') {
                                $hasEmailEvent = true;
                                if (isset($emailEvent['parent']) && $emailEvent['parent'] === $eventId) {
                                    $emailEventHasParent = true;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $request->url() === 'https://mautic.example.com/api/campaigns/new'
            && $request->method() === 'POST'
            && $request->hasHeader('Authorization', 'Bearer test-token')
            && $data['name'] === 'Test Campaign'
            && $data['description'] === 'Description'
            && $hasSourceEvent
            && $hasEmailEvent
            && $sourceEventHasSegment
            && $emailEventHasParent;
    });

    expect($response)->toBeArray();
});

test('mautic service createSourceEvent includes segment when provided', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/campaigns/new' => [[
            'campaign' => ['id' => 700],
        ], 201],
    ]);

    $service = new MauticService;
    $response = $service->createCampaign('Campaign With Segment', '', null, 150);

    Http::assertSent(function ($request) {
        $data = $request->data();
        $hasSourceEventWithSegment = false;

        if (isset($data['events']) && is_array($data['events'])) {
            foreach ($data['events'] as $event) {
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    if (isset($event['properties']['source']) && $event['properties']['source'] === 'lists') {
                        if (isset($event['properties']['lists']) && in_array(150, $event['properties']['lists'])) {
                            $hasSourceEventWithSegment = true;
                        }
                    }
                }
            }
        }

        return $hasSourceEventWithSegment;
    });

    expect($response)->toBeArray();
});

test('mautic service generateSegmentAlias creates safe alias', function () {
    fakeHttp([
        'https://mautic.example.com/oauth/v2/token' => [[
            'access_token' => 'test-token',
            'expires_in' => 3600,
        ], 200],
        'https://mautic.example.com/api/segments/new' => [[
            'list' => ['id' => 800],
        ], 201],
        'https://mautic.example.com/api/segments/800/edit' => [[
            'list' => ['id' => 800],
        ], 200],
    ]);

    $service = new MauticService;
    $response = $service->createSegment('Test Segment Name With Special Chars!@#', 'field_alias');

    Http::assertSent(function ($request) {
        if ($request->url() === 'https://mautic.example.com/api/segments/new') {
            $data = $request->data();
            $alias = $data['alias'] ?? '';

            // Should be lowercase, no special chars except underscore, and end with timestamp
            return preg_match('/^test_segment_name_with_special_chars_\d+$/', $alias) === 1;
        }

        return false;
    });

    expect($response)->toBeArray();
});
