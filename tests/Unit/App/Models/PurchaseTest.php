<?php

namespace Tests\Unit\App\Models;

use App\Models\Purchase;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Tests\Unit\App\Models\Contracts\ModelTestCase;

class PurchaseTest extends ModelTestCase
{
    protected function model(): Model
    {
        return new Purchase;
    }

    protected function expectedTableName(): string
    {
        return 'purchases';
    }

    protected function expectedTraits(): array
    {
        return [
            HasUuids::class,
        ];
    }

    protected function expectedFillable(): array
    {
        return [
            'name',
            'email',
            'phone',
            'ebook_id',
            'stripe_checkout_session_id',
            'stripe_payment_intent_id',
            'amount',
            'currency',
            'status',
            'completed_at',
        ];
    }

    protected function expectedHidden(): array
    {
        return [];
    }

    protected function expectedCasts(): array
    {
        return [
            'amount' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    protected function expectedIncrementing(): bool
    {
        // HasUuids trait doesn't automatically set incrementing to false
        // The model still has incrementing = true by default
        // This is expected behavior - UUIDs are generated but incrementing is still true
        return true;
    }

    protected function expectedPrimaryKeyType(): ?string
    {
        return 'string'; // UUID
    }

    /*
     * =================================================================================================================
     * Purchase Model Tests
     * =================================================================================================================
     */

    public function test_purchase_can_be_instantiated(): void
    {
        $purchase = new Purchase;
        $purchase->name = 'John Doe';
        $purchase->email = 'john@example.com';
        $purchase->phone = '1234567890';
        $purchase->ebook_id = 1;
        $purchase->stripe_payment_intent_id = 'pi_test123';
        $purchase->amount = 29.99;
        $purchase->currency = 'usd';
        $purchase->status = 'completed';

        $this->assertEquals('John Doe', $purchase->name);
        $this->assertEquals('john@example.com', $purchase->email);
        $this->assertEquals('1234567890', $purchase->phone);
        $this->assertEquals(1, $purchase->ebook_id);
        $this->assertEquals('pi_test123', $purchase->stripe_payment_intent_id);
        $this->assertEquals(29.99, $purchase->amount);
        $this->assertEquals('usd', $purchase->currency);
        $this->assertEquals('completed', $purchase->status);
    }
}
