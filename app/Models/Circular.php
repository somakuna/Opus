<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Circular extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'client' => 'encrypted',
        'description' => 'encrypted',
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function getNextDueDateAttribute(): ?Carbon
    {
        $start = $this->start_date->copy();
        $now = Carbon::today();

        if ($start->greaterThan($now)) {
            return $start;
        }

        while ($start->lessThan($now)) {
            $start = match ($this->frequency_unit) {
                'day' => $start->addDays($this->frequency_value),
                'week' => $start->addWeeks($this->frequency_value),
                'month' => $start->addMonths($this->frequency_value),
                'year' => $start->addYears($this->frequency_value),
                default => $start->addMonths($this->frequency_value),
            };
        }

        return $start;
    }

    public function getFrequencyLabelAttribute(): string
    {
        $unit = $this->frequency_value === 1 ? $this->frequency_unit : $this->frequency_unit . 's';
        return $this->frequency_value . ' ' . $unit;
    }
}
