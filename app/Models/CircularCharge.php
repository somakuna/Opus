<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CircularCharge extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'charged_at' => 'date',
        'amount' => 'decimal:2',
        'note' => 'encrypted',
    ];

    public function circular(): BelongsTo
    {
        return $this->belongsTo(Circular::class);
    }
}
