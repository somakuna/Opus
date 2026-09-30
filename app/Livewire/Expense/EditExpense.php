<?php

namespace App\Livewire\Expense;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Expense;
use Carbon\Carbon;

class EditExpense extends Component
{
    public Expense $expense;
    public $start_date = '';
    public $end_date = '';

    protected array $rules = [
        'expense.name'            => 'required|string|max:255',
        'expense.type'            => 'required|string',
        'expense.description'     => 'nullable|string',
        'start_date'              => 'required|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'end_date'                => 'nullable|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'expense.frequency_value' => 'required|integer|min:1',
        'expense.frequency_unit'  => 'required|string|in:day,week,month,year',
        'expense.amount'          => 'nullable|numeric|min:0',
        'expense.status'          => 'required|string|in:active,paused,ended',
    ];

    protected $messages = [
        'start_date.regex' => 'Format: dd.mm.yyyy.',
        'end_date.regex'   => 'Format: dd.mm.yyyy.',
    ];

    public function mount(Expense $expense)
    {
        $this->expense = $expense;
        $this->start_date = $expense->start_date ? $expense->start_date->format('d.m.Y.') : '';
        $this->end_date = $expense->end_date ? $expense->end_date->format('d.m.Y.') : '';
    }

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.expense.edit-expense');
    }

    private function parseDate($value): ?string
    {
        if (empty($value)) return null;
        $value = rtrim($value, '.');
        $parts = explode('.', $value);
        if (count($parts) !== 3) return null;
        return Carbon::createFromFormat('d.m.Y', "{$parts[0]}.{$parts[1]}.{$parts[2]}")->format('Y-m-d');
    }

    public function update()
    {
        if (! Auth::user())
            abort(403);
        $this->validate();
        $this->expense->start_date = $this->parseDate($this->start_date);
        $this->expense->end_date = $this->parseDate($this->end_date);
        $this->expense->save();
        return redirect()->route('expense.index');
    }
}
