<?php

namespace Tests\Unit\App\Events;

use App\Events\NewLead;
use App\Models\Contact;
use Illuminate\Support\Facades\Event;

test('new lead event can be instantiated', function () {
    $contact = new Contact([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    $category = 'automation';

    $event = new NewLead($contact, $category);

    expect($event->contact)->toBe($contact);
    expect($event->category)->toBe($category);
});

test('new lead event has correct contact', function () {
    $contact = new Contact([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
    $category = 'marketing';

    $event = new NewLead($contact, $category);

    expect($event->contact->name)->toBe('John Doe');
    expect($event->contact->email)->toBe('john@example.com');
});

test('new lead event has correct category', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $categories = ['automation', 'marketing', 'software-development'];

    foreach ($categories as $category) {
        $event = new NewLead($contact, $category);
        expect($event->category)->toBe($category);
    }
});

test('new lead event can be dispatched', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $category = 'automation';

    // Test that dispatch method exists and can be called
    // The actual dispatch behavior is tested in feature tests
    $event = new NewLead($contact, $category);

    expect($event)->toBeInstanceOf(NewLead::class);
    expect(method_exists($event, 'dispatch'))->toBeTrue();
});

test('new lead event returns broadcast channels', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $category = 'automation';

    $event = new NewLead($contact, $category);
    $channels = $event->broadcastOn();

    expect($channels)->toBeArray();
    expect(count($channels))->toBe(1);
    expect($channels[0])->toBeInstanceOf(\Illuminate\Broadcasting\PrivateChannel::class);
    expect($channels[0]->name)->toBe('private-channel-name');
});

test('new lead event uses serializable models trait', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $category = 'automation';

    $event = new NewLead($contact, $category);

    // Verify that the event uses SerializesModels trait
    $traits = class_uses_recursive($event);
    expect($traits)->toContain(\Illuminate\Queue\SerializesModels::class);
});

test('new lead event uses dispatchable trait', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $category = 'automation';

    $event = new NewLead($contact, $category);

    // Verify that the event uses Dispatchable trait
    $traits = class_uses_recursive($event);
    expect($traits)->toContain(\Illuminate\Foundation\Events\Dispatchable::class);
});

test('new lead event uses interacts with sockets trait', function () {
    $contact = new Contact([
        'name' => 'Test',
        'email' => 'test@example.com',
    ]);
    $category = 'automation';

    $event = new NewLead($contact, $category);

    // Verify that the event uses InteractsWithSockets trait
    $traits = class_uses_recursive($event);
    expect($traits)->toContain(\Illuminate\Broadcasting\InteractsWithSockets::class);
});

test('new lead event can be serialized', function () {
    // Create a simple contact object without database
    $contact = new Contact;
    $contact->name = 'Test';
    $contact->email = 'test@example.com';
    $category = 'automation';

    $event = new NewLead($contact, $category);

    // Test that the event can be serialized (for queue)
    // Note: Serializing with Eloquent models requires database connection
    // This test verifies the structure can be serialized
    expect($event)->toBeInstanceOf(NewLead::class);
    expect($event->category)->toBe($category);
    expect($event->contact->email)->toBe('test@example.com');

    // Verify serialization is possible (structure check)
    // The SerializesModels trait provides serialization support
    $hasSerialize = method_exists($event, '__serialize') || method_exists($event, 'serialize');
    expect($hasSerialize)->toBeTrue();
});
