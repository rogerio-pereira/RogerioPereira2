<?php

namespace Tests\Unit\App\Models;

use App\Models\Ebook;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class EbookTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Ebook;
    }

    protected function expectedTableName(): string
    {
        return 'ebooks';
    }

    protected function expectedPrimaryKeyType(): string
    {
        return 'string';
    }

    protected function expectedTraits(): array
    {
        return [
            HasFactory::class,
            HasUuids::class,
            SoftDeletes::class,
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'name',
            'slug',
            'description',
            'category_id',
            'price',
            'file',
            'image',
            'mautic_asset_id',
            'mautic_field_id',
            'mautic_field_alias',
            'mautic_email_id',
            'mautic_email_name',
            'mautic_campaign_id',
            'last_email_html',
        ];
    }

    protected function expectedHidden(): array
    {
        return [];
    }

    protected function expectedCasts(): array
    {
        return [
            'price' => 'decimal:2',
            'deleted_at' => 'datetime',
        ];
    }

    /*
     * =================================================================================================================
     * Ebook Model Tests
     * =================================================================================================================
     */

    public function test_ebook_can_be_instantiated(): void
    {
        $ebook = new Ebook;
        $ebook->name = 'Test Ebook';
        $ebook->description = 'Test Description';
        $ebook->category_id = 1;
        $ebook->price = 29.99;
        $ebook->file = 'ebooks/test.pdf';
        $ebook->image = 'ebooks/images/test.jpg';

        $this->assertEquals('Test Ebook', $ebook->name);
        $this->assertEquals('Test Description', $ebook->description);
        $this->assertEquals(1, $ebook->category_id);
        $this->assertEquals(29.99, $ebook->price);
        $this->assertEquals('ebooks/test.pdf', $ebook->file);
        $this->assertEquals('ebooks/images/test.jpg', $ebook->image);
    }

    public function test_ebook_mautic_fields_can_be_null(): void
    {
        $ebook = new Ebook;
        $ebook->name = 'Test Ebook';
        $ebook->category_id = 1;
        $ebook->price = 29.99;

        $this->assertNull($ebook->mautic_asset_id);
        $this->assertNull($ebook->mautic_field_id);
        $this->assertNull($ebook->mautic_field_alias);
        $this->assertNull($ebook->mautic_email_id);
        $this->assertNull($ebook->mautic_email_name);
        $this->assertNull($ebook->mautic_campaign_id);
        $this->assertNull($ebook->last_email_html);
    }

    public function test_ebook_mautic_fields_can_be_set(): void
    {
        $ebook = new Ebook;
        $ebook->name = 'Test Ebook';
        $ebook->category_id = 1;
        $ebook->price = 29.99;
        $ebook->mautic_asset_id = 'asset_123';
        $ebook->mautic_field_id = 456;
        $ebook->mautic_field_alias = 'ebook_test_purchased';
        $ebook->mautic_email_id = 789;
        $ebook->mautic_email_name = 'deliver_ebook_test';
        $ebook->mautic_campaign_id = 101;
        $ebook->last_email_html = '<html>Test</html>';

        $this->assertEquals('asset_123', $ebook->mautic_asset_id);
        $this->assertEquals(456, $ebook->mautic_field_id);
        $this->assertEquals('ebook_test_purchased', $ebook->mautic_field_alias);
        $this->assertEquals(789, $ebook->mautic_email_id);
        $this->assertEquals('deliver_ebook_test', $ebook->mautic_email_name);
        $this->assertEquals(101, $ebook->mautic_campaign_id);
        $this->assertEquals('<html>Test</html>', $ebook->last_email_html);
    }
}
