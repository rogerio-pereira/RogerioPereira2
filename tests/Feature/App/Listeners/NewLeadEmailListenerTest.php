<?php

namespace Tests\Feature\App\Listeners;

use App\Events\NewLead;
use App\Listeners\NewLeadEmailListener;
use App\Mail\NewLeadEmail;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

test('new lead email listener sends email for automation category', function () {
    Mail::fake();

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'automation');

    $listener = new NewLeadEmailListener;
    $listener->handle($event);

    Mail::assertQueued(NewLeadEmail::class, function ($mail) use ($contact) {
        return $mail->hasTo($contact->email)
            && $mail->contact->id === $contact->id
            && $mail->category === 'automation';
    });
});

test('new lead email listener sends email for marketing category', function () {
    Mail::fake();

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'marketing');

    $listener = new NewLeadEmailListener;
    $listener->handle($event);

    Mail::assertQueued(NewLeadEmail::class, function ($mail) use ($contact) {
        return $mail->hasTo($contact->email)
            && $mail->contact->id === $contact->id
            && $mail->category === 'marketing';
    });
});

test('new lead email listener sends email for software development category', function () {
    Mail::fake();

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'software-development');

    $listener = new NewLeadEmailListener;
    $listener->handle($event);

    Mail::assertQueued(NewLeadEmail::class, function ($mail) use ($contact) {
        return $mail->hasTo($contact->email)
            && $mail->contact->id === $contact->id
            && $mail->category === 'software-development';
    });
});

test('new lead email listener queues email', function () {
    Mail::fake();

    $contact = Contact::factory()->create();
    $event = new NewLead($contact, 'automation');

    $listener = new NewLeadEmailListener;
    $listener->handle($event);

    Mail::assertQueued(NewLeadEmail::class);
});

test('new lead email listener sends to correct email address', function () {
    Mail::fake();

    $contact = Contact::factory()->create([
        'email' => 'test@example.com',
    ]);
    $event = new NewLead($contact, 'marketing');

    $listener = new NewLeadEmailListener;
    $listener->handle($event);

    Mail::assertQueued(NewLeadEmail::class, function ($mail) {
        return $mail->hasTo('test@example.com');
    });
});
