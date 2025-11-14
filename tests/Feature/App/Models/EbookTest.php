<?php

namespace Tests\Feature\App\Models;

use App\Models\Category;
use App\Models\Ebook;
use App\Models\Purchase;

test('ebook belongs to category relationship', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $ebookCategory = $ebook->category;

    $this->assertNotNull($ebookCategory);
    $this->assertEquals($category->id, $ebookCategory->id);
    $this->assertEquals($category->name, $ebookCategory->name);
});

test('ebook has many purchases relationship', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $purchase1 = Purchase::create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '1234567890',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);
    $purchase2 = Purchase::create([
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'phone' => '0987654321',
        'ebook_id' => $ebook->id,
        'amount' => 29.99,
        'currency' => 'usd',
        'status' => 'completed',
    ]);

    $purchases = $ebook->purchases;

    $this->assertCount(2, $purchases);
    $this->assertTrue($purchases->contains($purchase1));
    $this->assertTrue($purchases->contains($purchase2));
});

test('ebook purchases relationship returns empty collection when no purchases', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $purchases = $ebook->purchases;

    $this->assertCount(0, $purchases);
    $this->assertTrue($purchases->isEmpty());
});

test('ebook purchases relationship only returns purchases for that ebook', function () {
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

    $ebook1Purchases = $ebook1->purchases;
    $ebook2Purchases = $ebook2->purchases;

    $this->assertCount(1, $ebook1Purchases);
    $this->assertTrue($ebook1Purchases->contains($purchase1));
    $this->assertFalse($ebook1Purchases->contains($purchase2));

    $this->assertCount(1, $ebook2Purchases);
    $this->assertTrue($ebook2Purchases->contains($purchase2));
    $this->assertFalse($ebook2Purchases->contains($purchase1));
});
