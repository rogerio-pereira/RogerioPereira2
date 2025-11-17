<?php

namespace Tests\Feature\App\Http\Controllers\Core;

use App\Jobs\DeactivateEbookJob;
use App\Jobs\SetupEbookJob;
use App\Jobs\UpdateEbookJob;
use App\Models\Category;
use App\Models\Ebook;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

test('guests cannot access ebooks index', function () {
    $response = $this->get(route('core.ebooks.index'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view ebooks index', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    Ebook::factory()->count(3)->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.index'));

    $response->assertStatus(200);
    $response->assertViewIs('core.ebooks.index');
    $response->assertViewHas('ebooks');
});

test('guests cannot access create ebook page', function () {
    $response = $this->get(route('core.ebooks.create'));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view create ebook page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Category::factory()->count(3)->create();

    $response = $this->get(route('core.ebooks.create'));

    $response->assertStatus(200);
    $response->assertViewIs('core.ebooks.form');
    $response->assertViewHas('categories');
});

test('guests cannot store an ebook', function () {
    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => $category->id,
        'price' => 29.99,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can create an ebook', function () {
    Queue::fake();
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600);

    $ebookData = [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
        'image' => $image,
    ];

    $response = $this->post(route('core.ebooks.store'), $ebookData);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('ebooks', [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => $category->id,
        'price' => 29.99,
    ]);

    Queue::assertPushed(SetupEbookJob::class, function ($job) {
        return $job->ebook->name === 'Test Ebook';
    });
});

test('ebook creation requires name field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'description' => 'Test Description',
        'category_id' => $category->id,
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('ebook creation requires category_id field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['category_id']);
});

test('ebook creation requires valid category_id', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => 999,
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['category_id']);
});

test('ebook creation requires price field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => $category->id,
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('ebook price must be numeric', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 'invalid',
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('ebook price must be at least 0', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => -10,
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('ebook price must not exceed 999999.99', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 1000000,
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('ebook creation requires file field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'description' => 'Test Description',
        'category_id' => $category->id,
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['file']);
});

test('ebook file must be a pdf', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.txt', 1000);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
    ]);

    $response->assertSessionHasErrors(['file']);
});

test('ebook file must not exceed 10MB', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 10241); // 10MB + 1KB

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
    ]);

    $response->assertSessionHasErrors(['file']);
});

test('ebook image must be an image', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $image = UploadedFile::fake()->create('cover.txt', 1000);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
        'image' => $image,
    ]);

    $response->assertSessionHasErrors(['image']);
});

test('ebook image must be jpeg, jpg, png or webp', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $image = UploadedFile::fake()->create('cover.gif', 1000);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
        'image' => $image,
    ]);

    $response->assertSessionHasErrors(['image']);
});

test('ebook image must not exceed 2MB', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $image = UploadedFile::fake()->image('cover.jpg', 800, 600)->size(2049); // 2MB + 1KB

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
        'image' => $image,
    ]);

    $response->assertSessionHasErrors(['image']);
});

test('ebook can be created without description', function () {
    Queue::fake();
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('ebooks', [
        'name' => 'Test Ebook',
        'description' => null,
        'category_id' => $category->id,
        'price' => 29.99,
    ]);
});

test('ebook can be created without image', function () {
    Queue::fake();
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);

    $response = $this->post(route('core.ebooks.store'), [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
        'file' => $file,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('ebooks', [
        'name' => 'Test Ebook',
        'category_id' => $category->id,
        'price' => 29.99,
    ]);
});

test('ebook name must not exceed 255 characters', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();

    $response = $this->post(route('core.ebooks.store'), [
        'name' => str_repeat('a', 256),
        'category_id' => $category->id,
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('guests cannot access edit ebook page', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.edit', $ebook));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view edit ebook page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    Category::factory()->count(3)->create();

    $response = $this->get(route('core.ebooks.edit', $ebook));

    $response->assertStatus(200);
    $response->assertViewIs('core.ebooks.form');
    $response->assertViewHas('ebook');
    $response->assertViewHas('categories');
});

test('guests cannot update an ebook', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Updated Ebook',
        'category_id' => $ebook->category_id,
        'price' => 39.99,
    ]);

    $response->assertRedirect(route('login'));
});

test('authenticated users can update an ebook', function () {
    Queue::fake();
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'name' => 'Original Name',
        'price' => 29.99,
        'category_id' => $category->id,
    ]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Updated Name',
        'description' => 'Updated Description',
        'category_id' => $ebook->category_id,
        'price' => 39.99,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('ebooks', [
        'id' => $ebook->id,
        'name' => 'Updated Name',
        'description' => 'Updated Description',
        'price' => 39.99,
    ]);

    Queue::assertPushed(UpdateEbookJob::class, function ($job) use ($ebook) {
        return $job->ebook->id === $ebook->id;
    });
});

test('ebook update requires name field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'category_id' => $ebook->category_id,
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['name']);
});

test('ebook update requires category_id field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Test Ebook',
        'price' => 29.99,
    ]);

    $response->assertSessionHasErrors(['category_id']);
});

test('ebook update requires price field', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Test Ebook',
        'category_id' => $ebook->category_id,
    ]);

    $response->assertSessionHasErrors(['price']);
});

test('ebook file is optional on update', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Updated Ebook',
        'category_id' => $ebook->category_id,
        'price' => 39.99,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');
});

test('ebook can update file', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $newFile = UploadedFile::fake()->create('new-ebook.pdf', 1000);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => $ebook->name,
        'category_id' => $ebook->category_id,
        'price' => $ebook->price,
        'file' => $newFile,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');
});

test('ebook can update image', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);
    $newImage = UploadedFile::fake()->image('new-cover.jpg', 800, 600);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => $ebook->name,
        'category_id' => $ebook->category_id,
        'price' => $ebook->price,
        'image' => $newImage,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');
});

test('guests cannot delete an ebook', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->delete(route('core.ebooks.destroy', $ebook));

    $response->assertRedirect(route('login'));
});

test('authenticated users can delete an ebook', function () {
    Queue::fake();
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->delete(route('core.ebooks.destroy', $ebook));

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    // Ebook uses soft delete, so it should still exist but be soft deleted
    $this->assertSoftDeleted('ebooks', [
        'id' => $ebook->id,
    ]);
    $this->assertNull(Ebook::find($ebook->id));

    Queue::assertPushed(DeactivateEbookJob::class, function ($job) use ($ebook) {
        return $job->ebook->id === $ebook->id;
    });
});

test('guests cannot download an ebook', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.download', $ebook));

    $response->assertRedirect(route('login'));
});

test('authenticated users can download an ebook', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
    ]);

    $response = $this->get(route('core.ebooks.download', $ebook));

    $response->assertStatus(200);
    $response->assertDownload();
});

test('download returns 404 when file does not exist', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => null,
    ]);

    $response = $this->get(route('core.ebooks.download', $ebook));

    $response->assertStatus(404);
});

test('download returns 404 when file is not found in storage', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/non-existent-file.pdf',
    ]);

    $response = $this->get(route('core.ebooks.download', $ebook));

    $response->assertStatus(404);
});

test('guests cannot access show ebook', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.show', $ebook));

    $response->assertRedirect(route('login'));
});

test('authenticated users can view show ebook', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.show', $ebook));

    $response->assertStatus(200);
    $response->assertJson([
        'id' => $ebook->id,
        'name' => $ebook->name,
        'description' => $ebook->description,
        'price' => $ebook->price,
        'category_id' => $ebook->category_id,
    ]);
});

test('ebooks index displays ebooks ordered by latest', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook1 = Ebook::factory()->create([
        'category_id' => $category->id,
        'created_at' => now()->subDay(),
    ]);
    $ebook2 = Ebook::factory()->create([
        'category_id' => $category->id,
        'created_at' => now(),
    ]);

    $response = $this->get(route('core.ebooks.index'));

    $response->assertStatus(200);
    $ebooks = $response->viewData('ebooks');
    $this->assertEquals($ebook2->id, $ebooks->first()->id);
    $this->assertEquals($ebook1->id, $ebooks->last()->id);
});

test('ebooks index paginates results', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    Ebook::factory()->count(20)->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.index'));

    $response->assertStatus(200);
    $ebooks = $response->viewData('ebooks');
    $this->assertCount(15, $ebooks);
    $this->assertTrue($ebooks->hasMorePages());
});

test('ebooks index loads category relationship', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create(['category_id' => $category->id]);

    $response = $this->get(route('core.ebooks.index'));

    $response->assertStatus(200);
    $ebooks = $response->viewData('ebooks');
    $this->assertTrue($ebooks->first()->relationLoaded('category'));
});

test('authenticated users can delete ebook without files', function () {
    Queue::fake();
    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => null,
        'image' => null,
    ]);

    $response = $this->delete(route('core.ebooks.destroy', $ebook));

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    // Ebook uses soft delete, so it should still exist but be soft deleted
    $this->assertSoftDeleted('ebooks', [
        'id' => $ebook->id,
    ]);
    $this->assertNull(Ebook::find($ebook->id));

    Queue::assertPushed(DeactivateEbookJob::class, function ($job) use ($ebook) {
        return $job->ebook->id === $ebook->id;
    });
});

test('ebook update maintains old file when no new file is provided', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $oldFile = UploadedFile::fake()->create('old-ebook.pdf', 1000);
    $oldFilePath = Storage::putFile('ebooks', $oldFile, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $oldFilePath,
    ]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Updated Ebook',
        'category_id' => $ebook->category_id,
        'price' => 39.99,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $ebook->refresh();
    $this->assertEquals($oldFilePath, $ebook->file);
});

test('ebook update maintains old image when no new image is provided', function () {
    Storage::fake('local');

    $user = User::factory()->create();
    $this->actingAs($user);

    $category = Category::factory()->create();
    $oldImage = UploadedFile::fake()->image('old-cover.jpg', 800, 600);
    $oldImagePath = Storage::putFile('ebooks/images', $oldImage, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'image' => $oldImagePath,
    ]);

    $response = $this->put(route('core.ebooks.update', $ebook), [
        'name' => 'Updated Ebook',
        'category_id' => $ebook->category_id,
        'price' => 39.99,
    ]);

    $response->assertRedirect(route('core.ebooks.index'));
    $response->assertSessionHas('success');

    $ebook->refresh();
    $this->assertEquals($oldImagePath, $ebook->image);
});
