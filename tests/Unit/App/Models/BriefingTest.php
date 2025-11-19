<?php

namespace Tests\Unit\App\Models;

use App\Models\Briefing;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class BriefingTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Briefing;
    }

    protected function expectedTableName(): string
    {
        return 'briefings';
    }

    protected function expectedTraits(): array
    {
        return [
            HasFactory::class,
            HasUuids::class,
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'name',
            'email',
            'phone',
            'briefing',
            'status',
        ];
    }

    protected function expectedHidden(): array
    {
        return [];
    }

    protected function expectedCasts(): array
    {
        return [
            'briefing' => 'array',
        ];
    }

    protected function expectedIncrementing(): bool
    {
        return false; // UUID
    }

    protected function expectedPrimaryKeyType(): ?string
    {
        return 'string'; // UUID
    }

    /*
     * =================================================================================================================
     * Briefing Model Tests
     * =================================================================================================================
     */

    public function test_briefing_can_be_instantiated(): void
    {
        $briefing = new Briefing;
        $briefing->name = 'John Doe';
        $briefing->email = 'john@example.com';
        $briefing->phone = '+1234567890';
        $briefing->status = 'new';
        $briefing->briefing = [
            'sections' => [
                'business_info' => [
                    ['Business segment', 'E-commerce'],
                ],
            ],
        ];

        $this->assertEquals('John Doe', $briefing->name);
        $this->assertEquals('john@example.com', $briefing->email);
        $this->assertEquals('+1234567890', $briefing->phone);
        $this->assertEquals('new', $briefing->status);
        $this->assertIsArray($briefing->briefing);
    }
}
