<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Livewire\Component;

class ShowDeletedWork extends Component
{

    public $error;
    public $search = '';

    public function render()
    {
        if (! Auth::user())
            abort(403);

        $works = Work::onlyTrashed()->with('partner')->latest()->get();

        if ($this->search) {
            $search = mb_strtolower($this->search);
            $works = $works->filter(function ($work) use ($search) {
                return str_contains(mb_strtolower($work->client), $search)
                    || str_contains(mb_strtolower($work->description ?? ''), $search);
            })->values();
        }

        return view('livewire.work.show-deleted-work', [
            'works' => $works,
        ]);
    }
    
    public function restore($id)
    {
        if (! Auth::user())
            abort(403);
        Work::where('id', $id)->restore();
    }

    public function forceDelete($id)
    {
        if (! Auth::user())
            abort(403);
        Work::where('id', $id)->forceDelete();
    }
}
