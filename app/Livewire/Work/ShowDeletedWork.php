<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use Livewire\Component;

class ShowDeletedWork extends Component
{

    public $error;

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.work.show-deleted-work',[
            'works' => Work::onlyTrashed()->with('partner')->latest()->simplePaginate(50),
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
