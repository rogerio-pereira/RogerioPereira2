<?php

namespace Tests\Feature\App\Http\Controllers;

use App\Models\Category;
use App\Models\Ebook;
use App\Services\MauticService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Mockery;

afterEach(function () {
    Mockery::close();
});

test('user can download ebook file when file exists', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
    ]);

    $response = $this->get(route('ebooks.download', $ebook));

    $response->assertStatus(200);
    $response->assertDownload();
});

test('download returns 404 when ebook file does not exist', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => 'ebooks/non-existent.pdf',
    ]);

    $response = $this->get(route('ebooks.download', $ebook));

    $response->assertStatus(404);
});

test('download returns 404 when ebook has no file', function () {
    $category = Category::factory()->create();
    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => null,
    ]);

    $response = $this->get(route('ebooks.download', $ebook));

    $response->assertStatus(404);
});

test('download tracks in mautic when asset id exists and hash is provided', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
        'mautic_asset_id' => 123,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $mauticService->shouldReceive('trackAssetDownload')
        ->once()
        ->with(123, 'user@example.com')
        ->andReturn(['success' => true]);

    $this->app->instance(MauticService::class, $mauticService);

    $response = $this->get(route('ebooks.download', $ebook).'?hash=user@example.com');

    $response->assertStatus(200);
    $response->assertDownload();
});

test('download does not track in mautic when asset id does not exist', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
        'mautic_asset_id' => null,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $mauticService->shouldNotReceive('trackAssetDownload');

    $this->app->instance(MauticService::class, $mauticService);

    $response = $this->get(route('ebooks.download', $ebook).'?hash=user@example.com');

    $response->assertStatus(200);
    $response->assertDownload();
});

test('download does not track in mautic when hash is not provided', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
        'mautic_asset_id' => 123,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $mauticService->shouldNotReceive('trackAssetDownload');

    $this->app->instance(MauticService::class, $mauticService);

    $response = $this->get(route('ebooks.download', $ebook));

    $response->assertStatus(200);
    $response->assertDownload();
});

test('download continues even when mautic tracking fails', function () {
    Storage::fake('public');

    $category = Category::factory()->create();
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'file' => $path,
        'mautic_asset_id' => 123,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $mauticService->shouldReceive('trackAssetDownload')
        ->once()
        ->with(123, 'user@example.com')
        ->andThrow(new \RuntimeException('Mautic API error'));

    $this->app->instance(MauticService::class, $mauticService);

    // Download should succeed even if Mautic tracking fails
    $response = $this->get(route('ebooks.download', $ebook).'?hash=user@example.com');

    $response->assertStatus(200);
    $response->assertDownload();
});
