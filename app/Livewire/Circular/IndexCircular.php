<?php

namespace App\Livewire\Circular;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Circular;

class IndexCircular extends Component
{
    public $search = '';
    public $filterStatus = '';

    public function render()
    {
        if (! Auth::user())
            abort(403);

        $query = Circular::latest();

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
        ]);
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
