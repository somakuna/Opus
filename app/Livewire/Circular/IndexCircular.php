<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;
use App\Models\CircularCharge;
use Carbon\Carbon;

class IndexCircular extends Component
{
    public $search = '';
    public $filterStatus = '';

    /** Id of the row whose occurrence history is open, if any. */
    public $expanded = null;

    public function render()
    {
        if (! Auth::user())
            abort(403);

        $query = Circular::with('charges')->latest();

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $circulars = $query->get();

        if ($this->search) {
            $search = mb_strtolower($this->search);
            $circulars = $circulars->filter(function ($c) use ($search) {
                return str_contains(mb_strtolower($c->client), $search)
                    || str_contains(mb_strtolower($c->description ?? ''), $search);
            })->values();
        }

        return view('livewire.circular.index-circular', [
            'circulars' => $circulars,
            'totalDue' => $circulars->sum(fn ($c) => $c->due_count),
            'totalCharged' => $circulars->sum(fn ($c) => $c->settled_count),
            'outstandingAmount' => $circulars->sum(fn ($c) => $c->unsettled_amount),
        ]);
    }

    public function toggleExpand($id)
    {
        $this->expanded = $this->expanded === $id ? null : $id;
    }

    /** Flip a single occurrence between charged and not charged. */
    public function toggleCharge($id, $date)
    {
        if (! Auth::user())
            abort(403);

        $circular = Circular::findOrFail($id);
        $dueDate = Carbon::parse($date)->startOfDay();

        $charge = CircularCharge::where('circular_id', $circular->id)
            ->whereDate('due_date', $dueDate)
            ->first();

        if ($charge) {
            $charge->delete();
            return;
        }

        CircularCharge::create([
            'circular_id' => $circular->id,
            'due_date' => $dueDate->format('Y-m-d'),
            'charged_at' => Carbon::today()->format('Y-m-d'),
            'amount' => $circular->occurrenceAmount(),
        ]);
    }

    /** Mark every occurrence due so far as charged. */
    public function chargeAll($id)
    {
        if (! Auth::user())
            abort(403);

        $circular = Circular::with('charges')->findOrFail($id);
        $existing = $circular->charges->map(fn ($c) => $c->due_date->format('Y-m-d'))->all();

        foreach ($circular->occurrenceDates() as $date) {
            if (in_array($date->format('Y-m-d'), $existing, true)) {
                continue;
            }

            CircularCharge::create([
                'circular_id' => $circular->id,
                'due_date' => $date->format('Y-m-d'),
                'charged_at' => Carbon::today()->format('Y-m-d'),
                'amount' => $circular->occurrenceAmount(),
            ]);
        }
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);
        Circular::where('id', $id)->delete();
    }

    public function toggleStatus($id)
    {
        if (! Auth::user())
            abort(403);
        $circular = Circular::findOrFail($id);
        $circular->status = match ($circular->status) {
            'active' => 'paused',
            'paused' => 'active',
            'ended' => 'active',
        };
        $circular->save();
    }
}
