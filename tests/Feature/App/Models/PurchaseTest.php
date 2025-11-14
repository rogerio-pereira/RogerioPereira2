<?php

namespace Tests\Feature\App\Models;

use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;

test('purchase belongs to ebook relationship', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchaseEbook = $purchase->ebook;

    $this->assertNotNull($purchaseEbook);
    $this->assertEquals($ebook->id, $purchaseEbook->id);
    $this->assertEquals($ebook->name, $purchaseEbook->name);
});

test('purchase ebook relationship loads ebook correctly', function () {
    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create(['category_id' => $category->id]);
    $ebook2 = Ebook::factory()->create(['category_id' => $category->id]);

    $purchase1 = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook1->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchase2 = Purchase::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '0987654321',
        'ebook_id' => $ebook2->id,
        'amount' => 39.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchase1Ebook = $purchase1->ebook;
    $purchase2Ebook = $purchase2->ebook;

    $this->assertNotNull($purchase1Ebook);
    $this->assertEquals($ebook1->id, $purchase1Ebook->id);
    $this->assertEquals($ebook1->name, $purchase1Ebook->name);

    $this->assertNotNull($purchase2Ebook);
    $this->assertEquals($ebook2->id, $purchase2Ebook->id);
    $this->assertEquals($ebook2->name, $purchase2Ebook->name);
});
