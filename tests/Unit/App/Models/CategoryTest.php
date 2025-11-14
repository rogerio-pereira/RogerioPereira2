<?php

namespace Tests\Unit\App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class CategoryTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Category;
    }

    protected function expectedTableName(): string
    {
        return 'categories';
    }

    protected function expectedTraits(): array
    {
        return [
            HasFactory::class,
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'name',
            'color',
        ];
    }

    protected function expectedHidden(): array
    {
        return [];
    }

    protected function expectedCasts(): array
    {
        return [
            'id' => 'int',
        ];
    }

    /*
     * =================================================================================================================
     * Category Model Tests
     * =================================================================================================================
     */

    public function test_category_can_be_instantiated(): void
    {
        $category = new Category();
        $category->name = 'Test Category';
        $category->color = '#FF5733';

        $this->assertEquals('Test Category', $category->name);
        $this->assertEquals('#FF5733', $category->color);
    }
}

