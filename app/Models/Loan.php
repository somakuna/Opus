<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder; 
use Illuminate\Database\Eloquent\Collection; 
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 

class Loan extends Model
{
    use HasFactory, Prunable, SoftDeletes;

    protected $guarded = [];

    public function prunable()
    {
        return static::where('deleted_at', '<=', now()->subMonth());
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }
    
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
