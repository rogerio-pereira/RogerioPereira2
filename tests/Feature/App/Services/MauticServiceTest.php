<?php

namespace Tests\Feature\App\Services;

use App\Services\MauticService;
use Mockery;

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
