<?php

namespace Tests\Feature\App\Models;

use App\Models\Category;
use App\Models\Ebook;

test('category has many ebooks relationship', function () {
    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create(['category_id' => $category->id]);
    $ebook2 = Ebook::factory()->create(['category_id' => $category->id]);

    $ebooks = $category->ebooks;

    $this->assertCount(2, $ebooks);
    $this->assertTrue($ebooks->contains($ebook1));
    $this->assertTrue($ebooks->contains($ebook2));
});

test('category ebooks relationship returns empty collection when no ebooks', function () {
    $category = Category::factory()->create();

    $ebooks = $category->ebooks;

    $this->assertCount(0, $ebooks);
    $this->assertTrue($ebooks->isEmpty());
});

test('category ebooks relationship only returns ebooks for that category', function () {
    $category1 = Category::factory()->create();
    $category2 = Category::factory()->create();

    $ebook1 = Ebook::factory()->create(['category_id' => $category1->id]);
    $ebook2 = Ebook::factory()->create(['category_id' => $category2->id]);

    $category1Ebooks = $category1->ebooks;
    $category2Ebooks = $category2->ebooks;

    $this->assertCount(1, $category1Ebooks);
    $this->assertTrue($category1Ebooks->contains($ebook1));
    $this->assertFalse($category1Ebooks->contains($ebook2));

    $this->assertCount(1, $category2Ebooks);
    $this->assertTrue($category2Ebooks->contains($ebook2));
    $this->assertFalse($category2Ebooks->contains($ebook1));
});

