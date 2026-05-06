<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;
use Carbon\Carbon;

class EditCircular extends Component
{
    public Circular $circular;
    public $start_date = '';
    public $end_date = '';

    protected array $rules = [
        'circular.client'          => 'required|string|max:255',
        'circular.type'            => 'required|string',
        'circular.description'     => 'nullable|string',
        'start_date'               => 'required|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'end_date'                 => 'nullable|string|regex:/^\d{1,2}\.\d{1,2}\.\d{4}\.?$/',
        'circular.frequency_value' => 'required|integer|min:1',
        'circular.frequency_unit'  => 'required|string|in:day,week,month,year',
        'circular.price'           => 'nullable|numeric|min:0',
        'circular.status'          => 'required|string|in:active,paused,ended',
    ];

    protected $messages = [
        'start_date.regex' => 'Format: dd.mm.yyyy.',
        'end_date.regex'   => 'Format: dd.mm.yyyy.',
    ];

    public function mount(Circular $circular)
    {
        $this->circular = $circular;
        $this->start_date = $circular->start_date ? $circular->start_date->format('d.m.Y.') : '';
        $this->end_date = $circular->end_date ? $circular->end_date->format('d.m.Y.') : '';
    }

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.circular.edit-circular');
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
        $this->circular->start_date = $this->parseDate($this->start_date);
        $this->circular->end_date = $this->parseDate($this->end_date);
        $this->circular->save();
        return redirect()->route('circular.index');
    }
}
