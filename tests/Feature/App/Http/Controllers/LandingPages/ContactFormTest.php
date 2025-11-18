<?php

namespace Tests\Feature\App\Http\Controllers\LandingPages;

use App\Events\NewLead;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

test('automation form stores contact', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => null,
        'buyer' => false,
        'do_not_contact' => false,
        'automation' => true,
        'marketing' => false,
        'software_development' => false,
    ]);

    Event::assertDispatched(NewLead::class, function ($event) {
        return $event->category === 'automation'
            && $event->contact->email === 'john@example.com';
    });
});

test('automation form stores contact with phone', function () {
    Notification::fake();

    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
        'buyer' => false,
        'do_not_contact' => false,
        'automation' => true,
        'marketing' => false,
        'software_development' => false,
    ]);
});

test('automation form validates required fields', function () {
    $response = $this->post(route('automation.store'), []);

    $response->assertSessionHasErrors(['name', 'email']);
    $this->assertDatabaseCount('contacts', 0);
});

test('automation form validates email format', function () {
    Notification::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'invalid-email',
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertSessionHasErrors(['email']);
    $this->assertDatabaseCount('contacts', 0);
});

test('marketing form stores contact', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    $response = $this->post(route('marketing.store'), $data);

    $response->assertRedirect(route('marketing.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => null,
        'buyer' => false,
        'do_not_contact' => false,
        'marketing' => true,
        'automation' => false,
        'software_development' => false,
    ]);

    Event::assertDispatched(NewLead::class, function ($event) {
        return $event->category === 'automation'
            && $event->contact->email === 'john@example.com';
    });
});

test('marketing form stores contact with phone', function () {
    Notification::fake();

    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
    ];

    $response = $this->post(route('marketing.store'), $data);

    $response->assertRedirect(route('marketing.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
        'buyer' => false,
        'do_not_contact' => false,
        'marketing' => true,
        'automation' => false,
        'software_development' => false,
    ]);
});

test('marketing form validates required fields', function () {
    $response = $this->post(route('marketing.store'), []);

    $response->assertSessionHasErrors(['name', 'email']);
    $this->assertDatabaseCount('contacts', 0);
});

test('software development form stores contact', function () {
    Event::fake();

    $data = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ];

    $response = $this->post(route('software-development.store'), $data);

    $response->assertRedirect(route('software-development.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => null,
        'buyer' => false,
        'do_not_contact' => false,
        'software_development' => true,
        'marketing' => false,
        'automation' => false,
    ]);

    Event::assertDispatched(NewLead::class, function ($event) {
        return $event->category === 'automation'
            && $event->contact->email === 'john@example.com';
    });
});

test('software development form stores contact with phone', function () {
    Notification::fake();

    $data = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
    ];

    $response = $this->post(route('software-development.store'), $data);

    $response->assertRedirect(route('software-development.thank-you'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('contacts', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '+1234567890',
        'buyer' => false,
        'do_not_contact' => false,
        'software_development' => true,
        'marketing' => false,
        'automation' => false,
    ]);
});

test('software development form validates required fields', function () {
    $response = $this->post(route('software-development.store'), []);

    $response->assertSessionHasErrors(['name', 'email']);
    $this->assertDatabaseCount('contacts', 0);
});

test('contact has uuid as primary key', function () {
    $contact = Contact::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'buyer' => false,
    ]);

    $this->assertIsString($contact->id);
    $this->assertMatchesRegularExpression('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $contact->id);
});

test('contact buyer defaults to false', function () {
    $contact = Contact::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    $this->assertFalse($contact->buyer);
});

test('automation form updates existing contact', function () {
    Notification::fake();

    $existingContact = Contact::create([
        'name' => 'Old Name',
        'email' => 'john@example.com',
        'phone' => '+1111111111',
        'do_not_contact' => true,
        'marketing' => true,
        'automation' => false,
    ]);

    $data = [
        'name' => 'New Name',
        'email' => 'john@example.com',
        'phone' => '+2222222222',
    ];

    $response = $this->post(route('automation.store'), $data);

    $response->assertRedirect(route('automation.thank-you'));

    $this->assertDatabaseHas('contacts', [
        'email' => 'john@example.com',
        'name' => 'New Name',
        'phone' => '+2222222222',
        'do_not_contact' => false,
        'automation' => true,
        'marketing' => true, // Should remain true
    ]);

    $this->assertDatabaseCount('contacts', 1);
});

test('marketing form updates existing contact and resets do_not_contact', function () {
    Notification::fake();

    $existingContact = Contact::create([
        'name' => 'Old Name',
        'email' => 'jane@example.com',
        'do_not_contact' => true,
        'automation' => true,
        'marketing' => false,
    ]);

    $data = [
        'name' => 'New Name',
        'email' => 'jane@example.com',
    ];

    $response = $this->post(route('marketing.store'), $data);

    $response->assertRedirect(route('marketing.thank-you'));

    $this->assertDatabaseHas('contacts', [
        'email' => 'jane@example.com',
        'name' => 'New Name',
        'do_not_contact' => false,
        'marketing' => true,
        'automation' => true, // Should remain true
    ]);

    $this->assertDatabaseCount('contacts', 1);
});

test('software development form updates existing contact', function () {
    Notification::fake();

    $existingContact = Contact::create([
        'name' => 'Old Name',
        'email' => 'test@example.com',
        'do_not_contact' => true,
        'software_development' => false,
    ]);

    $data = [
        'name' => 'Updated Name',
        'email' => 'test@example.com',
    ];

    $response = $this->post(route('software-development.store'), $data);

    $response->assertRedirect(route('software-development.thank-you'));

    $this->assertDatabaseHas('contacts', [
        'email' => 'test@example.com',
        'name' => 'Updated Name',
        'do_not_contact' => false,
        'software_development' => true,
    ]);

    $this->assertDatabaseCount('contacts', 1);
});
