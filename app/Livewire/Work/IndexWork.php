<?php

namespace App\Livewire\Work;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Http\Controllers\WorkController;
use Livewire\Component;

class IndexWork extends Component
{

    public $error;
    public $viewMode = 'kanban';

    /** Search across client, description, note, partner and #id. */
    public $search = '';

    /** One of: all, active, unpaid, ready, completed. */
    public $filter = 'all';

    /** Card density on the board: comfortable or compact. */
    public $density = 'comfortable';

    public function render()
    {
        if (! Auth::user())
            abort(403);

        $all = Work::with('partner', 'loan')->orderBy('id')->get();
        $works = $this->applyFilters($all);

        return view('livewire.work.index-work', [
            'works' => $works,
            'totalCount' => $all->count(),
            'shownCount' => $works->count(),
        ]);
    }

    /**
     * Client, description and note are encrypted, so searching has to happen
     * in PHP on the decrypted collection rather than in SQL.
     */
    private function applyFilters($works)
    {
        $works = match ($this->filter) {
            'active'    => $works->reject(fn ($w) => $w->delivered && $w->paid),
            'unpaid'    => $works->filter(fn ($w) => ! $w->paid),
            'ready'     => $works->filter(fn ($w) => $w->ready && ! $w->delivered),
            'completed' => $works->filter(fn ($w) => $w->delivered && $w->paid),
            default     => $works,
        };

        $search = trim(mb_strtolower($this->search));

        if ($search !== '') {
            $needle = ltrim($search, '#');

            $works = $works->filter(function ($w) use ($search, $needle) {
                return str_contains(mb_strtolower($w->client), $search)
                    || str_contains(mb_strtolower($w->description ?? ''), $search)
                    || str_contains(mb_strtolower($w->note ?? ''), $search)
                    || str_contains(mb_strtolower($w->partner->name ?? ''), $search)
                    || (string) $w->id === $needle;
            });
        }

        return $works->values();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->filter = 'all';
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
        //$work->printed = !$work->printed;
        $work->printed = 1;
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
