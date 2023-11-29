<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;

class Work extends Model
{
    use HasFactory, Prunable, SoftDeletes;

    protected $guarded = [];

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => Carbon::create($value)->format('d.m.Y. H:i')
        );
    }

    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function loan(): HasOne
    {
        return $this->hasOne(Loan::class);
    }
}
