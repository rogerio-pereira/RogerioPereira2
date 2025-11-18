<?php

namespace Tests\Feature\App\Jobs;

use App\Jobs\SetupEbookJob;
use App\Models\Category;
use App\Models\Ebook;
use App\Services\MauticService;
use Database\Seeders\CategorySeeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Mockery;

beforeEach(function () {
    $this->seed(CategorySeeder::class);
});

afterEach(function () {
    Mockery::close();
});

test('setup ebook job creates all mautic resources successfully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 2, // Marketing
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_test-ebook_purchased';
    $fieldLabel = 'E-book Test Ebook - Download Hash';
    $downloadUrl = route('ebooks.download', $ebook);
    $emailName = 'deliver_ebook_test-ebook';
    $emailSubject = 'Your e-book: Test Ebook';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->with('Test Ebook', $downloadUrl)
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->with('Test Ebook', $fieldAlias)
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->with($emailName, $emailSubject, Mockery::type('string'), [350])
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->with(300, ['isPublished' => true])
        ->andReturn(['email' => ['id' => 300, 'isPublished' => true]]);

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);
    $job->handle($mauticService);

    $ebook->refresh();
    expect($ebook->mautic_field_id)->toEqual(100);
    expect($ebook->mautic_field_alias)->toBe($fieldAlias);
    expect($ebook->mautic_asset_id)->toEqual(200);
    expect($ebook->mautic_email_id)->toEqual(300);
    expect($ebook->mautic_email_name)->toBe($emailName);
    expect($ebook->mautic_segment_id)->toEqual(350);
    expect($ebook->last_email_html)->not->toBeNull();
});

test('setup ebook job generates slug when missing', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'My Test Ebook',
        'slug' => null,
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_my-test-ebook_purchased';
    $fieldLabel = 'E-book My Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->with('My Test Ebook', Mockery::type('string'))
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->with(Mockery::type('string'), Mockery::type('string'), Mockery::type('string'), [350])
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->with(300, ['isPublished' => true])
        ->andReturn(['email' => ['id' => 300, 'isPublished' => true]]);

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);
    $job->handle($mauticService);

    $ebook->refresh();
    expect($ebook->slug)->toBe('my-test-ebook');
});

test('setup ebook job throws exception when ebook has no file', function () {
    $ebook = Ebook::factory()->create([
        'category_id' => 3, // Software Development
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => null,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $mauticService->shouldNotReceive('createContactField');
    $mauticService->shouldNotReceive('createAsset');
    $mauticService->shouldNotReceive('createSegment');
    $mauticService->shouldNotReceive('createSegmentEmail');

    Log::shouldReceive('warning')
        ->once()
        ->with('SetupEbookJob: Ebook does not have a file', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Ebook must have a file to create Mautic asset');
});

test('setup ebook job throws exception when contact field creation fails', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 2, // Marketing
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_test-ebook_purchased';
    $fieldLabel = 'E-book Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => []]);

    $mauticService->shouldNotReceive('createAsset');
    $mauticService->shouldNotReceive('createSegment');
    $mauticService->shouldNotReceive('createSegmentEmail');
    $mauticService->shouldNotReceive('unpublishSegment');
    $mauticService->shouldNotReceive('unpublishEmail');
    $mauticService->shouldNotReceive('unpublishAsset');

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic contact field');
});

test('setup ebook job rolls back asset when asset creation fails', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_test-ebook_purchased';
    $fieldLabel = 'E-book Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => []]);

    $mauticService->shouldNotReceive('createSegment');
    $mauticService->shouldNotReceive('createSegmentEmail');
    $mauticService->shouldNotReceive('createCampaign');
    $mauticService->shouldNotReceive('unpublishCampaign');
    $mauticService->shouldNotReceive('unpublishEmail');
    $mauticService->shouldReceive('unpublishAsset')
        ->never();

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic asset');
});

test('setup ebook job rolls back email when email creation fails', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 3, // Software Development
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->andReturn(['email' => []]);

    $mauticService->shouldReceive('unpublishSegment')
        ->once()
        ->with(350)
        ->andReturn(['success' => true]);
    $mauticService->shouldNotReceive('unpublishEmail');
    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment email');
});

test('setup ebook job rolls back segment when segment creation fails', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 2, // Marketing
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => []]);

    $mauticService->shouldNotReceive('createSegmentEmail');
    $mauticService->shouldNotReceive('unpublishEmail');

    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment');
});

test('setup ebook job handles rollback failures gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->andReturn(['email' => []]);

    $mauticService->shouldReceive('unpublishSegment')
        ->once()
        ->with(350)
        ->andReturn(['success' => true]);
    $mauticService->shouldNotReceive('unpublishEmail');
    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andThrow(new \RuntimeException('Rollback failed'));

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    Log::shouldReceive('warning')
        ->once()
        ->with('Failed to rollback asset', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment email');
});

test('setup ebook job handles segment rollback failure gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 3, // Software Development
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => []]);

    $mauticService->shouldNotReceive('createSegmentEmail');
    $mauticService->shouldNotReceive('unpublishEmail');

    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment');
});

test('setup ebook job handles email rollback failure gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 2, // Marketing
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => []]);

    $mauticService->shouldNotReceive('createSegmentEmail');
    $mauticService->shouldNotReceive('unpublishSegment');
    $mauticService->shouldNotReceive('unpublishEmail');

    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment');
});

test('setup ebook job handles asset rollback failure gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->andReturn(['email' => []]);

    $mauticService->shouldReceive('unpublishSegment')
        ->once()
        ->with(350)
        ->andReturn(['success' => true]);
    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andThrow(new \RuntimeException('Rollback asset failed'));

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    Log::shouldReceive('warning')
        ->once()
        ->with('Failed to rollback asset', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment email');
});

test('setup ebook job generates slug when slug is empty string', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 3, // Software Development
        'name' => 'Another Test Ebook',
        'slug' => '',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_another-test-ebook_purchased';
    $fieldLabel = 'E-book Another Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->with('Another Test Ebook', Mockery::type('string'))
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->with(Mockery::type('string'), Mockery::type('string'), Mockery::type('string'), [350])
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->with(300, ['isPublished' => true])
        ->andReturn(['email' => ['id' => 300, 'isPublished' => true]]);

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);
    $job->handle($mauticService);

    $ebook->refresh();
    expect($ebook->slug)->toBe('another-test-ebook');
});

test('setup ebook job generates slug when slug is null after fresh', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    // Create ebook - observer will generate slug, but we'll set it to null manually
    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'Fresh Test Ebook',
        'file' => $path,
    ]);

    // Manually set slug to null to simulate a case where slug is missing after fresh
    $ebook->update(['slug' => null]);
    $ebook->refresh();

    // Verify slug is null after fresh (simulating the job's fresh call)
    expect($ebook->fresh()->slug)->toBeNull();

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_fresh-test-ebook_purchased';
    $fieldLabel = 'E-book Fresh Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->with('Fresh Test Ebook', Mockery::type('string'))
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->with(Mockery::type('string'), Mockery::type('string'), Mockery::type('string'), [350])
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->with(300, ['isPublished' => true])
        ->andReturn(['email' => ['id' => 300, 'isPublished' => true]]);

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);
    $job->handle($mauticService);

    $ebook->refresh();
    expect($ebook->slug)->toBe('fresh-test-ebook');
});

test('setup ebook job uses fallback template when category template does not exist', function () {
    Storage::fake('public');

    // Create a category that doesn't have a corresponding email template
    $category = Category::factory()->create(['name' => 'Unknown Category']);
    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => $category->id,
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);
    $fieldAlias = 'ebook_test-ebook_purchased';
    $fieldLabel = 'E-book Test Ebook - Download Hash';

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->with($fieldAlias, 'text', $fieldLabel)
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->with('Test Ebook', Mockery::type('string'))
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->with(350, ['isPublished' => true])
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->with('deliver_ebook_test-ebook', 'Your e-book: Test Ebook', Mockery::type('string'), [350])
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->with(300, ['isPublished' => true])
        ->andReturn(['email' => ['id' => 300, 'isPublished' => true]]);

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);
    $job->handle($mauticService);

    $ebook->refresh();
    expect($ebook->mautic_email_id)->toEqual(300);
    expect($ebook->last_email_html)->not->toBeNull();
    // Verify that marketing template was used (fallback)
    // The marketing template should contain the ebook name
    expect($ebook->last_email_html)->toContain('Test Ebook');
});

test('setup ebook job handles segment rollback exception gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 1, // Automation
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->andReturn(['email' => []]); // This will cause failure

    // Rollback should be attempted
    $mauticService->shouldReceive('unpublishSegment')
        ->once()
        ->with(350)
        ->andThrow(new \RuntimeException('Rollback segment failed'));

    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    Log::shouldReceive('warning')
        ->once()
        ->with('Failed to rollback segment', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Failed to create Mautic segment email');
});

test('setup ebook job handles email rollback exception gracefully', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->create('ebook.pdf', 1000);
    $path = Storage::putFile('ebooks', $file, 'public');

    $ebook = Ebook::factory()->create([
        'category_id' => 2, // Marketing
        'name' => 'Test Ebook',
        'slug' => 'test-ebook',
        'file' => $path,
    ]);

    $mauticService = Mockery::mock(MauticService::class);

    $mauticService->shouldReceive('createContactField')
        ->once()
        ->andReturn(['field' => ['id' => 100]]);

    $mauticService->shouldReceive('createAsset')
        ->once()
        ->andReturn(['asset' => ['id' => 200]]);

    $mauticService->shouldReceive('createSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350]]);

    $mauticService->shouldReceive('updateSegment')
        ->once()
        ->andReturn(['list' => ['id' => 350, 'isPublished' => true]]);

    $mauticService->shouldReceive('createSegmentEmail')
        ->once()
        ->andReturn(['email' => ['id' => 300]]);

    $mauticService->shouldReceive('updateEmail')
        ->once()
        ->andThrow(new \RuntimeException('Update email failed')); // This will cause failure

    // Rollback should be attempted
    $mauticService->shouldReceive('unpublishSegment')
        ->once()
        ->with(350)
        ->andReturn(['success' => true]);

    $mauticService->shouldReceive('unpublishEmail')
        ->once()
        ->with(300)
        ->andThrow(new \RuntimeException('Rollback email failed'));

    $mauticService->shouldReceive('unpublishAsset')
        ->once()
        ->with(200)
        ->andReturn(['success' => true]);

    Log::shouldReceive('error')
        ->once()
        ->with('SetupEbookJob failed', Mockery::type('array'));

    Log::shouldReceive('warning')
        ->once()
        ->with('Failed to rollback email', Mockery::type('array'));

    $this->app->instance(MauticService::class, $mauticService);

    $job = new SetupEbookJob($ebook);

    expect(fn () => $job->handle($mauticService))
        ->toThrow(\RuntimeException::class, 'Update email failed');
});
