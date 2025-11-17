<?php

namespace Tests\Feature\App\Services;

use App\Services\MauticService;
use Mockery;

afterEach(function () {
    Mockery::close();
});

test('mautic service can be instantiated', function () {
    $service = new MauticService;

    $this->assertInstanceOf(MauticService::class, $service);
});

test('mautic service creates contact field', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'fields/contact/new', Mockery::on(function ($arg) {
            return $arg['alias'] === 'test_field'
                && $arg['type'] === 'text'
                && $arg['label'] === 'Test Field'
                && $arg['properties'] === [];
        }))
        ->andReturn(['field' => ['id' => 123]]);

    $service = new MauticService;
    $result = $service->createContactField('test_field', 'text', 'Test Field');

    $this->assertArrayHasKey('field', $result);
});

test('mautic service updates contact field', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'fields/contact/123/edit', ['label' => 'Updated Field'])
        ->andReturn(['field' => ['id' => 123, 'label' => 'Updated Field']]);

    $service = new MauticService;
    $result = $service->updateContactField(123, ['label' => 'Updated Field']);

    $this->assertArrayHasKey('field', $result);
});

test('mautic service creates asset', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'assets/new', Mockery::on(function ($arg) {
            return $arg['title'] === 'Test Asset'
                && $arg['storageLocation'] === 'remote'
                && $arg['remotePath'] === 'https://example.com/file.pdf'
                && $arg['isPublished'] === true;
        }))
        ->andReturn(['asset' => ['id' => 456]]);

    $service = new MauticService;
    $result = $service->createAsset('Test Asset', 'https://example.com/file.pdf');

    $this->assertArrayHasKey('asset', $result);
});

test('mautic service updates asset', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'assets/456/edit', ['title' => 'Updated Asset'])
        ->andReturn(['asset' => ['id' => 456, 'title' => 'Updated Asset']]);

    $service = new MauticService;
    $result = $service->updateAsset(456, ['title' => 'Updated Asset']);

    $this->assertArrayHasKey('asset', $result);
});

test('mautic service unpublishes asset', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'assets/456/edit', ['isPublished' => false])
        ->andReturn(['asset' => ['id' => 456, 'isPublished' => false]]);

    $service = new MauticService;
    $result = $service->unpublishAsset(456);

    $this->assertArrayHasKey('asset', $result);
});

test('mautic service creates email', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'emails/new', Mockery::on(function ($arg) {
            return $arg['name'] === 'Test Email'
                && $arg['subject'] === 'Test Subject'
                && $arg['body'] === '<html>Test</html>'
                && $arg['emailType'] === 'template'
                && $arg['isPublished'] === true;
        }))
        ->andReturn(['email' => ['id' => 789]]);

    $service = new MauticService;
    $result = $service->createEmail('Test Email', 'Test Subject', '<html>Test</html>');

    $this->assertArrayHasKey('email', $result);
});

test('mautic service updates email', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'emails/789/edit', ['name' => 'Updated Email'])
        ->andReturn(['email' => ['id' => 789, 'name' => 'Updated Email']]);

    $service = new MauticService;
    $result = $service->updateEmail(789, ['name' => 'Updated Email']);

    $this->assertArrayHasKey('email', $result);
});

test('mautic service unpublishes email', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'emails/789/edit', ['isPublished' => false])
        ->andReturn(['email' => ['id' => 789, 'isPublished' => false]]);

    $service = new MauticService;
    $result = $service->unpublishEmail(789);

    $this->assertArrayHasKey('email', $result);
});

test('mautic service creates campaign', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'campaigns/new', Mockery::on(function ($arg) {
            return $arg['name'] === 'Test Campaign'
                && $arg['description'] === 'Test Description'
                && $arg['isPublished'] === true;
        }))
        ->andReturn(['campaign' => ['id' => 101]]);

    $service = new MauticService;
    $result = $service->createCampaign('Test Campaign', 'Test Description');

    $this->assertArrayHasKey('campaign', $result);
});

test('mautic service updates campaign', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'campaigns/101/edit', ['name' => 'Updated Campaign'])
        ->andReturn(['campaign' => ['id' => 101, 'name' => 'Updated Campaign']]);

    $service = new MauticService;
    $result = $service->updateCampaign(101, ['name' => 'Updated Campaign']);

    $this->assertArrayHasKey('campaign', $result);
});

test('mautic service unpublishes campaign', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'campaigns/101/edit', ['isPublished' => false])
        ->andReturn(['campaign' => ['id' => 101, 'isPublished' => false]]);

    $service = new MauticService;
    $result = $service->unpublishCampaign(101);

    $this->assertArrayHasKey('campaign', $result);
});

test('mautic service adds contact to campaign', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'campaigns/101/contact/1/add', ['contact' => 1])
        ->andReturn(['success' => true]);

    $service = new MauticService;
    $result = $service->addContactToCampaign(101, 1);

    $this->assertArrayHasKey('success', $result);
});

test('mautic service gets contact by email', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'test@example.com'])
        ->andReturn([
            'contacts' => [
                '1' => [
                    'id' => 1,
                    'fields' => [
                        'all' => [
                            'email' => 'test@example.com',
                        ],
                    ],
                ],
            ],
        ]);

    $service = new MauticService;
    $result = $service->getContactByEmail('test@example.com');

    $this->assertNotNull($result);
    $this->assertEquals(1, $result['id']);
});

test('mautic service returns null when contact not found', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'notfound@example.com'])
        ->andReturn(['contacts' => []]);

    $service = new MauticService;
    $result = $service->getContactByEmail('notfound@example.com');

    $this->assertNull($result);
});

test('mautic service creates or updates contact', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'contacts/new', Mockery::on(function ($arg) {
            return $arg['email'] === 'test@example.com'
                && $arg['firstname'] === 'Test';
        }))
        ->andReturn(['contact' => ['id' => 999, 'email' => 'test@example.com']]);

    $service = new MauticService;
    $result = $service->createOrUpdateContact('test@example.com', ['firstname' => 'Test']);

    $this->assertArrayHasKey('contact', $result);
});

test('mautic service updates contact field value', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'contacts/1/edit', ['custom_field' => 'custom_value'])
        ->andReturn(['contact' => ['id' => 1, 'custom_field' => 'custom_value']]);

    $service = new MauticService;
    $result = $service->updateContactFieldValue(1, 'custom_field', 'custom_value');

    $this->assertArrayHasKey('contact', $result);
});

test('mautic service get contact by email finds correct contact among multiple', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'test@example.com'])
        ->andReturn([
            'contacts' => [
                '1' => [
                    'id' => 1,
                    'fields' => [
                        'all' => [
                            'email' => 'other@example.com',
                        ],
                    ],
                ],
                '2' => [
                    'id' => 2,
                    'fields' => [
                        'all' => [
                            'email' => 'test@example.com',
                        ],
                    ],
                ],
            ],
        ]);

    $service = new MauticService;
    $result = $service->getContactByEmail('test@example.com');

    $this->assertNotNull($result);
    $this->assertEquals(2, $result['id']);
});

test('mautic service get contact by email returns null when no exact match', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'test@example.com'])
        ->andReturn([
            'contacts' => [
                '1' => [
                    'id' => 1,
                    'fields' => [
                        'all' => [
                            'email' => 'other@example.com',
                        ],
                    ],
                ],
            ],
        ]);

    $service = new MauticService;
    $result = $service->getContactByEmail('test@example.com');

    $this->assertNull($result);
});

test('mautic service get contact by email handles missing fields', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'test@example.com'])
        ->andReturn([
            'contacts' => [
                '1' => [
                    'id' => 1,
                ],
            ],
        ]);

    $service = new MauticService;
    $result = $service->getContactByEmail('test@example.com');

    $this->assertNull($result);
});

test('mautic service tracks asset download with existing contact', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');

    // First call: getContactByEmail
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'user@example.com'])
        ->andReturn([
            'contacts' => [
                '1' => [
                    'id' => 123,
                    'fields' => [
                        'all' => [
                            'email' => 'user@example.com',
                        ],
                    ],
                ],
            ],
        ]);

    // Second call: track asset download
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'assets/456/contact/123/add', ['contact' => 123])
        ->andReturn(['success' => true]);

    $service = new MauticService;
    $result = $service->trackAssetDownload(456, 'user@example.com');

    $this->assertArrayHasKey('success', $result);
});

test('mautic service tracks asset download with new contact', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');

    // First call: getContactByEmail (returns empty)
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'newuser@example.com'])
        ->andReturn(['contacts' => []]);

    // Second call: createOrUpdateContact
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'contacts/new', Mockery::on(function ($arg) {
            return $arg['email'] === 'newuser@example.com';
        }))
        ->andReturn(['contact' => ['id' => 789, 'email' => 'newuser@example.com']]);

    // Third call: track asset download
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'assets/456/contact/789/add', ['contact' => 789])
        ->andReturn(['success' => true]);

    $service = new MauticService;
    $result = $service->trackAssetDownload(456, 'newuser@example.com');

    $this->assertArrayHasKey('success', $result);
});

test('mautic service throws exception when contact creation fails in track asset download', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');

    // First call: getContactByEmail (returns empty)
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'contacts', ['search' => 'user@example.com'])
        ->andReturn(['contacts' => []]);

    // Second call: createOrUpdateContact (returns without id)
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('POST', 'contacts/new', Mockery::any())
        ->andReturn(['contact' => []]);

    $service = new MauticService;

    $this->expectException(\RuntimeException::class);
    $this->expectExceptionMessage('Failed to get or create contact for asset download tracking');

    $service->trackAssetDownload(456, 'user@example.com');
});

test('mautic service adds email action to campaign', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');

    // First call: get campaign
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'campaigns/100')
        ->andReturn([
            'campaign' => [
                'events' => [],
                'canvasSettings' => [],
            ],
        ]);

    // Second call: update campaign with events and canvas settings
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'campaigns/100/edit', Mockery::on(function ($arg) {
            $hasEvents = isset($arg['events']) && is_array($arg['events']);
            $hasCanvasSettings = isset($arg['canvasSettings']) && is_array($arg['canvasSettings']);
            $hasNodes = isset($arg['canvasSettings']['nodes']) && is_array($arg['canvasSettings']['nodes']);
            $hasConnections = isset($arg['canvasSettings']['connections']) && is_array($arg['canvasSettings']['connections']);

            if (! $hasEvents || ! $hasCanvasSettings || ! $hasNodes || ! $hasConnections) {
                return false;
            }

            // Check that there are email.send and campaign.source events
            $hasEmailSendEvent = false;
            $hasSourceEvent = false;
            foreach ($arg['events'] as $event) {
                if (isset($event['type']) && $event['type'] === 'email.send') {
                    $hasEmailSendEvent = true;
                    if (! isset($event['properties']['email']) || $event['properties']['email'] !== 200) {
                        return false;
                    }
                }
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    $hasSourceEvent = true;
                }
            }

            return $hasEmailSendEvent && $hasSourceEvent;
        }))
        ->andReturn(['campaign' => ['id' => 100]]);

    $service = new MauticService;
    $result = $service->addEmailActionToCampaign(100, 200);

    $this->assertArrayHasKey('campaign', $result);
});

test('mautic service adds email action to campaign with existing events', function () {
    $mauticMock = Mockery::mock('alias:Triibo\Mautic\Facades\Mautic');

    $existingEventId = 'existing_event_123';
    $existingEvents = [
        $existingEventId => [
            'id' => $existingEventId,
            'type' => 'email.send',
            'name' => 'Existing Email',
        ],
    ];

    $existingCanvasSettings = [
        'nodes' => [
            $existingEventId => [
                'position' => ['x' => 50, 'y' => 50],
            ],
        ],
    ];

    // First call: get campaign with existing events
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('GET', 'campaigns/100')
        ->andReturn([
            'campaign' => [
                'events' => $existingEvents,
                'canvasSettings' => $existingCanvasSettings,
            ],
        ]);

    // Second call: update campaign with new events added to existing ones
    $mauticMock->shouldReceive('request')
        ->once()
        ->with('PATCH', 'campaigns/100/edit', Mockery::on(function ($arg) use ($existingEventId) {
            // Check that existing event is preserved
            if (! isset($arg['events'][$existingEventId])) {
                return false;
            }

            // Check that new events are added
            $hasEmailSendEvent = false;
            $hasSourceEvent = false;
            foreach ($arg['events'] as $eventId => $event) {
                if ($eventId === $existingEventId) {
                    continue;
                }
                if (isset($event['type']) && $event['type'] === 'email.send') {
                    $hasEmailSendEvent = true;
                    if (! isset($event['properties']['email']) || $event['properties']['email'] !== 200) {
                        return false;
                    }
                }
                if (isset($event['type']) && $event['type'] === 'campaign.source') {
                    $hasSourceEvent = true;
                }
            }

            return $hasEmailSendEvent && $hasSourceEvent
                && isset($arg['canvasSettings']['nodes'])
                && isset($arg['canvasSettings']['connections']);
        }))
        ->andReturn(['campaign' => ['id' => 100]]);

    $service = new MauticService;
    $result = $service->addEmailActionToCampaign(100, 200);

    $this->assertArrayHasKey('campaign', $result);
});
