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
}
