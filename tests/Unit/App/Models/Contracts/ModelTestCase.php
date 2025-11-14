<?php

namespace Tests\Unit\App\Models\Contracts;

use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

abstract class ModelTestCase extends TestCase
{
    abstract protected function model(): Model;

    abstract protected function expectedTableName(): string;

    abstract protected function expectedTraits(): array;

    abstract protected function expectedFillable(): array;

    abstract protected function expectedHidden(): array;

    abstract protected function expectedCasts(): array;

    /**
     * Overwrite this function if model doesn't have an auto incrementing id
     */
    protected function expectedIncrementing(): bool
    {
        return true; // Auto increment ID
        // return false; // UUID
    }

    /**
     * Overwrite this function if model primary key is different than int
     */
    protected function expectedPrimaryKeyType(): ?string
    {
        return 'int'; // integer ID
        // return 'string'; // UUID;
    }

    /*
     * =================================================================================================================
     * Tests
     * =================================================================================================================
     */
    public function test_table_name()
    {
        $table = $this->model()->getTable();

        $expectedTable = $this->expectedTableName();

        $this->assertEquals($table, $expectedTable);
    }

    public function test_primary_key_type()
    {
        $keyType = $this->model()->getKeyType();

        $expectedKeyType = $this->expectedPrimaryKeyType();

        $this->assertEquals($keyType, $expectedKeyType);
    }

    public function test_traits()
    {
        $traits = class_uses($this->model());    // Return Traits of class
        $traits = array_keys($traits);

        $expectedTraits = $this->expectedTraits();

        $this->assertEqualsCanonicalizing($expectedTraits, $traits);
    }

    public function test_fillable()
    {
        $fillable = $this->model()->getFillable();

        $expectedFillable = $this->expectedFillable();

        // Both arrays are equal doesn't matter the order
        $this->assertEqualsCanonicalizing($expectedFillable, $fillable);
    }

    public function test_hidden()
    {
        $hidden = $this->model()->getHidden();

        $expectedHidden = $this->expectedHidden();

        // Both arrays are equal doesn't matter the order
        $this->assertEqualsCanonicalizing($expectedHidden, $hidden);
    }

    public function test_casts()
    {
        $casts = $this->model()->getCasts();

        $expectedCasts = $this->expectedCasts();

        // Both arrays are equal doesn't matter the order
        $this->assertEqualsCanonicalizing($expectedCasts, $casts);
    }

    public function test_incrementing()
    {
        $incrementing = $this->model()->incrementing;

        $expectedIncrementing = $this->expectedIncrementing();

        // Both arrays are equal doesn't matter the order
        $this->assertEquals($expectedIncrementing, $incrementing);
    }

    /*
     * =================================================================================================================
     * Auxiliary Methods
     * =================================================================================================================
     */
    protected function defaultCasts(): array
    {
        return [
            'id' => 'int',
            'created_at' => 'datetime:Y-m-d H:i:s',
            'updated_at' => 'datetime:Y-m-d H:i:s',
        ];
    }
}
