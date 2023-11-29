<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Http\Controllers\WorkController;
use Livewire\Component;

class IndexWork extends Component
{

    public $error;

    public function render()
    {
        if (! Auth::user())
            abort(403);
        return view('livewire.work.index-work', [
            'works' => Work::with('partner', 'loan')->get()
        ]);
    }
    
    public function changeStatus($id, $parameter)
    {
        if (! Auth::user())
            abort(403);
        $work = Work::find($id);
        $work->$parameter = !$work->$parameter;
        $work->save();
    }

    public function print($id)
    {
        if (! Auth::user())
            abort(403);
        $work = Work::find($id);
        $work->printed = !$work->printed;
        $work->save();
        //return redirect()->action([WorkController::class, 'print'], ['work' => $work]);
        //return redirect('work.print', ['work' => $work]);
        //return redirect()->route('work.print', ['work' => $work]);
    }

    public function increasePriority($id)
    {
        if (! Auth::user())
            abort(403);
        $work = Work::find($id);
        if($work->priority >= 3) {
            return 0;
        }
        $work->priority ++;
        $work->save();
    }

    public function decreasePriority($id)
    {
        if (! Auth::user())
            abort(403);
        $work = Work::find($id);
        if($work->priority <= 0) {
            return 0;
        }     
        $work->priority --;
        $work->save();
    }

    public function delete($id)
    {
        if (! Auth::user())
            abort(403);
        Work::where('id', $id)->delete();
    }
    
}
