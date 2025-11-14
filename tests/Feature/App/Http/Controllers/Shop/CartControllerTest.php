<?php

namespace Tests\Feature\App\Http\Controllers\Shop;

use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Support\Facades\Session;

test('cart index displays empty cart', function () {
    Session::forget('cart');

    $response = $this->get(route('cart.index'));

    $response->assertStatus(200);
    $response->assertViewIs('shop.cart');
    $response->assertViewHas('ebooks', []);
    $response->assertViewHas('total', 0);
});

test('cart index displays cart items and total', function () {
    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test1.pdf',
        'price' => 29.99,
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test2.pdf',
        'price' => 39.99,
    ]);

    Session::put('cart', [$ebook1->id, $ebook2->id]);

    $response = $this->get(route('cart.index'));

    $response->assertStatus(200);
    $response->assertViewIs('shop.cart');
    $ebooks = $response->viewData('ebooks');
    $this->assertCount(2, $ebooks);
    $response->assertViewHas('total', 69.98);
});

test('cart index filters out non-existent ebooks', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test.pdf',
        'price' => 29.99,
    ]);

    Session::put('cart', [$ebook->id, 99999]);

    $response = $this->get(route('cart.index'));

    $response->assertStatus(200);
    $ebooks = $response->viewData('ebooks');
    $this->assertCount(1, $ebooks);
    $response->assertViewHas('total', 29.99);
});

test('add ebook to cart adds it successfully', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test.pdf',
    ]);

    Session::forget('cart');

    $response = $this->post(route('cart.add', ['ebook' => $ebook->id]));

    $response->assertRedirect();
    $response->assertSessionHas('success');
    $cart = Session::get('cart', []);
    $this->assertContains($ebook->id, $cart);
});

test('add ebook to cart shows info message when already in cart', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test.pdf',
    ]);

    Session::put('cart', [$ebook->id]);

    $response = $this->post(route('cart.add', ['ebook' => $ebook->id]));

    $response->assertRedirect();
    $response->assertSessionHas('info');
    $cart = Session::get('cart', []);
    $this->assertCount(1, $cart);
    $this->assertContains($ebook->id, $cart);
});

test('remove ebook from cart removes it successfully', function () {
    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test1.pdf',
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test2.pdf',
    ]);

    Session::put('cart', [$ebook1->id, $ebook2->id]);

    $response = $this->delete(route('cart.remove', ['ebook' => $ebook1->id]));

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('success');
    $cart = Session::get('cart', []);
    $this->assertNotContains($ebook1->id, $cart);
    $this->assertContains($ebook2->id, $cart);
});

test('remove ebook from cart returns 404 for non-existent ebook', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test.pdf',
    ]);

    Session::put('cart', [$ebook->id]);

    // Laravel model binding returns 404 for non-existent models
    $response = $this->delete(route('cart.remove', ['ebook' => 99999]));

    $response->assertStatus(404);
    // Cart should remain unchanged
    $cart = Session::get('cart', []);
    $this->assertContains($ebook->id, $cart);
});

test('clear cart removes all items', function () {
    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test1.pdf',
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/test2.pdf',
    ]);

    Session::put('cart', [$ebook1->id, $ebook2->id]);

    $response = $this->delete(route('cart.clear'));

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('success');
    $cart = Session::get('cart', []);
    $this->assertEmpty($cart);
});

test('clear cart works when cart is already empty', function () {
    Session::forget('cart');

    $response = $this->delete(route('cart.clear'));

    $response->assertRedirect(route('cart.index'));
    $response->assertSessionHas('success');
    $cart = Session::get('cart', []);
    $this->assertEmpty($cart);
});
