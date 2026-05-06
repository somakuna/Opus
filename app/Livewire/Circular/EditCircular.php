<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;

class EditCircular extends Component
{
    public Circular $circular;

    protected array $rules = [
        'circular.client'          => 'required|string|max:255',
        'circular.type'            => 'required|string',
        'circular.description'     => 'nullable|string',
        'circular.start_date'      => 'required|date',
        'circular.end_date'        => 'nullable|date',
        'circular.frequency_value' => 'required|integer|min:1',
        'circular.frequency_unit'  => 'required|string|in:day,week,month,year',
        'circular.price'           => 'nullable|numeric|min:0',
        'circular.status'          => 'required|string|in:active,paused,ended',
    ];

    public function mount(Circular $circular)
    {
        $this->circular = $circular;
    }

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.circular.edit-circular');
    }

    public function update()
    {
        if (! Auth::user())
            abort(403);
        $this->validate();
        $this->circular->save();
        return redirect()->route('circular.index');
    }
}
