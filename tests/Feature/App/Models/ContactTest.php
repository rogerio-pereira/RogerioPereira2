<?php

namespace Tests\Feature\App\Models;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Ebook;
use App\Models\Purchase;

test('contact has many purchases relationship using email', function () {
    $contact = Contact::factory()->create([
        'email' => 'test@example.com',
    ]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase1 = Purchase::create([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchase2 = Purchase::create([
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 39.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchases = $contact->purchases;

    $this->assertCount(2, $purchases);
    $this->assertTrue($purchases->contains($purchase1));
    $this->assertTrue($purchases->contains($purchase2));
});

test('contact purchases relationship returns empty collection when no purchases', function () {
    $contact = Contact::factory()->create([
        'email' => 'test@example.com',
    ]);

    $purchases = $contact->purchases;

    $this->assertCount(0, $purchases);
    $this->assertTrue($purchases->isEmpty());
});

test('contact purchases relationship only returns purchases for that email', function () {
    $contact1 = Contact::factory()->create([
        'email' => 'test1@example.com',
    ]);

    $contact2 = Contact::factory()->create([
        'email' => 'test2@example.com',
    ]);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase1 = Purchase::create([
        'name' => 'John Doe',
        'email' => 'test1@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchase2 = Purchase::create([
        'name' => 'Jane Doe',
        'email' => 'test2@example.com',
        'phone' => '0987654321',
        'ebook_id' => $ebook->id,
        'amount' => 39.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $contact1Purchases = $contact1->purchases;
    $contact2Purchases = $contact2->purchases;

    $this->assertCount(1, $contact1Purchases);
    $this->assertTrue($contact1Purchases->contains($purchase1));
    $this->assertFalse($contact1Purchases->contains($purchase2));

    $this->assertCount(1, $contact2Purchases);
    $this->assertTrue($contact2Purchases->contains($purchase2));
    $this->assertFalse($contact2Purchases->contains($purchase1));
});
