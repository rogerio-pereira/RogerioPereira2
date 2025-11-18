<?php

namespace Tests\Unit\App\Models;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class ContactTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Contact;
    }

    protected function expectedTableName(): string
    {
        return 'contacts';
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
            'buyer',
            'do_not_contact',
            'marketing',
            'automation',
            'software_development',
        ];
    }

    protected function expectedHidden(): array
    {
        return [];
    }

    protected function expectedCasts(): array
    {
        return [
            'buyer' => 'boolean',
            'do_not_contact' => 'boolean',
            'marketing' => 'boolean',
            'automation' => 'boolean',
            'software_development' => 'boolean',
            'created_at' => 'datetime:d/m/Y H:i',
            'updated_at' => 'datetime:d/m/Y H:i',
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
     * Contact Model Tests
     * =================================================================================================================
     */

    public function test_contact_can_be_instantiated(): void
    {
        $contact = new Contact;
        $contact->name = 'John Doe';
        $contact->email = 'john@example.com';
        $contact->phone = '+1234567890';
        $contact->buyer = false;

        $this->assertEquals('John Doe', $contact->name);
        $this->assertEquals('john@example.com', $contact->email);
        $this->assertEquals('+1234567890', $contact->phone);
        $this->assertFalse($contact->buyer);
    }
}
