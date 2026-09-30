<?php

namespace App\Models\Concerns;

use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Shared schedule maths for periodic records (Circular jobs, Expenses).
 *
 * The model must provide start_date, end_date, frequency_value, frequency_unit,
 * a settlements() relation and an occurrenceAmount().
 */
trait HasRecurringSchedule
{
    /** Hard cap so a daily schedule spanning many years can't run away. */
    protected int $maxOccurrences = 2000;

    /** Price of a single occurrence, used when a settlement has no amount of its own. */
    abstract public function occurrenceAmount(): ?float;

    protected function scheduleStep(): int
    {
        return max(1, (int) $this->frequency_value);
    }

    /**
     * The i-th occurrence (0-based), always measured from start_date so that
     * month-end dates don't drift (31.01. + 1 month + 1 month stays 31.03.).
     * NoOverflow keeps a 31st clamped to the last day of a shorter month
     * instead of spilling into the next one.
     */
    public function occurrenceAt(int $index): Carbon
    {
        $start = $this->start_date->copy()->startOfDay();
        $steps = $this->scheduleStep() * $index;

        return match ($this->frequency_unit) {
            'day'   => $start->addDays($steps),
            'week'  => $start->addWeeks($steps),
            'year'  => $start->addYearsNoOverflow($steps),
            default => $start->addMonthsNoOverflow($steps),
        };
    }

    /** Every due date from start_date up to $until (default today), capped by end_date. */
    public function occurrenceDates(?Carbon $until = null): Collection
    {
        if (! $this->start_date) {
            return collect();
        }

        $until = ($until ?? Carbon::today())->copy()->startOfDay();

        if ($this->end_date && $this->end_date->lt($until)) {
            $until = $this->end_date->copy()->startOfDay();
        }

        $dates = collect();

        for ($i = 0; $i < $this->maxOccurrences; $i++) {
            $date = $this->occurrenceAt($i);

            if ($date->gt($until)) {
                break;
            }

            $dates->push($date);
        }

        return $dates;
    }

    /** Due dates so far, each paired with its settlement row (null when not settled yet). */
    public function scheduleRows(): Collection
    {
        $settled = $this->settlements->keyBy(fn ($settlement) => $settlement->due_date->format('Y-m-d'));

        return $this->occurrenceDates()->map(fn (Carbon $date, int $i) => [
            'number'     => $i + 1,
            'date'       => $date,
            'settlement' => $settled->get($date->format('Y-m-d')),
        ]);
    }

    /** How many times this should have happened by today. */
    public function getDueCountAttribute(): int
    {
        return $this->occurrenceDates()->count();
    }

    public function getSettledCountAttribute(): int
    {
        $dates = $this->occurrenceDates()->map(fn (Carbon $date) => $date->format('Y-m-d'));

        return $this->settlements
            ->filter(fn ($settlement) => $dates->contains($settlement->due_date->format('Y-m-d')))
            ->count();
    }

    public function getUnsettledCountAttribute(): int
    {
        return max(0, $this->due_count - $this->settled_count);
    }

    public function getSettledAmountAttribute(): float
    {
        $dates = $this->occurrenceDates()->map(fn (Carbon $date) => $date->format('Y-m-d'));

        return (float) $this->settlements
            ->filter(fn ($settlement) => $dates->contains($settlement->due_date->format('Y-m-d')))
            ->sum(fn ($settlement) => (float) ($settlement->amount ?? $this->occurrenceAmount() ?? 0));
    }

    public function getUnsettledAmountAttribute(): float
    {
        return $this->unsettled_count * (float) ($this->occurrenceAmount() ?? 0);
    }

    /** First occurrence that is still ahead of us, or null once the schedule is over. */
    public function getNextDueDateAttribute(): ?Carbon
    {
        if (! $this->start_date) {
            return null;
        }

        $today = Carbon::today();

        for ($i = 0; $i < $this->maxOccurrences; $i++) {
            $date = $this->occurrenceAt($i);

            if ($date->gte($today)) {
                return $this->end_date && $date->gt($this->end_date) ? null : $date;
            }
        }

        return null;
    }

    public function getFrequencyLabelAttribute(): string
    {
        $value = $this->scheduleStep();
        $unit = $value === 1 ? $this->frequency_unit : $this->frequency_unit . 's';

        return $value . ' ' . $unit;
    }
}
