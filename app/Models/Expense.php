<?php

namespace App\Models;

use App\Models\Concerns\HasRecurringSchedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expense extends Model
{
    use HasFactory, HasRecurringSchedule;

    protected $guarded = [];

    protected $casts = [
        'name' => 'encrypted',
        'description' => 'encrypted',
        'start_date' => 'date',
        'end_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function payments(): HasMany
    {
        return $this->hasMany(ExpensePayment::class);
    }

    /** Alias the schedule trait works against. */
    public function settlements(): HasMany
    {
        return $this->payments();
    }

    public function occurrenceAmount(): ?float
    {
        return $this->amount === null ? null : (float) $this->amount;
    }
}
