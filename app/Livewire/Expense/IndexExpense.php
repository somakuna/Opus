<?php

namespace App\Livewire\Expense;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Expense;
use App\Models\ExpensePayment;
use Carbon\Carbon;

class IndexExpense extends Component
{
    public $search = '';
    public $filterStatus = '';

    /** Id of the row whose occurrence history is open, if any. */
    public $expanded = null;

    public function render()
    {
        if (! Auth::user())
            abort(403);

        $query = Expense::with('payments')->latest();

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $expenses = $query->get();

        if ($this->search) {
            $search = mb_strtolower($this->search);
            $expenses = $expenses->filter(function ($e) use ($search) {
                return str_contains(mb_strtolower($e->name), $search)
                    || str_contains(mb_strtolower($e->description ?? ''), $search);
            })->values();
        }

        return view('livewire.expense.index-expense', [
            'expenses' => $expenses,
            'totalDue' => $expenses->sum(fn ($e) => $e->due_count),
            'totalPaid' => $expenses->sum(fn ($e) => $e->settled_count),
            'outstandingAmount' => $expenses->sum(fn ($e) => $e->unsettled_amount),
        ]);
    }

    public function toggleExpand($id)
    {
        $this->expanded = $this->expanded === $id ? null : $id;
    }

    /** Flip a single occurrence between paid and not paid. */
    public function togglePayment($id, $date)
    {
        if (! Auth::user())
            abort(403);

        $expense = Expense::findOrFail($id);
        $dueDate = Carbon::parse($date)->startOfDay();

        $payment = ExpensePayment::where('expense_id', $expense->id)
            ->whereDate('due_date', $dueDate)
            ->first();

        if ($payment) {
            $payment->delete();
            return;
        }

        ExpensePayment::create([
            'expense_id' => $expense->id,
            'due_date' => $dueDate->format('Y-m-d'),
            'paid_at' => Carbon::today()->format('Y-m-d'),
            'amount' => $expense->occurrenceAmount(),
        ]);
    }

    /** Mark every occurrence due so far as paid. */
    public function payAll($id)
    {
        if (! Auth::user())
            abort(403);

        $expense = Expense::with('payments')->findOrFail($id);
        $existing = $expense->payments->map(fn ($p) => $p->due_date->format('Y-m-d'))->all();

        foreach ($expense->occurrenceDates() as $date) {
            if (in_array($date->format('Y-m-d'), $existing, true)) {
                continue;
            }

            ExpensePayment::create([
                'expense_id' => $expense->id,
                'due_date' => $date->format('Y-m-d'),
                'paid_at' => Carbon::today()->format('Y-m-d'),
                'amount' => $expense->occurrenceAmount(),
            ]);
        }
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);
        Expense::where('id', $id)->delete();
    }

    public function toggleStatus($id)
    {
        if (! Auth::user())
            abort(403);
        $expense = Expense::findOrFail($id);
        $expense->status = match ($expense->status) {
            'active' => 'paused',
            'paused' => 'active',
            'ended' => 'active',
        };
        $expense->save();
    }
}
