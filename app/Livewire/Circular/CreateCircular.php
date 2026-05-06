<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;
use Carbon\Carbon;

class CreateCircular extends Component
{
    public $client = '';
    public $type = 'License';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $frequency_value = 1;
    public $frequency_unit = 'month';
    public $price = '';
    public $status = 'active';

    protected $rules = [
        'client'          => 'required|string|max:255',
        'type'            => 'required|string',
        'description'     => 'nullable|string',
        'start_date'      => 'required|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'end_date'        => 'nullable|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'frequency_value' => 'required|integer|min:1',
        'frequency_unit'  => 'required|string|in:day,week,month,year',
        'price'           => 'nullable|numeric|min:0',
        'status'          => 'required|string|in:active,paused,ended',
    ];

    protected $messages = [
        'start_date.regex' => 'Format: dd.mm.yyyy.',
        'end_date.regex'   => 'Format: dd.mm.yyyy.',
    ];

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.circular.create-circular');
    }

    private function parseDate($value): ?string
    {
        if (empty($value)) return null;
        $value = rtrim($value, '.');
        $parts = explode('.', $value);
        if (count($parts) !== 3) return null;
        return Carbon::createFromFormat('d.m.Y', "{$parts[0]}.{$parts[1]}.{$parts[2]}")->format('Y-m-d');
    }

    public function create()
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        $validated['start_date'] = $this->parseDate($this->start_date);
        $validated['end_date'] = $this->parseDate($this->end_date);
        Circular::create($validated);
        return redirect()->route('circular.index');
    }
}
