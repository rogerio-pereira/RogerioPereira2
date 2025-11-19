<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Briefing extends Model
{
    use HasFactory, HasUuids;

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'briefing',
        'status',
    ];

    protected $casts = [
        'briefing' => 'array',
    ];
}
