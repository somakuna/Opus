<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;

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
        'start_date'      => 'required|date',
        'end_date'        => 'nullable|date|after_or_equal:start_date',
        'frequency_value' => 'required|integer|min:1',
        'frequency_unit'  => 'required|string|in:day,week,month,year',
        'price'           => 'nullable|numeric|min:0',
        'status'          => 'required|string|in:active,paused,ended',
    ];

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.circular.create-circular');
    }

    public function create()
    {
        if (! Auth::user())
            abort(403);
        $validated = $this->validate();
        Circular::create($validated);
        return redirect()->route('circular.index');
    }
}
