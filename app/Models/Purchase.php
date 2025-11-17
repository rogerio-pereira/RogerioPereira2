<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
        'download_hash',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Get the ebook that was purchased.
     */
    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class);
    }
}
