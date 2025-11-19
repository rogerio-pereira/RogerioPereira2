<?php

namespace Tests\Feature;

use App\Models\Contact;

test('unsubscribe show page displays correctly with valid uuid', function () {
    $contact = Contact::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'do_not_contact' => false,
    ]);

    $response = $this->get(route('unsubscribe.show', $contact->id));

    $response->assertStatus(200);
    $response->assertSee('Unsubscribe');
    $response->assertSee('John Doe');
    $response->assertSee('Are you sure you want to unsubscribe');
});

test('unsubscribe show page redirects with invalid uuid', function () {
    $invalidUuid = '00000000-0000-0000-0000-000000000000';

    $response = $this->get(route('unsubscribe.show', $invalidUuid));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Invalid unsubscribe link.');
});

test('unsubscribe confirm updates do_not_contact to true', function () {
    $contact = Contact::factory()->create([
        'do_not_contact' => false,
    ]);

    $response = $this->post(route('unsubscribe.confirm', $contact->id));

    $response->assertRedirect(route('unsubscribe.resubscribe', $contact->id));
    $response->assertSessionHas('success', 'You have been unsubscribed successfully.');

    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'do_not_contact' => true,
    ]);
});

test('unsubscribe confirm redirects with invalid uuid', function () {
    $invalidUuid = '00000000-0000-0000-0000-000000000000';

    $response = $this->post(route('unsubscribe.confirm', $invalidUuid));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Invalid unsubscribe link.');
});

test('resubscribe page displays correctly after unsubscribe', function () {
    $contact = Contact::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'do_not_contact' => true,
    ]);

    $response = $this->get(route('unsubscribe.resubscribe', $contact->id));

    $response->assertStatus(200);
    $response->assertSee('Resubscribe');
    $response->assertSee('Jane Doe');
    $response->assertSee('You have been unsubscribed');
    $response->assertSee('Yes, Resubscribe');
});

test('resubscribe page redirects with invalid uuid', function () {
    $invalidUuid = '00000000-0000-0000-0000-000000000000';

    $response = $this->get(route('unsubscribe.resubscribe', $invalidUuid));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Invalid link.');
});

test('resubscribe confirm updates do_not_contact to false', function () {
    $contact = Contact::factory()->create([
        'do_not_contact' => true,
    ]);

    $response = $this->post(route('unsubscribe.resubscribe.confirm', $contact->id));

    $response->assertRedirect(route('unsubscribe.resubscribe.success', $contact->id));

    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'do_not_contact' => false,
    ]);
});

test('resubscribe success page displays correctly', function () {
    $contact = Contact::factory()->create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'do_not_contact' => false,
    ]);

    $response = $this->get(route('unsubscribe.resubscribe.success', $contact->id));

    $response->assertStatus(200);
    $response->assertSee('Welcome Back!', false);
    $response->assertSee('Resubscribed Successfully', false);
    $response->assertSee('Jane Doe', false);
    $response->assertDontSee('Unsubscribe', false);
});

test('resubscribe success page redirects with invalid uuid', function () {
    $invalidUuid = '00000000-0000-0000-0000-000000000000';

    $response = $this->get(route('unsubscribe.resubscribe.success', $invalidUuid));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Invalid link.');
});

test('resubscribe confirm redirects with invalid uuid', function () {
    $invalidUuid = '00000000-0000-0000-0000-000000000000';

    $response = $this->post(route('unsubscribe.resubscribe.confirm', $invalidUuid));

    $response->assertRedirect(route('home'));
    $response->assertSessionHas('error', 'Invalid link.');
});

test('unsubscribe link is present in new lead emails', function () {
    $contact = Contact::factory()->create();

    $mailable = new \App\Mail\NewLeadEmail($contact, 'automation');

    $mailable->assertSeeInHtml(route('unsubscribe.show', $contact->id));
});

test('unsubscribe link is not present in ebook download emails', function () {
    $category = \App\Models\Category::factory()->create();
    $ebook = \App\Models\Ebook::factory()->create([
        'category_id' => $category->id,
    ]);

    $purchase = \App\Models\Purchase::create([
        'ebook_id' => $ebook->id,
        'name' => 'Test User',
        'email' => 'test@example.com',
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchase->load('ebook');

    $mailable = new \App\Mail\EbookDownloadEmail($purchase);

    $mailable->assertDontSeeInHtml('unsubscribe');
    $mailable->assertDontSeeInHtml('Unsubscribe');
});
